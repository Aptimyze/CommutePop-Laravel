<?php

namespace App;

use Carbon\Carbon;

class AlertHandler
{

    public function fetch($range) {
        $startTime = Carbon::now('America/Los_Angeles');
        $startTimeString = $startTime->toTimeString();
        $endTimeString = $startTime->addMinutes($range)->toTimeString();
        var_dump($endTimeString);
        $alerts = Alert::whereBetween('alert_time', [$startTimeString, $endTimeString])
            ->orderBy('alert_time', 'asc')
            ->get()->toArray();
		return $alerts;
    }

    public function get_request_to($requestURL) {
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
        //print_r($arrivals);
        //die();


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
                    $estimated = date($timeFormat, $estimated);      //rework so time is unix timestamp until last minute
                    array_push($arrivalTimes, $estimated);
                    $arrivalCount ++;
                }
            }
        }

        $deskDepartures = array();
        foreach ($arrivalTimes as $arrivalTime) {
            $deskDeparture = Carbon::parse($arrivalTime)->subMinutes($timeToStop);
            array_push($deskDepartures, $deskDeparture);
        }


        // Create unordered list from arrivals array
        $arrivalList = "<ul>";
        foreach ($arrivalTimes as $arrivalTime) {
            $arrivalList .= "<li>" . $arrivalTime . "</li>";
        }
        $arrivalList .= "</ul>";

        // Create unordered list from departures array
        $departureList = "<ul>";
        foreach ($deskDepartures as $deskDeparture) {
            $departureList .= "<li>" . $deskDeparture->format($timeFormat) . "</li>";
        }
        $departureList .= "</ul>";


        // Output echo status to screen
        $html = "As of " . $formattedQueryTime . ", there are " . $arrivalCount . " busses on their way to the " . $resultSet['location'][0]['desc'] . " " . $resultSet['location'][0]['dir'] . " stop:<br>" . $arrivalList;

        $html .= "<br><br>To catch them, leave your desk at:<br>" . $departureList;

        var_dump($html);

    }

    public function testTrimetArrivals()
    {
        $testAlert = Alert::all()->first();
        $this->getTrimetArrivals($testAlert);
    }

}