<?php

namespace App\Providers;

use App\Events\MatchCreated;
use App\Events\PurchaseRequirementCreated;
use App\Events\UserJoinedWaitingRoom;
use App\Listeners\MarkMatchAsSent;
use App\Listeners\MatchCreatedListener;
use App\Listeners\PurchaseRequirementCreatedListener;
use App\Listeners\UserJoinWaitingRoomListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\ActiveMeetingCreated;
use App\Events\OrderReserved;
use App\Events\PaymentSuccessful;
use App\Events\PersonCreated;
use App\Events\OrderCompleted;
use App\Events\PersonStatusCheck;

use App\Listeners\ActiveMeetingCreatedListener;
use App\Listeners\OrderReservedListener;
use App\Listeners\PaymentSuccessfulListener;
use App\Listeners\PersonCreatedListener;
use App\Listeners\OrderCompletedListener;
use App\Listeners\PersonStatusCheckListener;
use Illuminate\Notifications\Events\NotificationSent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        ActiveMeetingCreated::class => [
            ActiveMeetingCreatedListener::class,
        ],

        OrderCompleted::class => [
            OrderCompletedListener::class,
        ],
        
        OrderReserved::class => [
            OrderReservedListener::class,
        ],
        
        PaymentSuccessful::class => [
            PaymentSuccessfulListener::class,
        ],
        
        PersonCreated::class => [
            PersonCreatedListener::class,
        ],

        PersonStatusCheck::class => [
            PersonStatusCheckListener::class,
        ],

        UserJoinedWaitingRoom::class => [
            UserJoinWaitingRoomListener::class,
        ],

        PurchaseRequirementCreated::class => [
            PurchaseRequirementCreatedListener::class,
        ],

        MatchCreated::class => [
            MatchCreatedListener::class,
        ],

        NotificationSent::class => [
            MarkMatchAsSent::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
