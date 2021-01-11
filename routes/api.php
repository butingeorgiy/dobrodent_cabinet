<?php

use Illuminate\Http\Request;

Route::post('/patients/login', function (Request $request) {
    $authResponse = App\Facades\Authorization::auth('patient', collect($request->only(['phone', 'password'])), $request->input('authType'), $request->input('needToSave'));
    return response()
        ->json($authResponse);
});

Route::post('/patients/auth-check', function () {
    $isUserAuth = App\Facades\Authorization::check();
    return response()->json(['auth' => $isUserAuth]);
});

Route::post('/patients/is-exist/{field}/{phone}', 'Api\PatientController@isExist');
