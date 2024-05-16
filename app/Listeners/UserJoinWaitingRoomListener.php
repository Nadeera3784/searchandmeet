<?php

namespace App\Listeners;

use App\Events\UserJoinedWaitingRoom;

class UserJoinWaitingRoomListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserJoinedWaitingRoom $event)
    {
        if($event->sender->id !== $event->meeting->orderItem->order->person)
        {
            $event->meeting->orderItem->order->person->notify(new \App\Notifications\UserJoinedWaitingRoom($event->meeting));
        }

        if($event->sender->id !== $event->meeting->orderItem->purchase_requirement->person)
        {
            $event->meeting->orderItem->purchase_requirement->person->notify(new \App\Notifications\UserJoinedWaitingRoom($event->meeting));
        }

        if($event->meeting->user)
        {
            $event->meeting->user->notify(new \App\Notifications\UserJoinedWaitingRoom($event->meeting));
        }
    }
}
