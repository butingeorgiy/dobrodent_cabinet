<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\AuthorizationException;
use App\Facades\Authorization;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Occupation;
use App\Models\Patient;
use App\Models\Visit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $visits = Visit::with(['status', 'patient:id,first_name,last_name,middle_name'])
            ->where('doctor_id', Authorization::user()->id)
            ->where('visit_date', Carbon::now()->format('Y-m-d'))
            ->orderByDesc('id')
            ->get();

        $global = [];

        if ($request->has('q')) {
            if (!$request->get('q')) {
                $global = [];
            } else {
                $global['visits'] = Visit::search($request->get('q'), 0, true);
                $global['patients'] = Patient::searchByDoctor($request->get('q'), 0);
            }
        }

        return view('doctor.index', compact('visits', 'global'));
    }

    public function login(Request $request)
    {
        $this->validate(
            $request,
            [
                'login' => 'bail|required',
                'password' => 'bail|required'
            ],
            [
                'login.required' => 'Необходимо указать логин',
                'password.required' => 'Необходимо указать пароль'
            ]
        );

        $login = $request->post('login');
        $password = $request->post('password');

        try {
            $authCookies = Authorization::auth(
                'doctor',
                collect(compact(['login', 'password'])),
                'password',
                $request->post('save') === 'on'
            );

            return back()
                ->cookie('id', $authCookies['id'][0], $authCookies['id'][1])
                ->cookie('token', $authCookies['token'][0], $authCookies['token'][1])
                ->cookie('entityName', $authCookies['entityName'][0], $authCookies['entityName'][1]);

        } catch (AuthorizationException $e) {
            return back()
                ->withErrors($e->getMessage());
        } catch (Throwable $e) {
            return back()
                ->withErrors($e->getMessage());
        }
    }

    public function showProfileForm()
    {
        $doctor = Authorization::user();

        return view('doctor.profile', compact('doctor'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate(
            $request,
            [
                'password' => 'bail|required',
                'first_name' => 'bail|max:32',
                'last_name' => 'bail|max:32',
                'middle_name' => 'bail|max:32',
                'email' => 'bail|max:64',
                'gender' => 'bail|in:0,1',
                'birthday' => 'bail|date|date_format:Y-m-d'
            ],
            [
                'password.required' => 'Необходимо указать пароль',
                'first_name.max' => 'Имя не должно быть длинее 32 символов',
                'last_name.max' => 'Фамилия не должна быть длинее 32 символов',
                'middle_name.max' => 'Отчество не должно быть длинее 32 символов',
                'email.max' => 'E-mail не должен быть длинее 64 символов',
                'gender.in' => 'Необходимо указать пол',
                'birthday.date' => 'Необходимо указать дату рождения',
                'birthday.date_format' => 'Некорректный формат даты рождения'
            ]
        );

        try {
            $doctor = Authorization::user();

            if ($doctor->password !== hash('sha256', $request->post('password'))) {
                throw new Exception('Неверный пароль');
            }

            if ($request->post('first_name')) {
                $doctor->first_name = $request->post('first_name');
            }

            if ($request->post('last_name')) {
                $doctor->last_name = $request->post('last_name');
            }

            if ($request->post('middle_name')) {
                $doctor->middle_name = $request->post('middle_name');
            }

            if ($request->post('birthday')) {
                $doctor->birthday = $request->post('birthday');
            }

            if (in_array($request->post('gender'), ['0', '1'])) {
                $doctor->gender = $request->post('gender');
            }

            if ($request->post('email')) {
                $doctor->email = $request->post('email');
            }

            $doctor->save();

            if ($request->file('profile_photo')) {
                if ($request->file('profile_photo')->getSize() > 100000) {
                    throw new Exception('Изображение должно весить не более 100 кб');
                }

                if (!in_array($request->file('profile_photo')->getMimeType(), ['image/jpeg', 'image/jpg'])) {
                    throw new Exception('Допустимые форматы изображения: jpeg, jpg');
                }

                $fileName = $doctor->id . '.jpeg';

                $request->file('profile_photo')->storeAs('profile_photos/doctors', $fileName);
            }

        } catch (Throwable $e) {
            return back()
                ->withErrors($e->getMessage());
        }

        return back()
            ->with(['success' => 'Изменения успешно сохранены']);
    }

    public function logout(Request $request)
    {
        $doctor = Authorization::user();
        $tokenFromCookie = decrypt($request->cookie('token'));

        $doctor->invalidTokens()->delete();

        $availableTokens = $doctor->tokens()->get();

        foreach ($availableTokens as $token) {
            $tokenFromDb = hash('sha256', Str::limit($doctor->password, 10) . $_SERVER['HTTP_USER_AGENT'] . $token->token);
            if ($tokenFromDb === $tokenFromCookie) {
                $token->delete();
            }
        }

        return back()
            ->withCookie(Cookie::forget('id'))
            ->withCookie(Cookie::forget('token'))
            ->withCookie(Cookie::forget('entityName'));
    }

    public function showProfInfo()
    {
        return view('doctor.info')
            ->with([
                'occupations' => Occupation::all(),
                'doctor' => Authorization::user()
            ]);
    }

    public function updateProfInfo(Request $request)
    {
        $this->validate(
            $request,
            [
                'password' => 'required'
            ],
            [
                'password.required' => 'Необходимо указать пароль'
            ]
        );

        try {
            $doctor = Authorization::user();

            if ($doctor->password !== hash('sha256', $request->post('password'))) {
                throw new Exception('Неверный пароль');
            }

            if ($request->post('description') !== null) {
                $doctor->description = $request->post('description');
            }

            $doctor->save();

            if ($request->post('occupation') !== null) {
                $occupations = json_decode($request->post('occupation'));

                if (count($occupations) === 0) {
                    throw new Exception('Необходимо указать хотя бы одну специализацию');
                }

                $doctorsOccupations = $doctor->occupations();

                $doctorsOccupations->detach();

                $doctorsOccupations->attach($occupations);
            }

        } catch (Throwable $e) {
            return back()
                ->withErrors($e->getMessage());
        }

        return back()
            ->with(['success' => 'Изменения успешно сохранены']);
    }

    public function showPatients(Request $request)
    {
        $patients = Patient::searchByDoctor($request->get('q') ?: '', 0);

        return view('doctor.patients', compact('patients'));
    }

    public function showVisits()
    {
        $visits = Visit::with(['status', 'patient:id,first_name,last_name,middle_name'])
            ->where('doctor_id', Authorization::user()->id)
            ->orderByDesc('id')->limit(15)->get();

        $doctors = Doctor::select('id', 'full_name')->get();

        $patients = Patient::select('id', 'full_name')->get();

        return view('doctor.visits', compact('visits', 'doctors', 'patients'));
    }

    public function showPatient($id)
    {
        $patient = Patient::findOrFail($id);

        $patientAvatar = asset('images/default_profile.jpg');

        if (Storage::exists('profile_photos/patients/' . $patient->id . '.jpeg')) {
            $patientAvatar = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/patients/' . $patient->id . '.jpeg'));
        }

        $visits = Visit::with(['status'])
            ->where('patient_id', $id)
            ->where('doctor_id', Authorization::user()->id)
            ->orderByDesc('id')
            ->get();

        return view('doctor.patient', compact('patient', 'patientAvatar', 'visits'));
    }

    public function showCreateVisitForm()
    {
        $options = [
            [
                'id' => '',
                'title' => 'Выбрать доктора / клинику',
                'extra' => '',
                'photo' => asset('images/favicon.png')
            ]
        ];

        $clinics = Clinic::all();

        foreach ($clinics as $clinic) {
            $data = [];

            $data['id'] = 'c' . $clinic->id;
            $data['title'] = $clinic->name;
            $data['extra'] = $clinic->address ?: 'Адрес не указан';
            $data['photo'] = asset('images/clinic_default_profile.png');

            $options[] = $data;
        }


        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            $data = [];

            $data['id'] = 'd' . $doctor->id;
            $data['title'] = $doctor->full_name;

            $occupation = $doctor->occupations()->get()->first();

            $data['extra'] = $occupation->title ?? 'Нет специализации';

            $photo = asset('images/default_profile.jpg');

            if (Storage::exists('profile_photos/doctors/' . $doctor->id  . '.jpeg')) {
                $photo = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/doctors/' . $doctor->id  . '.jpeg'));
            }

            $data['photo'] = $photo;

            $options[] = $data;
        }

        $options = json_encode($options);

        $patientsOptions = [
            [
                'id' => '',
                'title' => 'Выбрать пациента',
                'photo' => asset('images/favicon.png')
            ]
        ];

        $patients = Patient::all();

        foreach ($patients as $patient) {
            $data = [];

            $data['id'] = $patient->id;
            $data['title'] = $patient->full_name;

            $photo = asset('images/default_profile.jpg');

            if (Storage::exists('profile_photos/patients/' . $patient->id  . '.jpeg')) {
                $photo = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/patients/' . $patient->id  . '.jpeg'));
            }

            $data['photo'] = $photo;

            $patientsOptions[] = $data;
        }

        $patientsOptions = json_encode($patientsOptions);

        return view('doctor.create-visit-form', compact('options', 'patientsOptions'));
    }
}
