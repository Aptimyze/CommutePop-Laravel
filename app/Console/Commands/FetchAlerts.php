<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\AlertHandler;
use Carbon\Carbon;

class FetchAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commutepop:fetchalerts {minutes}';

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
        $this->info("Getting alerts due in the next " . $this->argument('minutes') . " minutes.....");
        $alerts = (new AlertHandler)->fetch($this->argument('minutes'));
        $this->info(count($alerts) . " alerts in the next " . $this->argument('minutes') . " minutes:\n");
        $this->info(var_dump($alerts));
    }
}
