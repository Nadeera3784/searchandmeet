<?php

namespace App\Listeners;

use App\Enums\Matchmaking\MatchTypes;
use App\Events\MatchCreated;
use App\Notifications\Matchmaking\BuyerMatchNotification;
use App\Notifications\Matchmaking\SupplierMatchNotification;

class MatchCreatedListener
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
    public function handle(MatchCreated $event)
    {
        if($event->match->type == MatchTypes::Supplier)
        {
            $event->match->person->notify(new SupplierMatchNotification($event->match));
        }
        else if($event->match->type == MatchTypes::Buyer)
        {
            $event->match->person->notify(new BuyerMatchNotification($event->match));
        }
    }
}
