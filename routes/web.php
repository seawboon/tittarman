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
Route::view('/php', 'phpinfo');
Route::post('/signature/post', 'SignaturePadController@store')->name('signaturepad.upload');

Route::get('/receipt', function() {
	//return view('payment.receipt');
	$company = 'tittarman';
	$pdf = PDF::loadView('payment.receipt', compact('company'));
	return $pdf->stream('receipt.pdf');
	//return $pdf->download('disney.pdf');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	//Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::resource('roles','RoleController');
  Route::resource('users','UserController');
  Route::resource('products','ProductController');
	Route::resource('packages','PackageController');
	Route::resource('methods','MethodController');
	Route::resource('sources','SourceController');
	Route::resource('market-sources','MarketSourceController');
	Route::resource('promotions','PromotionController');

	Route::get('/variants', 'PackageController@indexVariant')->name('index.variants');
	Route::get('/packages/{package}/variant/add', 'PackageController@createVariant')->name('add.variant');
	Route::post('/packages/{package}/variant/add', 'PackageController@saveVariant')->name('save.variant');
	Route::get('/packages/{package}/variant/{variant}/edit', 'PackageController@editVariant')->name('edit.variant');
	Route::post('/packages/{package}/variant/{variant}/edit', 'PackageController@updateVariant')->name('update.variant');

	Route::get('/packages/{package}/variants', 'PackageController@showPackageVariants')->name('show.package.variants');

	Route::get('/mybranch', 'HomeController@mybranch')->name('checkin.mybranch');
	Route::get('/setSession/{branch}', 'HomeController@setSession')->name('checkin.setSession');
	Route::get('/getSession', 'HomeController@getSession')->name('checkin.getSession');
	Route::get('/forgetSession', 'HomeController@forgetSession')->name('checkin.forgetSession');

	Route::get('/myappointment', 'AppointmentController@myappointment')->name('user.appointment');

  Route::get('/checkin', 'CheckInController@CheckIns')->name('checkin.index');
	Route::get('/checkin/create/{patient}', 'CheckInController@create')->name('checkin.create');
	Route::post('/checkin/create/{patient}', 'CheckInController@storeCreate')->name('checkin.storeCreate');
	Route::get('/checkin/edit/{checkin}', 'CheckInController@edit')->name('checkin.edit');
	Route::post('/checkin/edit/{checkin}/update', 'CheckInController@update')->name('checkin.update');
	Route::get('/checkin/{action}/{checkin}', 'CheckInController@actionCheckIn')->name('checkin.action');



	Route::get('/checkin/{patient}', 'CheckInController@storeCheckIn')->name('checkin.store');
	Route::get('/checkin/{patient}/appointment/{appo}', 'CheckInController@storeCheckInFromAppointment')->name('checkin.appointment');

	Route::resource('products', 'ProductController', ['except' => ['show']]);
	Route::resource('injuryparts', 'InjuryPartController', ['except' => ['show']]);
	Route::resource('vouchertypes', 'VoucherTypeController', ['except' => ['show']]);
	Route::resource('appointments', 'AppointmentController', ['except' => ['show']]);
	Route::get('/appointments/range', 'AppointmentController@range')->name('appointments.range');

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

	Route::get('/patient/{patient}/vouchers', 'VoucherController@index')->name('voucher.index');
	Route::get('/patient/{patient}/payments', 'PaymentController@index')->name('payment.index');
	Route::get('/patient/pdf/package/{package}', 'VoucherController@packagePdf')->name('package.pdf');
	Route::get('/patient/{patient}/vouchers/{voucher}/transfer', 'VoucherController@transfer')->name('voucher.transfer');
	Route::post('/patient/{patient}/vouchers/{voucher}/update', 'VoucherController@transferUpdate')->name('voucher.transfer.update');
	Route::post('/patient/{patient}/vouchers', 'VoucherController@updateVouchers')->name('voucher.patient.update');

	Route::get('/admin/vouchers', 'VoucherController@adminIndex')->name('voucher.admin.index');


	Route::get('/patient/{patient}/matter/{matter}/treats', 'TreatController@index')->name('treat.index');
	Route::get('/patient/{patient}/matter/{matter}/treat/create', 'TreatController@create')->name('treat.create');
	Route::post('/patient/{patient}/matter/{matter}/treat/store', 'TreatController@store')->name('treat.store');
	Route::get('/patient/{patient}/matter/{matter}/treat/{treat}', 'TreatController@edit')->name('treat.edit');
	Route::post('/patient/{patient}/matter/{matter}/treat/{treat}/update', 'TreatController@update')->name('treat.update');

	Route::get('/payment/create/{patient}', 'PaymentController@create')->name('payment.create');
	Route::post('/payment/create/{patient}/store', 'PaymentController@store')->name('payment.store');
	Route::get('/payment/{payment}/edit', 'PaymentController@edit')->name('payment.edit');
	Route::get('/payment/{payment}/editOld', 'PaymentController@editOld')->name('payment.editold');
	Route::post('/payment/{payment}/update', 'PaymentController@update')->name('payment.update');

	Route::get('import-excel', 'ImportExcel\ImportExcelController@index');
	Route::post('import-excel', 'ImportExcel\ImportExcelController@import');

	Route::get('import-patient', 'ImportExcel\ImportExcelController@create');
	Route::post('import-patient', 'ImportExcel\ImportExcelController@importPatient');

	Route::get('import-patient-package', 'ImportExcel\ImportExcelController@createPatientPackage');
	Route::post('import-patient-package', 'ImportExcel\ImportExcelController@storePatientPackage');

	Route::get('export-patients', 'ImportExcel\ImportExcelController@exportPatient');

});
