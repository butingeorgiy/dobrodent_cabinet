<?php


Route::get('/', function () {
    return view('home');
});

Route::get('/patient', function () {
    return view('patient.index');
})->middleware('auth:patient');

Route::get('/patient/login', 'PatientController@showLoginForm')
    ->name('patient-login-form')
    ->middleware('guest:patient');

Route::get('/patient/registration', 'PatientController@showRegForm')
    ->name('patient-reg-form')
    ->middleware('guest:patient');

Route::post('/patient/login-by-password', 'PatientController@loginByPassword')
    ->name('patient-login-by-password');

Route::post('/patient/login-by-code', 'PatientController@loginByCode')
    ->name('patient-login-by-code');

Route::post('/patient/create', 'PatientController@create')
    ->name('create-patient');

# ---------------------------------------------------

Route::view('/administrator', 'administrator.index')
    ->middleware('auth:administrator');

Route::view('/administrator/login', 'administrator.login')
    ->middleware('guest:administrator');

Route::post('/administrator/login', 'AdministratorController@login')
    ->name('administrator-login');

# ---------------------------------------------------

Route::view('/doctor', 'doctor.index')
    ->middleware('auth:doctor');

Route::view('/doctor/login', 'doctor.login')
    ->middleware('guest:doctor');

Route::post('/doctor/login', 'DoctorController@login')
    ->name('doctor-login');
