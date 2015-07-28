<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Alert;

class CreateAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaveat:createalert {email} {stop} {route} {departure_time} {time_to_stop} {lead_time=00:10:00}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually create a new alert.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $stop = $this->argument('stop');
        $route = $this->argument('route');
        $departure_time = $this->argument('departure_time');
        $time_to_stop = $this->argument('time_to_stop');
        $lead_time = $this->argument('lead_time');

        $alert = new Alert;
        $alert->email = $email;
        $alert->stop = $stop;
        $alert->route = $route;
        $alert->departure_time = $departure_time;
        $alert->time_to_stop = $time_to_stop;
        $alert->lead_time = $lead_time;
        $alert->save();

        $this->info('Alert created!');
    }
}
