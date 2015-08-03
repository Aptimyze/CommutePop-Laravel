<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Alert;
use Validator;
use Input;
use Redirect;
use Carbon\Carbon;

class AlertCreationController extends Controller
{

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $alerts = Alert::all();
        return view('alerts.index')->with('alerts', $alerts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        

        return view('alerts.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'stop' => 'required|numeric|digits_between:1,4',
            'route' => 'required|numeric|digits_between:1,3',
            'lead_time' => 'required|numeric|digits_between:1,3',
            'time_to_stop' => 'required|numeric|digits_between:1,3',
            'departure_time' => ['required', 'regex:/(^([01]\d|2[0-3]):?([0-5]\d)$)|(^(([1-9]{1})|([0-1][1-2])|(0[1-9])|([1][0-2])):([0-5][0-9])*\s?(([aA])|([pP]))[mM]$)/']
        ];

        $validator = Validator::make(Input::all(), $rules);

        $validator->failed();

        if ($validator->fails()) {

            return Redirect::route('alerts.new')->withErrors($validator)->withInput();

        }

        $email =                    Input::get('email');
        $stop =                     Input::get('stop');
        $route =                    Input::get('route');
        $time_to_stop =             Input::get('time_to_stop');
        $departure_time =           Input::get('departure_time');
        $lead_time =                Input::get('lead_time');
        $timezone =                 'America/Los_Angeles';

        $departure_date_time = Carbon::parse($departure_time);
        $alert_time = $departure_date_time->subMinutes($time_to_stop)->subMinutes($lead_time)->toTimeString();

        $alert =                    new Alert();
        $alert->email =             $email;
        $alert->stop =              $stop;
        $alert->route =             $route;
        $alert->departure_time =    $departure_time;
        $alert->time_to_stop =      $time_to_stop;
        $alert->lead_time =         $lead_time;
        $alert->alert_time =        $alert_time;
        $alert->timezone =          $timezone;

        $alert->save();
        
        return view('alerts.confirm');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $alert = Alert::findOrFail($id);
        return view('alerts.show')->withAlert($alert);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
