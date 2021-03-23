<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('calendar', 'ApiController@calendar');
Route::post('calendarpost', 'ApiController@calendarStore');
Route::put('calendarput/{appointment}', 'ApiController@calendarDrop');


//$packages
Route::get('packages', 'ApiController@packages');


//passport api
Route::put('login', 'PassportController@login');
//Route::post('register', 'PassportController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'PassportController@details');
    Route::apiResource('/patients', 'Api\PatientController');
});

/*Route::middleware('auth.apikey')->group(function () {
    Route::get('api/patient/1', 'KeyController@details');
});*/

Route::middleware('auth.apikey')->group(function () {
  Route::get('keypatient/{patient}', 'KeyController@details');
  Route::any('keypatient/search', 'KeyController@search');
});
