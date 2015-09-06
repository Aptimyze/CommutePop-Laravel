<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => 'commutepop.com',
        'secret' => env('MAILGUN_KEY'),
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'mailtrap' => [
        'secret' => env('MAILTRAP_KEY'),
        'default_inbox' => '54134'
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => '',
        'secret' => '',
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => 'http://commutepop.com/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_APP_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'default_graph_version' => 'v2.4',
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

];
