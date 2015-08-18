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

    private function fetch($range) {
        $startTime = Carbon::now('America/Los_Angeles');
        $midnightThisMorning = Carbon::today('America/Los_Angeles');
        $startTimeString = $startTime->toTimeString();
        $endTimeString = $startTime->addMinutes($range)->toTimeString();

        $alerts = Alert::whereBetween('alert_time', [$startTimeString, $endTimeString])
                       ->whereNotBetween('last_sent', [$midnightThisMorning, $startTime])
                       ->orderBy('alert_time', 'asc')
                       ->get();

		return $alerts;
    }

    private function getTrimetArrivalData($alert) {

        date_default_timezone_set($alert->timezone);

        // Set user preferences
        $timeToStop = $alert->time_to_stop;

        // Get arrival data
        $triMetCaller = new TriMetApiCaller(new Curl(), $alert->stop);
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

}