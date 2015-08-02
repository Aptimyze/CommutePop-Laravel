<?php

namespace App;

use Carbon\Carbon;
use Mail;

class AlertHandler
{

    private function fetch($range) {
        $startTime = Carbon::now('America/Los_Angeles');
        $startTimeString = $startTime->toTimeString();
        $endTimeString = $startTime->addMinutes($range)->toTimeString();
        var_dump($endTimeString);
        $alerts = Alert::whereBetween('alert_time', [$startTimeString, $endTimeString])
            ->orderBy('alert_time', 'asc')
            ->get()->toArray();
		return $alerts;
    }

    // This method should really be refactored into a public static method of another class
    private function get_request_to($requestURL) {
        $ch = curl_init($requestURL);
        curl_setopt($ch, CURLOPT_POST, false); // is this necessary?
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    private function getTrimetArrivals($alert) {

        $baseURL = 'https://developer.trimet.org/ws/V1/arrivals?';
        date_default_timezone_set($alert['timezone']);


        // Set User preferences
        $timeToStop = ($alert['time_to_stop']);
        $stop = $alert['stop'];
        $route = $alert['route'];


        // Set parameters for API call and build URL
        $locIDs = $stop;
        $json = 'true';
        $streetcar = 'true';
        $requestURL = $baseURL .
            'locIDs=' . $locIDs .
            '&json=' . $json .
            '&streetcar=' . $streetcar .
            '&appID=' . $_ENV['TRIMET_APP_ID'];


        // Make API call
        $response = $this->get_request_to($requestURL);


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

        $deskDepartures = array();
        foreach ($arrivalTimes as $arrivalTime) {
            $deskDeparture = Carbon::parse($arrivalTime)->subMinutes($timeToStop)->format($timeFormat);
            array_push($deskDepartures, $deskDeparture);
        }

        $stopName = $resultSet['location'][0]['desc'];
        $routeDirection = $resultSet['location'][0]['dir'];

        // Return array of pertinent data
        return [
                    'queryTime' => $formattedQueryTime,
                    'arrivalTimes' => $arrivalTimes,
                    'arrivalCount' => $arrivalCount,
                    'stopName' => $stopName,
                    'routeDirection' => $routeDirection,
                    'deskDepartures' => $deskDepartures,
                    'toAddress' => $alert['email']
        ];

    }

    public function sendAlertEmails($range) {
        // Get alerts
        $alertsToSend = $this->fetch($range);
        $alertsSent = 0;

        // For each alert
        foreach ($alertsToSend as $alert) {
            // Get html
            $emailData = $this->getTrimetArrivals($alert);

            // Send email
            Mail::send('emails.alertemail', ['emailData' => $emailData], function($message) use($emailData) {
                $message->to($emailData['toAddress'])->from('alerts@commutepop.com', 'Alert from CommutePop')->subject('Time to Leave Soon!');
            });

            $alertsSent ++;

            // Mail::raw($emailBody, function($message) use ($alert) {
            //     $message->to($alert['email'])->from('alerts@commutepop.com', 'CommutePop')->subject('Actually Automated CommutePop Email!');
            // });
        }

        return $alertsSent . " alerts sent.";

    }

}