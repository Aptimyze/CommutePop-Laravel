<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AlertHandler;

class SendAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commutepop:sendalerts {minutes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns alerts from the db needing to be fired soon.';

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
        $handler = new AlertHandler();
        $range = $this->argument('minutes');
        $handler->sendAlertEmails($range);
    }
}
