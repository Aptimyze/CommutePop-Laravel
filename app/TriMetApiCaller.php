<?php

namespace App;

use Carbon\Carbon;
use Mail;

class TriMetApiCaller
{
	/**
	 * An instance of the Curl class
	 * @var Curl
	 */
	protected $curl;

	/**
	 * The stop ID where we'll be checking for arrival information
	 * @var string
	 */
	protected $stop;

	/**
	 * Super secret App ID for TriMet API
	 * @var string
	 */
	protected $appID = env('TRIMET_APP_ID');


    public function __construct(Curl $curl, String $stop) {
        $this->curl = $curl;
        $this->stop = $stop;
    }

    /**
     * Constructs the URL used to make an API call to TriMet
     * 
     * @return string the URL for the API call to Trimet
     */
    private function getApiUrl()
    {
    	return "https://developer.trimet.org/ws/V1/arrivals/locIDs/$stop/json/true/streetcar/true/appID/$appID";
    }

    /**
     * Makes a request to the TriMet API
     * 
     * @return array an array of arrival information from TriMet
     */
    public function getApiResponse()
    {
    	$requestURL = $this->getApiUrl($this->stop);
    	$response = $this->curl->get($requestURL);
    	$response_array = json_decode($response, true);
        return $response_array['resultSet'];
    }
}