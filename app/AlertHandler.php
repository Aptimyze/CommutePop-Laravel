<?php

namespace App;

use Carbon\Carbon;
use Mail;

class AlertHandler
{
    protected $curl;

    public function __construct(Curl $curl) {
        $this->curl = $curl;
    }

    public function fetch($range) {
        $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
        $startTime = Carbon::now('America/Los_Angeles');
        $dayOfWeek = $startTime->dayOfWeek;
        $midnightThisMorning = Carbon::today('America/Los_Angeles');
        $startTimeString = $startTime->toTimeString();
        $endTimeString = $startTime->addMinutes($range)->toTimeString();
        $alerts = Alert::whereBetween('alert_time', [$startTimeString, $endTimeString])
                       ->where($days[$dayOfWeek], 1)
                       ->whereNotBetween('last_sent', [$midnightThisMorning, $startTimeString])
                       ->orderBy('alert_time', 'asc')
                       ->get();

		return $alerts;
    }

    /**
     * Gets upcoming arrival data from TriMet
     * @param  App\Alert $alert the currently scheduled alert
     * @return array        an array of the pertinent data from TriMet and the alert
     */
    public function getTrimetArrivalData($alert) {

        date_default_timezone_set($alert->timezone);

        // Set user preferences
        $timeToStop = $alert->time_to_stop;

        // Get arrival data
        $triMetCaller = new TriMetApiCaller($alert->stop);
        $resultSet = $triMetCaller->getApiResponse();
        $arrivals = $resultSet['arrival'];

        // Format times
        $queryTime = strtotime($resultSet['queryTime']);
        $timeFormat = 'g:i a';
        $formattedQueryTime = date($timeFormat, $queryTime);

        // Create array of arrival times
        $arrivalTimes = array();
        foreach ($arrivals as $arrival) {
            if ($arrival['route'] == $alert->route) {
                if ($arrival['status'] == "estimated") {
                    $arrivalTime = strtotime($arrival['estimated']);
                } else {
                    $arrivalTime = strtotime($arrival['scheduled']);
                }
                if ($arrivalTime - $queryTime - $alert->lead_time > ($timeToStop)) {
                    $arrivalTime = date($timeFormat, $arrivalTime);
                    array_push($arrivalTimes, $arrivalTime);
                }
            }
        }

        $deskDepartures = [];
        foreach ($arrivalTimes as $arrivalTime) {
            $deskDeparture = Carbon::parse($arrivalTime)->subMinutes($timeToStop)->format($timeFormat);
            array_push($deskDepartures, $deskDeparture);
        }

        $stopName = $resultSet['location'][0]['desc'];
        $routeDirection = $resultSet['location'][0]['dir'];

        // Return array of pertinent data
        return [
                    'alertId' => $alert->id,
                    'queryTime' => $formattedQueryTime,
                    'arrivalTimes' => $arrivalTimes,
                    'stopName' => $stopName,
                    'routeDirection' => $routeDirection,
                    'deskDepartures' => $deskDepartures,
                    'toAddress' => $alert->email
        ];

    }

    /**
     * [sendAlertEmails description]
     * @param  int $range the amount of time to check ahead for alerts due
     * @return string        just a string to describe the results
     */
    public function sendAlertEmails($range)
    {
        $alertsToSend = $this->fetch($range);

        // Initialize counter
        $alertsSent = 0;

        foreach ($alertsToSend as $alert) {
 
            $emailData = $this->getTrimetArrivalData($alert);

            Mail::send('emails.alertemail', ['emailData' => $emailData], function($message) use($emailData) {
                $message->to($emailData['toAddress'])->from('alerts@commutepop.com', 'Alert from CommutePop')->subject('Time to Leave Soon!');
            });

            // Update last_sent field

            $alert->last_sent = Carbon::now($alert->timezone);
            $alert->save();

            $alertsSent ++;
        }

        return $alertsSent;

    }

    public static function describe(Alert $alert, $send) {
        $description = "";
        $dayDescription = "";
        $timeDescription = "";

        if ( $send ) {
            $timeDescription = Carbon::parse($alert->alert_time)->format('g:ia');
        } else {
            $timeDescription = Carbon::parse($alert->departure_time)->format('g:ia');
        }
        $monday =   $alert->monday;
        $tuesday =  $alert->tuesday;
        $wednesday= $alert->wednesday;
        $thursday = $alert->thursday;
        $friday =   $alert->friday;
        $saturday = $alert->saturday;
        $sunday =   $alert->sunday;

        if ($monday && $tuesday && $wednesday && $thursday && $friday) {
            if (!($saturday || $sunday)) {
                $dayDescription = "Weekdays";
            } elseif ($saturday && $sunday) {
                $dayDescription = "Every day";
            }
        } else {
            
            $days = [];
            
            if ($monday) { array_push($days, "Mon"); }
            if ($tuesday) { array_push($days, "Tues"); }
            if ($wednesday) { array_push($days, "Wed"); }
            if ($thursday) { array_push($days, "Thurs"); }
            if ($friday) { array_push($days, "Fri"); }
            if ($saturday) { array_push($days, "Sat"); }
            if ($sunday) { array_push($days, "Sun"); }
            
            foreach ($days as $day) {
                $dayDescription .= "$day, ";
            }

            $dayDescription = rtrim($dayDescription, ", ");
        }

        $description = $dayDescription . " at " . $timeDescription;

        return $description;

    }

}