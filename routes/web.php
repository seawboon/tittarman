<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::view('/draw', 'signature');
Route::post('/signature/post', 'SignaturePadController@store')->name('signaturepad.upload');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);

	Route::get('/mybranch', 'HomeController@mybranch')->name('checkin.mybranch');
	Route::get('/setSession/{branch}', 'HomeController@setSession')->name('checkin.setSession');
	Route::get('/getSession', 'HomeController@getSession')->name('checkin.getSession');
	Route::get('/forgetSession', 'HomeController@forgetSession')->name('checkin.forgetSession');

  Route::get('/checkin', 'HomeController@CheckIns')->name('checkin.index');
	Route::get('/checkin/{action}/{checkin}', 'HomeController@actionCheckIn')->name('checkin.action');


	Route::get('/checkin/{patient}', 'HomeController@storeCheckIn')->name('checkin.store');
	Route::get('/checkin/{patient}/appointment/{appo}', 'HomeController@storeCheckInFromAppointment')->name('checkin.appointment');

	Route::resource('products', 'ProductController', ['except' => ['show']]);
	Route::resource('injuryparts', 'InjuryPartController', ['except' => ['show']]);
	Route::resource('appointments', 'AppointmentController', ['except' => ['show']]);

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	Route::get('/patients', 'PatientController@index')->name('patient.index');
	Route::get('/patients/create', 'PatientController@create')->name('patient.create');
	Route::post('/patients', 'PatientController@store')->name('patient.store');
	Route::any('/patients/search', 'PatientController@search')->name('patient.search');
	Route::get('/patients/{pid}/edit', 'PatientController@edit')->name('patient.edit');
	Route::post('/patients/{pid}/edit', 'PatientController@update')->name('patient.update');
		Route::get('/patients/{patient}/treats', 'PatientController@treats')->name('patient.treats');

	Route::get('/patient/{patient}/matter/create', 'MatterController@create')->name('matter.create');
	Route::get('/patient/{patient}/matters', 'MatterController@index')->name('matter.index');
	Route::post('/patient/{patient}/matter', 'MatterController@store')->name('matter.store');
	Route::get('/patient/{patient}/matter/{matter}', 'MatterController@edit')->name('matter.edit');
	Route::post('/patient/{patient}/matter/{matter}/update', 'MatterController@update')->name('matter.update');

	Route::get('/patient/{patient}/matter/{matter}/treats', 'TreatController@index')->name('treat.index');
	Route::get('/patient/{patient}/matter/{matter}/treat/create', 'TreatController@create')->name('treat.create');
	Route::post('/patient/{patient}/matter/{matter}/treat/store', 'TreatController@store')->name('treat.store');
	Route::get('/patient/{patient}/matter/{matter}/treat/{treat}', 'TreatController@edit')->name('treat.edit');
	Route::post('/patient/{patient}/matter/{matter}/treat/{treat}/update', 'TreatController@update')->name('treat.update');
});
