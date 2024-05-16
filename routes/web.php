<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post(
    '/webhooks/stripe',
    [\App\Http\Controllers\Webhook\StripeWebhookController::class, 'handleWebhook']
);

Route::post(
    '/webhooks/zoho',
    [\App\Http\Controllers\Webhook\ZohoWebhookController::class, 'handleWebhook']
);

Route::get('/health', [\App\Http\Controllers\SystemController::class, 'health']);
Route::get('/generate-sitemap', [\App\Http\Controllers\SystemController::class, 'generateSitemap']);
Route::get('/auth/direct_login', [\App\Http\Controllers\AuthController::class, 'directLogin'])->name('person.auth.direct_login');
Route::get('/articles/{path?}',[\App\Http\Controllers\ArticleController::class, 'index'])->where('path','.+')->name('articles');

Route::group(['middleware' => ['auth.person', 'persist.alternate_domain', 'page.tracker']], function () {

    // check business details middleware
    Route::post('/watchlist', [\App\Http\Controllers\WatchlistController::class, 'add'])->name('person.watchlist.add');
    Route::delete('/watchlist', [\App\Http\Controllers\WatchlistController::class, 'remove'])->name('person.watchlist.remove');
    Route::put('/watchlist', [\App\Http\Controllers\WatchlistController::class, 'clear'])->name('person.watchlist.clear');

    Route::get('/onboarding', [\App\Http\Controllers\PeopleController::class, 'on_boarding'])->name('person.onboarding');
    Route::post('/me/cards', [\App\Http\Controllers\PeopleController::class, 'update_payment_method'])->name('person.cards.update');

    Route::get('/verify/phone', [\App\Http\Controllers\VerificationController::class, 'initiate_phone_verification'])->name('person.phone.verification');
    Route::post('/verify/phone/send', [\App\Http\Controllers\VerificationController::class, 'send_code'])->name('person.phone.verification.send');
    Route::post('/verify/phone/resend', [\App\Http\Controllers\VerificationController::class, 'resend_code'])->name('person.phone.verification.resend');
    Route::post('/verify/phone', [\App\Http\Controllers\VerificationController::class, 'verify_phone'])->name('person.phone.verify');

    Route::post('/wechat/source', [\App\Http\Controllers\PaymentController::class, 'get_payment_source'])->name('order.wechat.source');
    Route::post('/wechat/process_payment', [\App\Http\Controllers\PaymentController::class, 'process_source_payment'])->name('order.wechat.process_payment');
    Route::post('/wechat/is_authorized', [\App\Http\Controllers\PaymentController::class, 'check_source_authorization'])->name('order.wechat.check_authorization');

    Route::group(['middleware' => ['check.person.status']], function () {
        // purchase-requirements
        Route::group(['prefix' => 'purchase-requirements'], function () {
            Route::get('/create', [\App\Http\Controllers\PurchaseRequirementController::class, 'create'])->name('person.purchase_requirements.create');
            Route::get('/', [\App\Http\Controllers\PurchaseRequirementController::class, 'index'])->name('person.purchase_requirements.index');
            Route::post('/inquire', [\App\Http\Controllers\PurchaseRequirementController::class, 'handleInquire'])->name('person.purchase_requirements.inquire');
            Route::post('/', [\App\Http\Controllers\PurchaseRequirementController::class, 'store'])->name('person.purchase_requirements.store');
            Route::delete('/{purchase_requirement}', [\App\Http\Controllers\PurchaseRequirementController::class, 'delete'])->name('person.purchase_requirements.delete');
            Route::get('/{purchase_requirement}/edit', [\App\Http\Controllers\PurchaseRequirementController::class, 'edit'])->name('person.purchase_requirements.edit');
            Route::put('/{purchase_requirement}/edit', [\App\Http\Controllers\PurchaseRequirementController::class, 'update'])->name('person.purchase_requirements.update');
        });

        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('person.dashboard');
        Route::get('/schedule', [\App\Http\Controllers\ScheduleController::class, 'show'])->name('person.schedule.show');
        Route::post('/schedule/update', [\App\Http\Controllers\ScheduleController::class, 'update'])->name('person.schedule.update');

        Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('person.orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('person.orders.show');
        Route::post('/orders/reserve', [\App\Http\Controllers\OrderController::class, 'reserve'])->name('person.orders.reserve')->middleware(\App\Http\Middleware\OrderLimit::class);
        Route::delete('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'destroy'])->name('person.orders.destroy');

        Route::get('/meetings', [\App\Http\Controllers\MeetingController::class, 'index'])->name('person.meetings.index');
        Route::get('/meetings/{meeting}', [\App\Http\Controllers\MeetingController::class, 'show'])->name('person.meetings.show');
        Route::post('/meetings/{meeting}/join', [\App\Http\Controllers\MeetingController::class, 'join'])->name('person.meeting.join');
        Route::post('/meetings/{meeting}/reminders', [\App\Http\Controllers\MeetingController::class, 'alert'])->name('person.meeting.reminders');

        Route::get('/meetings/{meeting}/waiting-room', [\App\Http\Controllers\MeetingController::class, 'room'])->name('person.meeting.waiting_room');

        Route::post('/meetings/{meeting}/waiting-room', [\App\Http\Controllers\MeetingController::class, 'init_waiting_room']);

        Route::get('/me/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('person.profile.show');
        Route::put('/me/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('person.profile.update');
        Route::delete('/me/profile', [\App\Http\Controllers\ProfileController::class, 'delete'])->name('person.profile.delete');
        Route::put('/me/password', [\App\Http\Controllers\ProfileController::class, 'update_password'])->name('person.update_password');

        Route::get('/billing', [\App\Http\Controllers\BillingController::class, 'show'])->name('person.billing.show');

    });

    Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('person.logout');

    Route::get('/business', [\App\Http\Controllers\BusinessController::class, 'show'])->name('person.business.show');
    Route::post('/business', [\App\Http\Controllers\BusinessController::class, 'update'])->name('person.business.update');

    Route::get('/reserve', [\App\Http\Controllers\CartController::class, 'show'])->name('person.cart.show');
    Route::post('/reserve', [\App\Http\Controllers\CartController::class, 'reserve'])->name('person.cart.reserve')->middleware(\App\Http\Middleware\OrderLimit::class);

    Route::post('/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('person.checkout');
});


Route::group(['middleware' => ['persist.alternate_domain', 'page.tracker']], function () {
    Route::domain(config('domain.identifiers.china'))->group(function () {
        Route::get('/purchase-requirements/{purchase_requirement}', [\App\Http\Controllers\PurchaseRequirementController::class, 'show'])->name('china.purchase_requirements.show');
        Route::get('/purchase-requirements/s/{slug}', [\App\Http\Controllers\PurchaseRequirementController::class, 'show_slug'])->name('china.purchase_requirements.show.slug');
    });

    Route::get('/account/setup', [\App\Http\Controllers\AuthController::class, 'setup_account'])->name('person.account.setup.show');
    Route::post('/account/setup', [\App\Http\Controllers\AuthController::class, 'complete_account_setup'])->name('person.account.setup');

    Route::get('/documentation', [\App\Http\Controllers\SupportController::class, 'documentation'])->name('support.documentation');
    Route::post('/contact', [\App\Http\Controllers\SupportController::class, 'contact'])->name('support.contact');

    Route::get('/test', [\App\Http\Controllers\TestController::class, 'test']);

    Route::get('/doc/{language}', [\App\Http\Controllers\PolicyController::class, 'doc'])->name('policy.doc.en');
    Route::get('/marketing/{language}', [\App\Http\Controllers\PolicyController::class, 'marketing'])->name('policy.marketing.en');

    Route::get('/terms-and-conditions', [\App\Http\Controllers\PolicyController::class, 'terms'])->name('policy.terms');
    Route::get('/privacy-policy', [\App\Http\Controllers\PolicyController::class, 'privacy'])->name('policy.privacy');
    Route::get('code-of-conduct', [\App\Http\Controllers\PolicyController::class, 'code_of_conduct'])->name('code.conduct');

    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'home'])->name('home');

    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('purchase_requirements.search');
    Route::get('/__get_search_suggestions', [\App\Http\Controllers\SearchController::class, '__get_search_suggestions'])->name('__get_search_suggestions');

    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('person.login.show');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'handleLogin'])->name('person.login');
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'register'])->name('person.register.show');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'handleRegistration'])->name('person.register');

    Route::get('/register/success', [\App\Http\Controllers\AuthController::class, 'setup_account_success'])->name('person.register.success');

    Route::get('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'submit_email'])->name('person.password.forgot');
    Route::post('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'get_reset_link'])->name('person.password.reset_link');
    Route::get('/reset-password', [\App\Http\Controllers\ForgotPasswordController::class, 'show_reset_password'])->name('person.password.reset_view');
    Route::post('/reset-password', [\App\Http\Controllers\ForgotPasswordController::class, 'reset_password'])->name('person.password.reset');

    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('person.cart.add')->middleware(\App\Http\Middleware\SaveProductOffSession::class);
    Route::delete('/cart', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('person.cart.remove');

    Route::get('/purchase-requirements/{purchase_requirement}', [\App\Http\Controllers\PurchaseRequirementController::class, 'show'])->name('purchase_requirements.show');
    Route::get('/purchase-requirements/s/{slug}', [\App\Http\Controllers\PurchaseRequirementController::class, 'show_slug'])->name('purchase_requirements.show.slug');
    Route::post('/purchase-requirements/{purchase_requirement}/meeting-request', [\App\Http\Controllers\MeetingRequestController::class, 'create'])->name('purchase_requirements.meeting_request.create');

    // agent routes
    Route::get('/agent/login', [\App\Http\Controllers\Agent\AuthController::class, 'login'])->name('agent.login.show');
    Route::post('/agent/login', [\App\Http\Controllers\Agent\AuthController::class, 'handleLogin'])->name('agent.login');

});

Route::group(['prefix' => 'agent', 'middleware' => ['auth.agent', 'page.tracker']], function () {
    Route::get('/', [\App\Http\Controllers\Agent\DashboardController::class, 'index'])->name('agent.dashboard');
    Route::put('/profile', [\App\Http\Controllers\Agent\UsersController::class, 'update_profile'])->name('agent.profile.update');
    Route::get('/profile', [\App\Http\Controllers\Agent\UsersController::class, 'profile'])->name('agent.profile');
    Route::put('/password', [\App\Http\Controllers\Agent\UsersController::class, 'update_password'])->name('agent.password.update');
    Route::get('/users/{user}/transfer', [\App\Http\Controllers\Agent\UsersController::class, 'show_transfer_account'])->name('agent.users.transfer.show');
    Route::post('/users/{user}/transfer', [\App\Http\Controllers\Agent\UsersController::class, 'transfer_account'])->name('agent.users.transfer');

    Route::group(['prefix' => 'meeting-requests'], function () {
        Route::get('/', [\App\Http\Controllers\Agent\MeetingRequestController::class, 'index'])->name('agent.meeting_requests.index')->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);
        Route::get('/{meeting_request}', [\App\Http\Controllers\Agent\MeetingRequestController::class, 'show'])->name('agent.meeting_requests.show');
        Route::post('/{meeting_request}/processed', [\App\Http\Controllers\Agent\MeetingRequestController::class, 'update_status'])->name('agent.meeting_requests.update_status');
    });

    Route::group(['prefix' => 'matchmaking'], function () {
        Route::get('/create', [\App\Http\Controllers\Agent\MatchmakingController::class, 'create'])->name('agent.matchmaking.create');
        Route::get('/', [\App\Http\Controllers\Agent\MatchmakingController::class, 'index'])->name('agent.matchmaking.index')->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);
        Route::get('/{match}', [\App\Http\Controllers\Agent\MatchmakingController::class, 'show'])->name('agent.matchmaking.show');
        Route::post('/create', [\App\Http\Controllers\Agent\MatchmakingController::class, 'store'])->name('agent.matchmaking.store');
        Route::delete('/{match}', [\App\Http\Controllers\Agent\MatchmakingController::class, 'destroy'])->name('agent.matchmaking.destroy');
    });

    Route::group(['prefix' => 'communications'], function () {
        Route::get('/messages', [\App\Http\Controllers\Agent\CommunicationsController::class, 'index'])->name('agent.communication.messages');
    });

    Route::resource('/users', \App\Http\Controllers\Agent\UsersController::class)->names([
        'index' => 'agent.users.index',
        'show'  => 'agent.users.show',
        'create'=> 'agent.users.create',
        'store' => 'agent.users.store',
        'edit'  => 'agent.users.edit',
        'update'=> 'agent.users.update',
        'destroy'=> 'agent.users.destroy',
    ])->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);

    Route::get('/logout', [\App\Http\Controllers\Agent\AuthController::class, 'logout'])->name('agent.logout');

    Route::post('/orders/update/status', [\App\Http\Controllers\Agent\OrderController::class, 'updateStatus'])->name('agent.order.update_status');

    Route::post('/meetings/update/status', [\App\Http\Controllers\Agent\MeetingController::class, 'updateStatus'])->name('agent.meeting.update_status');
    Route::post('/meetings/{meeting}/confirm', [\App\Http\Controllers\Agent\MeetingController::class, 'confirmMeeting'])->name('agent.meeting.confirm');
    Route::post('/meetings/claims', [\App\Http\Controllers\Agent\MeetingController::class, 'claim'])->name('agent.meeting.claim');

    Route::resource('orders', \App\Http\Controllers\Agent\OrderController::class)->names([
        'index' => 'agent.order.index',
        'show'  => 'agent.order.show',
        'create'=> 'agent.order.create',
        'store' => 'agent.order.store',
        'edit'  => 'agent.order.edit',
        'update'=> 'agent.order.update',
        'destroy'=> 'agent.order.destroy',
    ])->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);

    Route::resource('packages', \App\Http\Controllers\Agent\PackageController::class)->names([
        'index' => 'agent.packages.index',
        'show'  => 'agent.packages.show',
        'create'=> 'agent.packages.create',
        'store' => 'agent.packages.store',
        'edit'  => 'agent.packages.edit',
        'update' => 'agent.packages.update',
        'destroy' => 'agent.packages.destroy',
    ]) ->parameters([
        'packages' => 'package'
    ])->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);

    Route::resource('purchase_requirements', \App\Http\Controllers\Agent\PurchaseRequirementsController::class)->names([
        'index' => 'agent.purchase_requirements.index',
        'show'  => 'agent.purchase_requirements.show',
        'create'=> 'agent.purchase_requirements.create',
        'store' => 'agent.purchase_requirements.store',
        'edit'  => 'agent.purchase_requirements.edit',
        'update'=> 'agent.purchase_requirements.update',
        'destroy'=> 'agent.purchase_requirements.destroy',
    ])
    ->parameters([
            'purchase_requirements' => 'purchase_requirement'
    ])->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);

    Route::get('/leads', [\App\Http\Controllers\Agent\LeadsController::class, 'index'])->name('agent.leads.index')->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);
    Route::get('/leads/{lead}', [\App\Http\Controllers\Agent\LeadsController::class, 'show'])->name('agent.leads.show');
    Route::delete('/leads/{lead}', [\App\Http\Controllers\Agent\LeadsController::class, 'destroy'])->name('agent.leads.destroy');

    Route::get('/meetings', [\App\Http\Controllers\Agent\MeetingController::class, 'index'])->name('agent.meetings.index')->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);
    Route::post('/meetings/{meeting}/join', [\App\Http\Controllers\Agent\MeetingController::class, 'join'])->name('agent.meeting.join');
    Route::get('/meetings/{meeting}/waiting-room', [\App\Http\Controllers\Agent\MeetingController::class, 'waiting_room'])->name('agent.meeting.waiting_room.show');
    Route::post('/meetings/{meeting}/waiting-room', [\App\Http\Controllers\Agent\MeetingController::class, 'init_waiting_room'])->name('agent.meeting.waiting_room.init');

    Route::group(['prefix' => '/people'], function () {
        Route::get('/', [\App\Http\Controllers\Agent\PeopleController::class, 'index'])->name('agent.people.index')->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);
        Route::get('/create', [\App\Http\Controllers\Agent\PeopleController::class, 'create'])->name('agent.people.create');
        Route::get('/{person}', [\App\Http\Controllers\Agent\PeopleController::class, 'show'])->name('agent.people.show');
        Route::post('/', [\App\Http\Controllers\Agent\PeopleController::class, 'store'])->name('agent.people.store');
        Route::get('/{person}/edit', [\App\Http\Controllers\Agent\PeopleController::class, 'edit'])->name('agent.people.edit');
        Route::patch('/{person}', [\App\Http\Controllers\Agent\PeopleController::class, 'update'])->name('agent.people.update');
        Route::delete('/{person}', [\App\Http\Controllers\Agent\PeopleController::class, 'destroy'])->name('agent.people.destroy');
    });

    Route::post('/people/{person}/verify', [\App\Http\Controllers\Agent\PeopleController::class, 'verify'])->name('agent.people.verify');
    Route::post('/people/{person}/unsuspend', [\App\Http\Controllers\Agent\PeopleController::class, 'verify'])->name('agent.people.unsuspend');
    Route::get('/people/import/index', [\App\Http\Controllers\Agent\PeopleController::class, 'import'])->name('agent.people.import');
    Route::post('/people/import/store', [\App\Http\Controllers\Agent\PeopleController::class, 'import_store'])->name('agent.people.import_store');

    Route::get('/people/{person}/schedule', [\App\Http\Controllers\Agent\ScheduleController::class, 'show'])->name('agent.people.schedule.show');
    Route::post('/people/{person}/schedule', [\App\Http\Controllers\Agent\ScheduleController::class, 'update'])->name('agent.people.schedule.update');

    Route::get('/settings', [\App\Http\Controllers\Agent\SettingsController::class, 'show'])->name('admin.settings');
    Route::post('/settings/country_pricing', [\App\Http\Controllers\Agent\SettingsController::class, 'update_country_pricing'])->name('admin.settings.country_pricing');
    Route::post('/settings/product_pricing', [\App\Http\Controllers\Agent\SettingsController::class, 'update_product_pricing'])->name('admin.settings.product_pricing');

});
