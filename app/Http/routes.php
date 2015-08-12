<?php

use App\Events\UserHasRegistered;

Route::get('/alerts', function () { return view('alerts'); });
Route::get('/alerts/new', ['as' => 'alerts.new', 'middleware' => 'auth', 'uses' => 'AlertCreationController@create']);
Route::post('/alerts/new/confirm', ['as' => 'alerts.confirm', 'middleware' => 'auth', 'uses' => 'AlertCreationController@store']);
Route::get('admin', ['as' => 'admin', 'middleware' => 'auth', 'uses' => 'AlertCreationController@index']);

Route::get('/', ['as' => 'landing.optin', 'uses' => 'LandingController@create']);
Route::post('/', ['as' => 'landing.confirm', 'uses' => 'LandingController@store']);

Route::get(env('ALERT_SEND_ENDPOINT'), function () { 
	$handler = new App\AlertHandler();
    $handler->sendAlertEmails(2);
});

Route::get('/broadcast', function() {
	event(new UserHasRegistered('Greg Kaleka'));
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