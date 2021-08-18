<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notice;
use Log;

class ThreeDaysCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:threedays';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification to user after 3 days';

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
     * @return int
     */
    public function handle()
    {
        Log::info("Cron is working");
    }
}
