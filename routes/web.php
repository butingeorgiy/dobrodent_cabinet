<?php


Route::get('/', function () {
    return view('home');
});

Route::view('/patient', 'patient.index')
    ->middleware('auth:patient')
    ->name('patient-index');

Route::get('/patient/profile', 'PatientController@showProfileForm')
    ->middleware('auth:patient')
    ->name('patient-profile');

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

Route::post('/patient/profile/update', 'PatientController@updateProfile')
    ->middleware('auth:patient')
    ->name('patient-profile-update');

# ---------------------------------------------------

Route::view('/administrator', 'administrator.index')
    ->middleware('auth:administrator')
    ->name('administrator-index');

Route::view('/administrator/login', 'administrator.login')
    ->middleware('guest:administrator');

Route::post('/administrator/login', 'AdministratorController@login')
    ->name('administrator-login');

# ---------------------------------------------------

Route::view('/doctor', 'doctor.index')
    ->middleware('auth:doctor')
    ->name('doctor-index');

Route::view('/doctor/login', 'doctor.login')
    ->middleware('guest:doctor');

Route::post('/doctor/login', 'DoctorController@login')
    ->name('doctor-login');
