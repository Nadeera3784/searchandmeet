<?php

namespace App\Console\Commands;

use App\Models\Person;
use App\Services\Schedule\ScheduleService;
use Illuminate\Console\Command;

class SyncSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush all user sessions';

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
    public function handle(ScheduleService $scheduleService)
    {
        $people = Person::all();
        foreach ($people as $person)
        {
            $scheduleService->addDefaultSchedule($person);
        }

        $this->info('Schedule syncing complete');
    }
}