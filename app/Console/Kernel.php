<?php

namespace App\Console;

use App\Jobs\MarkExpiredMeetings;
use App\Jobs\NotifyDailySuggestedProducts;
use App\Jobs\NotifyDailySuggestedSuppliers;
use App\Jobs\SendMeetingReminders;
use App\Jobs\SyncAvailabilityIndex;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new SendMeetingReminders())->everyMinute();
        $schedule->job(new MarkExpiredMeetings())->twiceDaily();
        $schedule->job(new SyncAvailabilityIndex())->twiceDaily();

        $schedule->job(new NotifyDailySuggestedSuppliers())->daily();
        $schedule->job(new NotifyDailySuggestedProducts())->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
