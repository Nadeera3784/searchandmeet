<?php

namespace App\Listeners;

use App\Events\OrderCompleted;


class OrderCompletedListener
{
    public function handle(OrderCompleted $event)
    {
        $event->order->person->notify(new \App\Notifications\OrderCompleted($event->order));
    }
}
