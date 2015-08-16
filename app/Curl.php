<?php
/**
 * Created by PhpStorm.
 * User: Greg
 * Date: 8/15/15
 * Time: 9:06 PM
 */

namespace App;


class Curl
{
    public function get($requestURL) {
        $ch = curl_init($requestURL);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }

}