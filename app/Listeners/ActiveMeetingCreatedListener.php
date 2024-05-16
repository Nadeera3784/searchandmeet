<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class ActiveMeetingCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $requirement_owner = $event->meeting->orderItem->purchase_requirement->person;
        $requirement_purchaser = $event->meeting->orderItem->order->person;

        $requirement_owner->notify(new \App\Notifications\MeetingCreated($event->meeting));
        $requirement_purchaser->notify(new \App\Notifications\MeetingCreated($event->meeting));

        if($event->meeting->agent_id)
        {
            User::find($event->meeting->agent_id)->notify(new \App\Notifications\MeetingCreated($event->meeting));
        }
    }
}
