<?php

namespace App\Console\Commands;

use App\Services\Schedule\ScheduleServiceInterface;
use Illuminate\Console\Command;

class SyncAvailabilityIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'availability_index:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update people availability index';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle(ScheduleServiceInterface $scheduleService)
    {
        $this->info('Generating availability index');
        $scheduleService->updateAvailabilityIndex();
        $this->info('Availability indexing complete');
        return true;
    }
}