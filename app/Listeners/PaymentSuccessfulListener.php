<?php

namespace App\Listeners;

class PaymentSuccessfulListener
{
    public function handle(\App\Events\PaymentSuccessful $event)
    {
        $order = $event->order;
        $person = $order->person;

        $person->notify(new \App\Notifications\PaymentSuccessful($order, $person));
    }
}
