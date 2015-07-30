<?php

namespace App;

use Carbon\Carbon;

class TimelyAlertFetcher
{
	protected $currentTime;

    public function fetch(Carbon $startTime, $range) {

        $startTimeString = $startTime->toTimeString();
        $endTimeString = $startTime->addMinutes($range)->toTimeString();
        var_dump($endTimeString);
    	$alerts = Alert::whereBetween('alert_time', [$startTimeString, $endTimeString])
    							->orderBy('alert_time', 'asc')
    							->get()->toArray();
		return $alerts;
    }

}