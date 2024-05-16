<?php

namespace App\Providers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Communication\Conversation;
use App\Models\Lead;
use App\Models\Matchmaking\Match;
use App\Models\Meeting;
use App\Models\MeetingRequest;
use App\Models\Order;
use App\Models\Package;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        $this->attachRouteHashing();
    }

    protected function attachRouteHashing()
    {
        Route::bind('person', function ($value, $route) {
            return $this->getModel(Person::class, $value);
        });

        Route::bind('user', function ($value, $route) {
            return $this->getModel(User::class, $value);
        });

        Route::bind('business', function ($value, $route) {
            return $this->getModel(Business::class, $value);
        });

        Route::bind('category', function ($value, $route) {
            return $this->getModel(Category::class, $value);
        });

        Route::bind('order', function ($value, $route) {
            return $this->getModel(Order::class, $value);
        });

        Route::bind('purchase_requirement', function ($value, $route) {
            return $this->getModel(PurchaseRequirement::class, $value);
        });

        Route::bind('transaction', function ($value, $route) {
            return $this->getModel(Transaction::class, $value);
        });

        Route::bind('meeting', function ($value, $route) {
            return $this->getModel(Meeting::class, $value);
        });

        Route::bind('lead', function ($value, $route) {
            return $this->getModel(Lead::class, $value);
        });

        Route::bind('meeting_request', function ($value, $route) {
            return $this->getModel(MeetingRequest::class, $value);
        });

        Route::bind('conversation', function ($value, $route) {
            return $this->getModel(Conversation::class, $value);
        });

        Route::bind('package', function ($value, $route) {
            return $this->getModel(Package::class, $value);
        });

        Route::bind('match', function ($value, $route) {
            return $this->getModel(Match::class, $value);
        });

    }
    /**

     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(100)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * @param $model
     * @param $routeKey
     * @return mixed
     */
    private function getModel($model, $routeKey)
    {
        $id = \Hashids::connection($model)->decode($routeKey)[0] ?? null;
        $modelInstance = resolve($model);
        return  $modelInstance->findOrFail($id);
    }
}
