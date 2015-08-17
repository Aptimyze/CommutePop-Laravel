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
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $startTime = Carbon::now('America/Los_Angeles');
        $dayOfWeek = $startTime->dayOfWeek;
        $midnightThisMorning = Carbon::today('America/Los_Angeles');
        $startTimeString = $startTime->toTimeString();
        $endTimeString = $startTime->addMinutes($range)->toTimeString();

        $alerts = Alert::whereBetween('alert_time', [$startTimeString, $endTimeString])
                       ->where($days[$dayOfWeek], 1)
                       ->whereNotBetween('last_sent', [$midnightThisMorning, $startTime])
                       ->orderBy('alert_time', 'asc')
                       ->get();

		return $alerts;
    }

    private function getTrimetArrivalData($alert) {

        $baseURL = 'https://developer.trimet.org/ws/V1/arrivals?';
        date_default_timezone_set($alert->timezone);


        // Set User preferences
        $timeToStop = ($alert->time_to_stop);
        $stop = $alert->stop;
        $route = $alert->route;

        // Set parameters for API call and build URL
        $locIDs = $stop;
        $json = 'true';
        $streetcar = 'true';
        $requestURL = $baseURL .
            'locIDs=' . $locIDs .
            '&json=' . $json .
            '&streetcar=' . $streetcar .
            '&appID=' . env('TRIMET_APP_ID');

        // Make API call
        $response = $this->curl->get($requestURL);

        // Parse response
        $response_array = json_decode($response, true);
        $resultSet = $response_array['resultSet'];
        $arrivals = $resultSet['arrival'];

        // Format times
        $queryTime = strtotime($resultSet['queryTime']);
        $timeFormat = 'g:i a';
        $formattedQueryTime = date($timeFormat, $queryTime);

        // Create array of arrivals
        $arrivalTimes = array();
        $arrivalCount = 0;
        foreach ($arrivals as $arrival) {
            if ($arrival['route'] == $route) {
                if ($arrival['status'] == "estimated") {
                    $estimated = strtotime($arrival['estimated']);
                } else {
                    $estimated = strtotime($arrival['scheduled']);
                }
                if ($estimated - $queryTime > ($timeToStop)) {
                    $estimated = date($timeFormat, $estimated);
                    array_push($arrivalTimes, $estimated);
                    $arrivalCount ++;
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
                    'arrivalCount' => $arrivalCount,
                    'stopName' => $stopName,
                    'routeDirection' => $routeDirection,
                    'deskDepartures' => $deskDepartures,
                    'toAddress' => $alert->email
        ];

    }

    public function sendAlertEmails($range) {
 
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

        $stats = 'Found ' . count($alertsToSend) . ' alerts to send. Sent ' . $alertsSent . '.';

        return $stats;

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