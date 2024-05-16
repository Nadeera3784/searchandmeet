<?php

namespace App\Listeners;


use App\Enums\Meeting\MeetingStatus;
use App\Enums\Order\OrderItemType;

class RefreshMeetingParticipantStatusListener
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
        $meeting = $event->meeting;
        $status = MeetingStatus::Scheduled;

        //update meeting status based on participant
        if($meeting->orderItem->required_translator && $meeting->translator_id === null)
        {
            $status = MeetingStatus::Requires_Participant;
        }

        //update meeting status based on participant
        if(!$meeting->agent_id && $meeting->orderItem->type === OrderItemType::MeetingWithHost)
        {
            $status = MeetingStatus::Requires_Participant;
        }

        $meeting->update([
            'meeting' => $status
        ]);
    }
}
