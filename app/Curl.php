<?php
namespace App;

class Curl
{
    public static function get($requestURL) {
        $ch = curl_init($requestURL);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

    public static function postJSON($requestURL, $postFields, $header) {
    	$ch = curl_init($requestURL);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    	curl_setopt($ch, CURLOPT_HTTPHEADER,array($header, 'Content-Type: application/json'));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$response = curl_exec($ch);
    	curl_close($ch);

    	return $response;
    }

}