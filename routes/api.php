<?php

Route::post('/sms-code/send', 'Api\SmsCodeController@send');

Route::post('/sms-code/check', 'Api\SmsCodeController@check');

Route::post('/patients/login-by-password', 'Api\PatientController@loginByPassword');

Route::post('/patients/is-exist/{field}/{phone}', 'Api\PatientController@isExist');

Route::post('/patients/login-by-code', 'Api\PatientController@loginByCode');

Route::post('/patients/is-auth', 'Api\PatientController@isAuth');

Route::post('/patients/create', 'Api\PatientController@create');

Route::get('/patients/info/{id}', 'Api\PatientController@getInfo')
    ->middleware('auth.api:patient');

Route::get('/doctors/patient/search/{offset}', 'Api\DoctorController@get')
    ->middleware('auth.api:patient');

Route::get('/doctors/administrator/search/{offset}', 'Api\DoctorController@get')
    ->middleware('auth.api:administrator');

Route::post('/visits/patient/create', 'Api\VisitController@createByPatient')
    ->middleware('auth.api:patient');

Route::post('/visits/doctor/create', 'Api\VisitController@createByDoctor')
    ->middleware('auth.api:doctor');

Route::post('/visits/administrator/create', 'Api\VisitController@createByAdministrator')
    ->middleware('auth.api:administrator');

Route::get('/visits/patient/{offset}', 'Api\VisitController@getByPatient')
    ->middleware('auth.api:patient');

Route::get('/visits/administrator/{offset}', 'Api\VisitController@getByAdministrator')
    ->middleware('auth.api:administrator');

Route::get('/visits/doctor/{offset}', 'Api\VisitController@getByDoctor')
    ->middleware('auth.api:doctor');

Route::post('/visits/administrator/updateStatus/{id}', 'Api\VisitController@updateStatusByAdministrator')
    ->middleware('auth.api:administrator');

Route::post('/visits/doctor/updateStatus/{id}', 'Api\VisitController@updateStatusByDoctor')
    ->middleware('auth.api:doctor');

Route::post('/visits/administrator/move/{id}', 'Api\VisitController@move')
    ->middleware('auth.api:administrator');

Route::post('/visits/doctor/move/{id}', 'Api\VisitController@move')
    ->middleware('auth.api:doctor');

Route::post('/visits/doctor/attach-illness/{visitId}', 'Api\VisitController@attachIllness')
    ->middleware('auth.api:doctor');

Route::post('/visits/administrator/attach-illness/{visitId}', 'Api\VisitController@attachIllness')
    ->middleware('auth.api:administrator');

Route::post('/visits/doctor/edit-result/{id}', 'Api\VisitController@updateResult')
    ->middleware('auth.api:doctor');

Route::post('/visits/administrator/edit-result/{id}', 'Api\VisitController@updateResult')
    ->middleware('auth.api:administrator');

Route::post('/visits/administrator/edit-doctor/{id}', 'Api\VisitController@updateDoctor')
    ->middleware('auth.api:administrator');

Route::post('/visits/administrator/edit-patient/{id}', 'Api\VisitController@updatePatient')
    ->middleware('auth.api:administrator');

Route::get('/patients/doctor/{offset}', 'Api\PatientController@getByDoctor')
    ->middleware('auth.api:doctor');

Route::get('/patients/administrator/{offset}', 'Api\PatientController@getByAdministrator')
    ->middleware('auth.api:administrator');

Route::post('/patients/{id}/update', 'Api\PatientController@update')
    ->middleware('auth.api:administrator');

Route::post('/doctors/patient/add-to-favorite', 'Api\PatientController@likeDoctor')
    ->middleware('auth.api:patient');

Route::post('/doctor-reviews/patient/create', 'Api\PatientController@createDoctorReview')
    ->middleware('auth.api:patient');

Route::get('/full-search/patient', 'Api\PatientController@generalSearch')
    ->middleware('auth.api:patient');

Route::get('/full-search/administrator', 'Api\AdministratorController@generalSearch')
    ->middleware('auth.api:administrator');

Route::get('/full-search/doctor', 'Api\DoctorController@generalSearch')
    ->middleware('auth.api:doctor');
