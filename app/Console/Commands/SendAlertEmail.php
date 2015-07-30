<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SendAlertEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commutepop:sendalerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send emails for all fetched alerts.';

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
        // Get alerts for next 5 minutes

        // Build email for each alert
            // Make API Call
            // Build HTML
            // Queue email

    }
}
