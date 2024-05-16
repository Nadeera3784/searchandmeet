<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;

class MarkMatchAsSent
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
    public function handle(NotificationSent $event)
    {
        if(get_class($event->notification) === 'App\Notifications\Matchmaking\BuyerMatchNotification' || get_class($event->notification) === 'App\Notifications\Matchmaking\SupplierMatchNotification')
        {
            $event->notification->match->update([
                'notification_status' => 1
            ]);
        }
    }
}
