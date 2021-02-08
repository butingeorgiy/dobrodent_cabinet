<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\AuthorizationException;
use App\Exceptions\Api\UncategorizedApiException;
use App\Facades\Authorization;
use App\Facades\SafeVar;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Illness;
use App\Models\Patient;
use App\Models\Visit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $visits = Visit::with(['status', 'doctor:id,first_name,last_name,middle_name'])
            ->where('patient_id', Authorization::user()->id)
            ->where('visit_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('visit_date', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
            ->orderByDesc('id')
            ->get();

        $global = [];

        if ($request->has('q')) {
            if (!$request->get('q')) {
                $global = [];
            } else {
                $global['doctors'] = Doctor::search($request->get('q'), 0, true);
                $global['visits'] = Visit::search($request->get('q'), 0, true);
            }
        }

        return view('patient.index', compact('visits', 'global'));
    }

    public function showMedicalCard()
    {
        $illnesses = Illness::with('status')->where('patient_id', Authorization::user()->id)->get();

        return view('patient.medical-card', compact('illnesses'));
    }

    public function showLoginForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required_if:step,2|numeric',
            'type' => 'required_if:step,2|in:code,password',
            'step' => 'required_with:phone,type|numeric|in:1,2',
            'save' => 'required_if:step,2|in:true,false'
        ]);

        if ($validator->fails()) { abort(404); }

        if ($request->get('step') === '2') {
            $patient = Patient::byPhone($request->get('phone'))->get()->first();

            if ($patient === null) { abort(404); }

            $request->flashOnly('phone');
        }

        if ($request->get('type') === 'code') {
            try {
                if (!$request->cookie('phone') or !$request->cookie('code')) {
                    $code = rand(0, 9) . rand(0, 9) . rand(0, 9). rand(0, 9);

                    $phoneUuid = SafeVar::add($request->get('phone'));
                    $codeUuid = SafeVar::add($code);

                    require app_path('/Services/smsCenter.php');

                    $codeSendStatus = send_sms(
                        $request->get('phone'),
                        'Код для входа в систему: ' . $code
                    );

                    if ($codeSendStatus[1] < 0) {
                        return back()
                            ->withErrors(['Не удалось отправить код доступа']);
                    }

                    return response()
                        ->view('patient.login')
                        ->cookie('phone', $phoneUuid, 1800 / 60)
                        ->cookie('code', $codeUuid, 1800 / 60);
                }

                return view('patient.login');
            } catch (Throwable $e) {
                abort(500, $e->getMessage());
            }
        }

        return response()
            ->view('patient.login')
            ->withCookie(Cookie::forget('phone'))
            ->withCookie(Cookie::forget('code'));
    }

    public function showRegForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required_with:step|numeric',
            'step' => 'required_with:phone,type|numeric|in:2,3'
        ]);

        if ($validator->fails()) { abort(404); }

        if ($request->get('phone')) {
            $patient = Patient::byPhone($request->get('phone'))->get()->first();

            if ($patient !== null) { abort(404); }
        }

        if ($request->get('step') === '2') {
            try {

                if (!$request->cookie('phone') or !$request->cookie('code')) {
                    $code = rand(0, 9) . rand(0, 9) . rand(0, 9). rand(0, 9);

                    $phoneUuid = SafeVar::add($request->get('phone'));
                    $codeUuid = SafeVar::add($code);

                    require app_path('/Services/smsCenter.php');

                    $codeSendStatus = send_sms(
                        $request->get('phone'),
                        'Код для входа в систему: ' . $code
                    );

                    if ($codeSendStatus[1] < 0) {
                        return back()
                            ->withErrors(['Не удалось отправить код доступа']);
                    }

                    return response()
                        ->view('patient.reg')
                        ->cookie('phone', $phoneUuid, 1800 / 60)
                        ->cookie('code', $codeUuid, 1800 / 60);
                }

                return view('patient.reg');
            } catch (Throwable $e) {
                abort(500, $e->getMessage());
            }
        }

        if ($request->get('step') === '3') {
            $phoneUuid = $request->cookie('phone');
            $codeUuid = $request->cookie('code');

            $phone = SafeVar::get($phoneUuid);
            $code = SafeVar::get($codeUuid);

            if (!$phone or !$code) { abort(500, 'Не удалось определить номер телефона или код'); }

            if ($phone !== $request->get('phone')) {
                return back()
                    ->withErrors(['А для чего ты изменил номер телефона?!?!']);
            }

            if ($code !== $request->get('code')) {
                return back()
                    ->withErrors(['Неверный код']);
            }

            return view('patient.reg');
        }

        return response()
            ->view('patient.reg')
            ->withCookie(Cookie::forget('phone'))
            ->withCookie(Cookie::forget('code'));
    }

    public function loginByPassword(Request $request) {
        $this->validate(
            $request,
            [
                'password' => 'bail|required',
                'phone' => 'bail|required'
            ],
            [
                'password.required' => 'Необходмо указать пароль',
                'phone.required' => 'А зачем ты убрал номер телефона?!?!'
            ]
        );

        if (old('phone') !== $request->post('phone')) {
            return back()
                ->withErrors(['Мы не допустим такого!']);
        }

        try {
            $authCookies = Authorization::auth(
                'patient',
                collect($request->only(['phone', 'password'])),
                'password',
                $request->post('needToSave') === 'true'
            );

            return back()
                ->cookie('id', $authCookies['id'][0], $authCookies['id'][1])
                ->cookie('token', $authCookies['token'][0], $authCookies['token'][1])
                ->cookie('entityName', $authCookies['entityName'][0], $authCookies['entityName'][1]);

        } catch (AuthorizationException $e) {
            return back()
                ->withErrors([$e->getMessage()]);
        } catch (Throwable $e) {
            abort(500, $e->getMessage());
        }

        return back()
            ->withErrors(['Произошла неизвестная ошибка... Попробуйте авторизоваться повторно']);
    }

    public function loginByCode(Request $request)
    {
        $this->validate(
            $request,
            ['code' => 'required'],
            ['code.required' => 'Необходмо ввести код']
        );

        try {
            $authCookies = Authorization::auth(
                'patient',
                collect($request->only(['code'])),
                'code',
                $request->post('needToSave') === 'true'
            );

            return back()
                ->cookie('id', $authCookies['id'][0], $authCookies['id'][1])
                ->cookie('token', $authCookies['token'][0], $authCookies['token'][1])
                ->cookie('entityName', $authCookies['entityName'][0], $authCookies['entityName'][1]);

        } catch (AuthorizationException $e) {
            return back()
                ->withErrors([$e->getMessage()]);
        } catch (Throwable $e) {
            abort(500, $e->getMessage());
        }

        return back()
            ->withErrors(['Произошла неизвестная ошибка... Попробуйте авторизоваться повторно']);
    }

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name' => 'bail|required|max:32',
                'last_name' => 'bail|required|max:32',
                'middle_name' => 'bail|max:32',
                'password' => 'bail|required|min:8|confirmed',
                'password_confirmation' => 'bail|required|min:8',
            ],
            [
                'first_name.required' => 'Необходмо указать имя',
                'first_name.max' => 'Имя не должно быть длинее 32 символов',
                'last_name.required' => 'Необходмо указать фамилию',
                'last_name.max' => 'Фамилия не должна быть длинее 32 символов',
                'middle_name.max' => 'Отчество не должно быть длинее 32 символов',
                'password.required' => 'Необходмо придумать пароль',
                'password.min' => 'Пароль не должен быть короче 8 символов',
                'password.confirmed' => 'Пароли не совпадают',
                'password_confirmation.required' => 'Необходимо подтвердить пароль',
                'password_confirmation.min' => 'Пароль не должен быть короче 8 символов'
            ]
        );

        $phone = SafeVar::get($request->cookie('phone'));
        $code = SafeVar::get($request->cookie('code'));

        if (!$phone or !$code) { abort(500, 'Не удалось определить номер телефона или код'); }

        $dataForCreating = $request->only(['first_name', 'last_name', 'password']);

        if ($request->post('middle_name')) {
            $dataForCreating['middle_name'] = $request->post('middle_name');
        }


        $dataForCreating['phone'] = substr($phone, -10);
        $dataForCreating['phone_code'] = Str::before($phone, $dataForCreating['phone']);

        Patient::create($dataForCreating);

        try {
            $authCookies = Authorization::auth(
                'patient',
                collect(compact('code')),
                'code'
            );

            return back()
                ->cookie('id', $authCookies['id'][0], $authCookies['id'][1])
                ->cookie('token', $authCookies['token'][0], $authCookies['token'][1])
                ->cookie('entityName', $authCookies['entityName'][0], $authCookies['entityName'][1])
                ->withCookie(Cookie::forget('phone'))
                ->withCookie(Cookie::forget('code'));

        } catch (AuthorizationException $e) {
            return back()
                ->withErrors($e->getMessage());
        } catch (Throwable $e) {
            abort(500, $e->getMessage());
        }
    }

    public function showProfileForm()
    {
        $patient = Authorization::user();

        return view('patient.profile', compact('patient'));
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
                'gender.in' => 'Некорректное значение gender',
                'birthday.date' => 'Некорректный тип birthday',
                'birthday.date_format' => 'Некорректный формат даты'
            ]
        );

        try {
            $patient = Authorization::user();

            if ($patient->password !== hash('sha256', $request->post('password'))) {
                throw new Exception('Неверный пароль');
            }

            if ($request->post('first_name')) {
                $patient->first_name = $request->post('first_name');
            }

            if ($request->post('last_name')) {
                $patient->last_name = $request->post('last_name');
            }

            if ($request->post('middle_name')) {
                $patient->middle_name = $request->post('middle_name');
            }

            if ($request->post('birthday')) {
                $patient->birthday = $request->post('birthday');
            }

            if (in_array($request->post('gender'), ['0', '1'])) {
                $patient->gender = $request->post('gender');
            }

            if ($request->post('email')) {
                $patient->email = $request->post('email');
            }

            $patient->save();

            if ($request->file('profile_photo')) {
                if ($request->file('profile_photo')->getSize() > 100000) {
                    throw new Exception('Изображение должно весить не более 100 кб');
                }

                if (!in_array($request->file('profile_photo')->getMimeType(), ['image/jpeg', 'image/jpg'])) {
                    throw new Exception('Допустимые форматы изображения: jpeg, jpg');
                }

                $fileName = $patient->id . '.jpeg';

                $request->file('profile_photo')->storeAs('profile_photos/patients', $fileName);
            }

        } catch (Throwable $e) {
            return back()
                ->withErrors($e->getMessage());
        }

        return back()
            ->with(['success' => 'Изменения успешно сохранены']);
    }

    public function showDoctors(Request $request)
    {
        $doctors = Doctor::search($request->get('q') ?: '', 0);

        return view('patient.doctors', compact('doctors'));
    }

    public function logout(Request $request)
    {
        $patient = Authorization::user();
        $tokenFromCookie = decrypt($request->cookie('token'));

        $patient->invalidTokens()->delete();

        $availableTokens = $patient->tokens()->get();

        foreach ($availableTokens as $token) {
            $tokenFromDb = hash('sha256', Str::limit($patient->password, 10) . $_SERVER['HTTP_USER_AGENT'] . $token->token);
            if ($tokenFromDb === $tokenFromCookie) {
                $token->delete();
            }
        }

        return back()
            ->withCookie(Cookie::forget('id'))
            ->withCookie(Cookie::forget('token'))
            ->withCookie(Cookie::forget('entityName'));
    }

    public function showVisits(Request $request)
    {
        $user = Authorization::user();

        $visits = Visit::with(['doctor:id,first_name,last_name,middle_name', 'status'])->where('patient_id', $user->id)->orderByDesc('id')->limit(15);

        if ($request->get('illness')) {
            $visits->where('illness_id', $request->get('illness'));
        }

        $visits = $visits->get();

        $illnesses = Illness::where('patient_id', $user->id)->get();

        return view('patient.visits', compact('visits', 'illnesses'));
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

        return view('patient.create-visit-form', compact('options'));
    }

    public function showDoctor($id) {
        $doctor = Doctor::findOrFail($id);

        $doctorPhones = $doctor->phones()->select('phone')->get();

        $doctorAvatar = asset('images/default_profile.jpg');

        if (Storage::exists('profile_photos/doctors/' . $doctor->id . '.jpeg')) {
            $doctorAvatar = 'data:image/jpg;base64,' . base64_encode(Storage::get('profile_photos/doctors/' . $doctor->id . '.jpeg'));
        }

        $visits = Visit::with(['doctor:id,first_name,last_name,middle_name', 'status'])
            ->where('patient_id', Authorization::user()->id)
            ->where('doctor_id', $id)
            ->orderByDesc('id')
            ->get();

        $likes = $doctor->likes()->get()->count();

        return view('patient.doctor', compact('doctor', 'doctorAvatar', 'visits', 'doctorPhones', 'likes'));
    }

    public function showClinics()
    {
        $clinics = Clinic::all();

        return view('patient.clinics', compact('clinics'));
    }
}
