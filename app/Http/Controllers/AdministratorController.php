<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\AuthorizationException;
use App\Facades\Authorization;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class AdministratorController extends Controller
{
    public function index(Request $request)
    {
        $global = [];

        if ($request->has('q')) {
            if (!$request->get('q')) {
                $global = [];
            } else {
                $global['doctors'] = Doctor::search($request->get('q'), 0, true);
                $global['visits'] = Visit::search($request->get('q'), 0, true);
                $global['patients'] = Patient::searchByAdministrator($request->get('q'), 0);
            }
        }

        return view('administrator.index', compact('global'));
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

        $phone = preg_replace('/[^\d]/', '', $request->post('login'));
        $password = $request->post('password');


        if (strlen($phone) < 11) {
            return back()
                ->withErrors('Слишком короткий номер телефона');
        }

        try {
            $authCookies = Authorization::auth(
                'administrator',
                collect(compact(['phone', 'password'])),
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

    public function logout(Request $request)
    {
        $administrator = Authorization::user();
        $tokenFromCookie = decrypt($request->cookie('token'));

        $administrator->invalidTokens()->delete();

        $availableTokens = $administrator->tokens()->get();

        foreach ($availableTokens as $token) {
            $tokenFromDb = hash('sha256', Str::limit($administrator->password, 10) . $_SERVER['HTTP_USER_AGENT'] . $token->token);
            if ($tokenFromDb === $tokenFromCookie) {
                $token->delete();
            }
        }

        return back()
            ->withCookie(Cookie::forget('id'))
            ->withCookie(Cookie::forget('token'))
            ->withCookie(Cookie::forget('entityName'));
    }

    public function showVisits()
    {
        $visits = Visit::with(['doctor:id,first_name,last_name,middle_name', 'status', 'patient:id,first_name,last_name,middle_name'])->orderByDesc('id')->limit(15)->get();

        $doctors = Doctor::select('id', 'full_name')->get();

        $patients = Patient::select('id', 'full_name')->get();

        return view('administrator.visits', compact('visits', 'doctors', 'patients'));
    }

    public function showDoctors(Request $request)
    {
        $doctors = Doctor::search($request->get('q') ?: '', 0);

        return view('administrator.doctors', compact('doctors'));
    }

    public function showDoctor($id) {
        $doctor = Doctor::findOrFail($id);

        $doctorPhones = $doctor->phones()->select('phone')->get();

        $doctorAvatar = asset('images/default_profile.jpg');

        if (Storage::exists('profile_photos/doctors/' . $doctor->id . '.jpeg')) {
            $doctorAvatar = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/doctors/' . $doctor->id . '.jpeg'));
        }

        return view('administrator.doctor', compact('doctor', 'doctorAvatar', 'doctorPhones'));
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

        return view('administrator.create-visit-form', compact('options', 'patientsOptions'));
    }

    public function showPatients(Request $request)
    {
        $patients = Patient::searchByAdministrator($request->get('q') ?: '', 0);

        return view('administrator.patients', compact('patients'));
    }

    public function showPatient($id)
    {
        $patient = Patient::findOrFail($id);

        $patientAvatar = asset('images/default_profile.jpg');

        if (Storage::exists('profile_photos/patients/' . $patient->id . '.jpeg')) {
            $patientAvatar = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/patients/' . $patient->id . '.jpeg'));
        }

        $visits = Visit::with(['status', 'doctor:id,first_name,last_name,middle_name'])
            ->where('patient_id', $id)
            ->where('visit_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('visit_date', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
            ->orderByDesc('id')
            ->get();

        return view('administrator.patient', compact('patient', 'patientAvatar', 'visits'));
    }
}
