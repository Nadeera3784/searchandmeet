<?php

namespace App\Providers;

use App\Repositories\Country\CountryPriceRepositoryInterface;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Services\Cart\CartService;
use App\Services\Cart\CostCalculatorService;
use App\Services\DateTime\TimeZoneService;
use App\Services\Domain\DomainDataService;
use App\Services\Matchmaking\MatchmakingService;
use App\Services\Matchmaking\MatchmakingServiceInterface;
use App\Services\Order\OrderService;
use App\Services\Order\OrderServiceInterface;
use App\Services\Payment\PaymentService;
use App\Services\Schedule\ScheduleService;
use App\Services\Schedule\ScheduleServiceInterface;
use App\Services\Utils\FileService\FileServiceInterface;
use App\Services\Utils\FileService\S3FileService;
use App\Services\VideoCommService\O2OMeetConnector;
use App\Services\VideoCommService\VideoCommProviderInterface;
use App\Services\Events\EventTrackingService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(VideoCommProviderInterface::class, function () {
            return new O2OMeetConnector();
        });

        $this->app->bind(OrderServiceInterface::class, function ($app) {
            $meetingRepo = $app->make(MeetingRepositoryInterface::class);
            $orderRepo = $app->make(OrderRepositoryInterface::class);
            $transactionRepo = $app->make(TransactionRepositoryInterface::class);
            $videoCommProvider = $app->make(VideoCommProviderInterface::class);
            $costCalculatorService = $app->make(CostCalculatorService::class);
            $paymentService = $app->make(PaymentService::class);

            return new OrderService($videoCommProvider, $meetingRepo, $orderRepo, $transactionRepo, $costCalculatorService, $paymentService);
        });

        $this->app->bind(CostCalculatorService::class, function ($app) {
            $countryPriceRepo = $app->make(CountryPriceRepositoryInterface::class);
            $domainDataService = $app->make(DomainDataService::class);
            return new CostCalculatorService($countryPriceRepo, $domainDataService);
        });

        $this->app->singleton(CartService::class, function ($app) {
            $costCalculatorService = $app->make(CostCalculatorService::class);
            return new CartService($costCalculatorService);
        });

        $this->app->singleton(TimeZoneService::class, function ($app) {
            return new TimeZoneService();
        });

        $this->app->singleton(FileServiceInterface::class, function ($app) {
            $disk = Storage::cloud();
            return new S3FileService($disk);
        });

        $this->app->singleton(EventTrackingService::class, function ($app) {
            return new EventTrackingService();
        });

        $this->app->bind(DomainDataService::class, function ($app) {
            return new DomainDataService();
        });

        $this->app->bind(ScheduleServiceInterface::class, function ($app) {
            $repo = $app->make(ScheduleRepositoryInterface::class);
            return new ScheduleService($repo);
        });

        $this->app->bind(MatchmakingServiceInterface::class, function ($app) {
            return new MatchmakingService();
        });

        Stripe::setApiKey(config('services.stripe.secret'));
        Stripe::setMaxNetworkRetries(2);

        if ($this->app->environment('local')) {
            $this->app->register(TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate',
                function ($perPage = 15, $page = null, $options = []) {
                    $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                    return (new LengthAwarePaginator(
                        $this->forPage($page, $perPage), $this->count(), $perPage, $page, $options))
                        ->withPath('');
                });
        }

        Collection::macro('sortByDate', function ($column = 'created_at', $descending = true) {
            /* @var $this Collection */
            return $this->sortBy(function ($datum) use ($column) {
                return strtotime(((object)$datum)->$column);
            }, SORT_REGULAR, $descending);
        });

        view()->composer('*', function ($view)
        {
            if(!Session::get('user_color'))
            {
                $color = \Illuminate\Support\Arr::random(['red', 'green', 'blue', 'gray']);
                Session::put('user_color', $color);
            }

            if(!Session::get('user_initials'))
            {
                $user = null;
                if(auth('person')->check())
                {
                    $user = auth('person')->user();
                }
                else if(auth('agent')->check())
                {
                    $user = auth('agent')->user();
                }

                if($user)
                {
                    $name = preg_replace('/\s+/', ' ', $user->name);
                    $initials = implode('', array_map(function($v) { return $v[0]; }, explode(' ', $name)));
                    $initials = strtoupper($initials);
                    Session::put('user_initials', $initials);
                }
            }
        });
    }
}
