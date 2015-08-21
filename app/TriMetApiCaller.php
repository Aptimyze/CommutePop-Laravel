<?php
namespace App;

use Carbon\Carbon;
// use Curl;

class TriMetApiCaller
{
	/**
	 * The stop ID where we'll be checking for arrival information
	 * @var string
	 */
	protected $stop;

    public function __construct($stop) {
        $this->stop = $stop;
    }

    /**
     * Constructs the URL used to make an API call to TriMet
     * 
     * @return string the URL for the API call to Trimet
     */
    private function getApiUrl()
    {
        $appID = env('TRIMET_APP_ID');
    	return "https://developer.trimet.org/ws/V1/arrivals/locIDs/$this->stop/json/true/streetcar/true/appID/$appID";
    }

    /**
     * Makes a request to the TriMet API
     * 
     * @return array an array of arrival information from TriMet
     */
    public function getApiResponse()
    {
    	$requestURL = $this->getApiUrl($this->stop);
    	$response = Curl::get($requestURL);
    	$response_array = json_decode($response, true);
        return $response_array['resultSet'];
    }
}