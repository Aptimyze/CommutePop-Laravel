<?php


$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Alert::class, function ($faker) {
    return [
        'email' => $faker->email,
        'stop' => $faker->numberBetween(10, 1024),
        'route' => $faker->numberBetween(3, 99),
        'departure_time' => $faker->time,
        'time_to_stop' => $faker->numberBetween(2, 10),
        'lead_time' => $faker->numberBetween(2, 15),
        'alert_time' => $faker->time,
        'last_sent' => '00:00:00',
        'timezone' => 'America/Los_Angeles',
    ];
});