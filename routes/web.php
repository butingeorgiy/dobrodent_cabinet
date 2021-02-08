<?php

Route::view('/', 'home');

Route::get('/patient', 'PatientController@index')
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

Route::get('/patient/doctors', 'PatientController@showDoctors')
    ->middleware('auth:patient')
    ->name('patient-doctors');

Route::get('/patient/logout', 'PatientController@logout')
    ->middleware('auth:patient')
    ->name('patient-logout');

Route::get('/patient/visits', 'PatientController@showVisits')
    ->middleware('auth:patient')
    ->name('patient-visits');

Route::get('/patient/visits/create', 'VisitController@showCreationForm')
    ->middleware('auth:patient')
    ->name('patient-visits-create');

Route::get('/patient/doctors/{id}', 'PatientController@showDoctor')
    ->middleware('auth:patient')
    ->name('patient-doctor');

Route::get('/patient/visits/{id}', 'VisitController@showByPatient')
    ->middleware('auth:patient')
    ->name('patient-visit');

Route::get('/patient/medical-card', 'PatientController@showMedicalCard')
    ->middleware('auth:patient')
    ->name('patient-medical-card');

Route::get('/patient/clinics', 'PatientController@showClinics')
    ->middleware('auth:patient')
    ->name('patient-clinics');

# ---------------------------------------------------

Route::get('/administrator', 'AdministratorController@index')
    ->middleware('auth:administrator')
    ->name('administrator-index');

Route::view('/administrator/login', 'administrator.login')
    ->middleware('guest:administrator');

Route::post('/administrator/login', 'AdministratorController@login')
    ->name('administrator-login');

Route::get('/administrator/doctors', 'AdministratorController@showDoctors')
    ->middleware('auth:administrator')
    ->name('administrator-doctors');

Route::get('/administrator/doctors/{id}', 'AdministratorController@showDoctor')
    ->middleware('auth:administrator')
    ->name('administrator-doctor');

Route::get('/administrator/visits', 'AdministratorController@showVisits')
    ->middleware('auth:administrator')
    ->name('administrator-visits');

Route::get('/administrator/visits/create', 'VisitController@showCreationForm')
    ->middleware('auth:administrator')
    ->name('administrator-visits-create');

Route::get('/administrator/visits/{id}', 'VisitController@showByAdministrator')
    ->middleware('auth:administrator')
    ->name('administrator-visit');

Route::get('/administrator/logout', 'AdministratorController@logout')
    ->middleware('auth:administrator')
    ->name('administrator-logout');

Route::get('/administrator/patients', 'AdministratorController@showPatients')
    ->middleware('auth:administrator')
    ->name('administrator-patients');

Route::get('/administrator/patients/{id}', 'AdministratorController@showPatient')
    ->middleware('auth:administrator')
    ->name('administrator-patient');

# ---------------------------------------------------

Route::get('/doctor', 'DoctorController@index')
    ->middleware('auth:doctor')
    ->name('doctor-index');

Route::view('/doctor/login', 'doctor.login')
    ->middleware('guest:doctor');

Route::post('/doctor/login', 'DoctorController@login')
    ->name('doctor-login');

Route::get('/doctor/profile', 'DoctorController@showProfileForm')
    ->middleware('auth:doctor')
    ->name('doctor-profile');

Route::post('/doctor/profile/update', 'DoctorController@updateProfile')
    ->middleware('auth:doctor')
    ->name('doctor-profile-update');

Route::get('/doctor/logout', 'DoctorController@logout')
    ->middleware('auth:doctor')
    ->name('doctor-logout');

Route::get('/doctor/info', 'DoctorController@showProfInfo')
    ->middleware('auth:doctor')
    ->name('doctor-info');

Route::post('/doctor/info/update', 'DoctorController@updateProfInfo')
    ->middleware('auth:doctor')
    ->name('doctor-info-update');

Route::get('/doctor/patients', 'DoctorController@showPatients')
    ->middleware('auth:doctor')
    ->name('doctor-patients');

Route::get('/doctor/visits', 'DoctorController@showVisits')
    ->middleware('auth:doctor')
    ->name('doctor-visits');

Route::get('/doctor/visits/create', 'VisitController@showCreationForm')
    ->middleware('auth:doctor')
    ->name('doctor-visits-create');

Route::get('/doctor/visits/{id}', 'VisitController@showByDoctor')
    ->middleware('auth:doctor')
    ->name('doctor-visit');

Route::get('/doctor/patients/{id}', 'DoctorController@showPatient')
    ->middleware('auth:doctor')
    ->name('doctor-patient');

# ---------------------------------------------------

Route::post('/visits/doctor/upload-attachment/{id}', 'VisitController@attachFile')
    ->middleware('auth:doctor')
    ->name('upload-attachment');

Route::get('/visits/doctor/attachment/{id}', 'VisitController@downloadAttachment')
    ->middleware('auth:doctor')
    ->name('doctor-attachment');

Route::get('/visits/patient/attachment/{id}', 'VisitController@downloadAttachment')
    ->middleware('auth:patient')
    ->name('patient-attachment');

Route::get('/visits/administrator/attachment/{id}', 'VisitController@downloadAttachment')
    ->middleware('auth:administrator')
    ->name('administrator-attachment');

Route::get('/visits/doctor/delete-attachment/{id}', 'VisitController@deleteAttachment')
    ->middleware('auth:doctor')
    ->name('doctor-delete-attachment');
