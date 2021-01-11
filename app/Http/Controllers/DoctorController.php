<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\AuthorizationException;
use App\Facades\Authorization;
use Illuminate\Http\Request;
use Throwable;

class DoctorController extends Controller
{
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
}
