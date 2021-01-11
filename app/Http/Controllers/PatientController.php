<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\AuthorizationException;
use App\Facades\Authorization;
use App\Facades\SafeVar;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class PatientController extends Controller
{
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
                    $phoneUuid = SafeVar::add($request->get('phone'));
                    $codeUuid = SafeVar::add(rand(0, 9) . rand(0, 9) . rand(0, 9). rand(0, 9));

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
                    $phoneUuid = SafeVar::add($request->get('phone'));
                    $codeUuid = SafeVar::add(rand(0, 9) . rand(0, 9) . rand(0, 9). rand(0, 9));

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
}
