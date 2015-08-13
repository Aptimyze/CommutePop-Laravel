<?php

use App\Events\UserHasRegistered;
use App\Alert;

// Landing Page for pre-release
Route::get('/', ['as' => 'landing.optin', 'uses' => 'LandingController@create']);
Route::post('/', ['as' => 'landing.confirm', 'uses' => 'LandingController@store']);
Route::get('/home', function () { return view('home'); });

Route::resource('alerts', 'AlertCreationController',
				['names' => ['create' => 'alerts.new']]);

Route::get('admin', ['as' => 'admin', 'middleware' => 'auth', function() {
	$alerts = Alert::all();
    return view('alerts.index')->with('alerts', $alerts);
	// return "Admin Panel";
}]);


// Alert endpoint to ping for sending
Route::get(env('ALERT_SEND_ENDPOINT'), function () { 
	$handler = new App\AlertHandler();
    $handler->sendAlertEmails(2);
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');