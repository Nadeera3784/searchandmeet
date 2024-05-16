<?php

namespace App\Jobs;

use App\Enums\Meeting\MeetingStatus;
use App\Enums\Order\OrderStatus;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MarkExpiredMeetings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $expiryDays = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * @param MeetingRepositoryInterface $meetingRepository
     * @return void
     */
    public function handle(MeetingRepositoryInterface $meetingRepository)
    {
        Log::info('Marking expired meetings');
        $meetings = $meetingRepository->getAll();
        foreach ($meetings as $meeting)
        {
            $order = $meeting->orderItem->order;
            $timeslot = $meeting->orderItem->timeslot;

            if($order->status === OrderStatus::Completed && ($timeslot->start->addDays($this->expiryDays) < Carbon::now()))
            {
                $meetingRepository->update([
                    'status' => MeetingStatus::Expired
                ], $meeting->id);
            }
        }
    }
}
