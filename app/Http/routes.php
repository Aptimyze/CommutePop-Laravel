<?php

use App\Events\UserHasRegistered;

Route::get('/alerts', function () { return view('alerts'); });
Route::get('/alerts/new', ['as' => 'alerts.new', 'uses' => 'AlertCreationController@create']);
Route::post('/alerts/new/confirm', ['as' => 'alerts.confirm', 'uses' => 'AlertCreationController@store']);
Route::get('admin', 'AlertCreationController@index');

Route::get('/', ['as' => 'landing.optin', 'uses' => 'LandingController@create']);
Route::post('/', ['as' => 'landing.confirm', 'uses' => 'LandingController@store']);

Route::get('/' . env('ALERT_SEND_ENDPOINT'), function () { 
	$handler = new App\AlertHandler();
    $handler->sendAlertEmails(2);
});

Route::get('/broadcast', function() {
	event(new UserHasRegistered('Greg Kaleka'));
});