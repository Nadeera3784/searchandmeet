<?php

namespace App\Jobs;

use App\Notifications\MeetingReminder;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendMeetingReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $timeIntervals = [15,5,1];

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct()
    {

    }

    public function handle(MeetingRepositoryInterface $meetingRepository)
    {
//        Log::info('Sending meeting reminders');
        $meetings = $meetingRepository->getAll();
        foreach ($meetings as $meeting)
        {
            $now = Carbon::now();
            $check = $meeting->orderItem->timeSlot->start;
            $difference = $now->diffInMinutes($check, false);

            if(in_array($difference, $this->timeIntervals))
            {
                $meeting->orderItem->order->person->notify(new MeetingReminder($meeting, $difference));
                $meeting->orderItem->purchase_requirement->person->notify(new MeetingReminder($meeting, $difference));
                if($meeting->agent_id)
                {
                    $meeting->user->notify(new MeetingReminder($meeting, $difference));
                }
            }
        }
    }
}
