<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/alert', function () { return view('index'); });
Route::get('/alerts/new', ['as' => 'alerts.new', 'uses' => 'AlertCreationController@create']);
Route::post('/alerts/new/confirm', ['as' => 'alerts.confirm', 'uses' => 'AlertCreationController@store']);
Route::get('admin', 'AlertCreationController@index');

Route::get('/', ['as' => 'landing.optin', 'uses' => 'LandingController@create']);
Route::post('/', ['as' => 'landing.confirm', 'uses' => 'LandingController@store']);

Route::get('/sendthemall', function () { 
	$handler = new AlertHandler();
    $handler->sendAlertEmails(5);
    return '<a href="http://commutepop.com/">CommutePop</a>';
});
