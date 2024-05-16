<?php

namespace App\Providers;

use App\Repositories\Communications\ConversationsEloquentRepository;
use App\Repositories\Communications\ConversationsRepositoryInterface;
use App\Repositories\Country\CountryPriceEloquentRepository;
use App\Repositories\Country\CountryPriceRepositoryInterface;
use App\Repositories\File\FileEloquentRepository;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Image\ImageEloquentRepository;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Lead\LeadEloquentRepository;
use App\Repositories\Lead\LeadRepositoryInterface;
use App\Repositories\Matchmaking\MatchEloquentRepository;
use App\Repositories\Matchmaking\MatchRepositoryInterface;
use App\Repositories\Meeting\MeetingEloquentRepository;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use App\Repositories\MeetingRequest\MeetingRequestEloquentRepository;
use App\Repositories\MeetingRequest\MeetingRequestRepositoryInterface;
use App\Repositories\Order\OrderEloquentRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Package\PackageEloquentRepository;
use App\Repositories\Package\PackageRepositoryInterface;
use App\Repositories\PurchaseRequirement\PurchaseRequirementEloquentRepository;
use App\Repositories\PurchaseRequirement\PurchaseRequirementRepositoryInterface;
use App\Repositories\Person\PersonRepositoryInterface;
use App\Repositories\Person\PersonEloquentRepository;
use App\Repositories\Business\BusinessRepositoryInterface;
use App\Repositories\Business\BusinessEloquentRepository;
use App\Repositories\Schedule\ScheduleEloquentRepository;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Repositories\Transaction\TransactionEloquentRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\User\UserEloquentRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\WatchList\WatchlistEloquentRepository;
use App\Repositories\WatchList\WatchlistRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PurchaseRequirementRepositoryInterface::class,
            PurchaseRequirementEloquentRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderEloquentRepository::class
        );
      
        $this->app->bind(
            PersonRepositoryInterface::class,
            PersonEloquentRepository::class
        );
      
        $this->app->bind(
            BusinessRepositoryInterface::class,
            BusinessEloquentRepository::class
        );

        $this->app->bind(
            MeetingRepositoryInterface::class,
            MeetingEloquentRepository::class
        );

        $this->app->bind(
            ImageRepositoryInterface::class,
            ImageEloquentRepository::class
        );

        $this->app->bind(
            FileRepositoryInterface::class,
            FileEloquentRepository::class
        );

        $this->app->bind(
            LeadRepositoryInterface::class,
            LeadEloquentRepository::class
        );

        $this->app->bind(
            CountryPriceRepositoryInterface::class,
            CountryPriceEloquentRepository::class
        );

        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionEloquentRepository::class
        );

        $this->app->bind(
            WatchlistRepositoryInterface::class,
            WatchlistEloquentRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentRepository::class
        );

        $this->app->bind(
            MeetingRequestRepositoryInterface::class,
            MeetingRequestEloquentRepository::class
        );

        $this->app->bind(
            ScheduleRepositoryInterface::class,
            ScheduleEloquentRepository::class
        );

        $this->app->bind(
            ConversationsRepositoryInterface::class,
            ConversationsEloquentRepository::class
        );

        $this->app->bind(
            PackageRepositoryInterface::class,
            PackageEloquentRepository::class
        );

        $this->app->bind(
            MatchRepositoryInterface::class,
            MatchEloquentRepository::class
        );
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
