<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PersonCreatedListener
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
    public function handle(\App\Events\PersonCreated $event)
    {
        $event->person->notify(new \App\Notifications\PersonCreated($event->setupToken));
        $event->person->notify((new \App\Notifications\PersonGuide())->delay(now()->addMinutes(5)));
    }
}
