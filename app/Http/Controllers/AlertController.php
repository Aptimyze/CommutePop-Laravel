<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\AlertRequest;
use App\Http\Controllers\Controller;
use App\Alert;
use Auth;
use Validator;
use Input;
use Redirect;
use Carbon\Carbon;

class AlertController extends Controller
{

    public function __construct()
    {
        $this->beforeFilter('csrf', ['on' => 'post']);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $alerts = Alert::get()->where('user_id', Auth::user()->id);
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
    public function store(AlertRequest $request)
    {

        $user_id =                  Auth::user()->id;
        $email =                    Input::get('email');
        $stop =                     Input::get('stop');
        $route =                    Input::get('route');
        $time_to_stop =             Input::get('time_to_stop');
        $departure_time =           Input::get('departure_time');
        $lead_time =                Input::get('lead_time');
        $monday =                   Input::get('monday');
        $tuesday =                  Input::get('tuesday');
        $wednesday =                Input::get('wednesday');
        $thursday =                 Input::get('thursday');
        $friday =                   Input::get('friday');
        $saturday =                 Input::get('saturday');
        $sunday =                   Input::get('sunday');
        $timezone =                 'America/Los_Angeles';

        $departure_date_time = Carbon::parse($departure_time);
        $alert_time = $departure_date_time->subMinutes($lead_time)->toTimeString();

        $alert = new Alert();

        $alert->user_id =           $user_id;
        $alert->email =             $email;
        $alert->stop =              $stop;
        $alert->route =             $route;
        $alert->departure_time =    $departure_time;
        $alert->time_to_stop =      $time_to_stop;
        $alert->lead_time =         $lead_time;
        $alert->alert_time =        $alert_time;
        $alert->monday =            $monday;
        $alert->tuesday =           $tuesday;
        $alert->wednesday =         $wednesday;
        $alert->thursday =          $thursday;
        $alert->friday =            $friday;
        $alert->saturday =          $saturday;
        $alert->sunday =            $sunday;
        $alert->timezone =          $timezone;

        $alert->save();
        
        return Redirect::route('alerts.index')->withMessage("Alert created!");
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
        if ($alert->belongsToUser()) {
            return view('alerts.show')->withAlert($alert);
        } else {
            return Redirect::back()->withMessage('Sorry. Alert ' . $id . ' doesn\'t belong to you!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $alert = Alert::findOrFail($id);
        if ($alert->belongsToUser()) {
            return view('alerts.edit')->withAlert($alert);
        } else {
            return Redirect::back()->withMessage('Sorry. Alert ' . $id . ' doesn\'t belong to you!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AlertRequest $request, $id)
    {

        $user_id =                  Auth::user()->id;
        $email =                    Input::get('email');
        $stop =                     Input::get('stop');
        $route =                    Input::get('route');
        $time_to_stop =             Input::get('time_to_stop');
        $departure_time =           Input::get('departure_time');
        $lead_time =                Input::get('lead_time');
        $monday =                   Input::get('monday');
        $tuesday =                  Input::get('tuesday');
        $wednesday =                Input::get('wednesday');
        $thursday =                 Input::get('thursday');
        $friday =                   Input::get('friday');
        $saturday =                 Input::get('saturday');
        $sunday =                   Input::get('sunday');
        $timezone =                 'America/Los_Angeles';

        $departure_date_time = Carbon::parse($departure_time);
        $alert_time = $departure_date_time->subMinutes($lead_time)->toTimeString();

        $alert = Alert::findOrFail($id);

        $alert->email =             $email;
        $alert->stop =              $stop;
        $alert->route =             $route;
        $alert->departure_time =    $departure_time;
        $alert->time_to_stop =      $time_to_stop;
        $alert->lead_time =         $lead_time;
        $alert->alert_time =        $alert_time;
        $alert->monday =            $monday;
        $alert->tuesday =           $tuesday;
        $alert->wednesday =         $wednesday;
        $alert->thursday =          $thursday;
        $alert->friday =            $friday;
        $alert->saturday =          $saturday;
        $alert->sunday =            $sunday;

        $alert->update();
        
        return Redirect::route('alerts.index')->withMessage('Your alert was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $alert = Alert::findOrFail($id)->delete();

        return Redirect::route('alerts.index')->withMessage('Your alert was deleted.');
    }
}
