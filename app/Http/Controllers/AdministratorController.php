<?php

namespace App\Http\Controllers;

use App\Exceptions\Api\AuthorizationException;
use App\Facades\Authorization;
use Illuminate\Http\Request;
use Throwable;

class AdministratorController extends Controller
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
}
