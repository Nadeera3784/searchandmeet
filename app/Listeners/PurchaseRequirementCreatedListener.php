<?php

namespace App\Listeners;

use App\Events\PurchaseRequirementCreated;
use Famdirksen\LaravelGoogleIndexing\LaravelGoogleIndexing;

class PurchaseRequirementCreatedListener
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
    public function handle(PurchaseRequirementCreated $event)
    {
        if(config('app.env') === 'production')
        {
            LaravelGoogleIndexing::create()->update(route('purchase_requirements.show.slug', $event->purchaseRequirement->slug));
        }
    }
}
