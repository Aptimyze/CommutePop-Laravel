<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\CreateAlert::class,
        \App\Console\Commands\SendAlerts::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // $schedule->command('commutepop:sendalerts 5')
        //          ->everyMinute();

        $schedule->command('inspire')->pingBefore('http://commutepop.com' . env('ALERT_SEND_ENDPOINT'))->thenPing(env('ALERT_SEND_HEARTBEAT'))->everyMinute();

    }
}
