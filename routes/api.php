<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware'=> ['api', 'persist.alternate_domain']], function () {

    Route::get('/categories', [\App\Http\Controllers\Api\V1\CategoryController::class, 'index']);
    Route::get('/category/{id}', [\App\Http\Controllers\Api\V1\CategoryController::class, 'findCategoryByID']);
    Route::get('/search_categories', [\App\Http\Controllers\Api\V1\CategoryController::class, 'searchCategory'])->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);
    Route::get('/languages', [\App\Http\Controllers\Api\V1\LanguageController::class, 'index']);
    Route::get('/metrics', [\App\Http\Controllers\Api\V1\MetricController::class, 'index']);
    Route::get('/countries', [\App\Http\Controllers\Api\V1\CountryController::class, 'index']);
    Route::get('/timezones', [\App\Http\Controllers\Api\V1\TimezoneController::class, 'index']);

    Route::group(['prefix' => 'purchase_requirements'], function () {
        Route::get('/', [\App\Http\Controllers\Api\V1\PurchaseRequirementsController::class, 'search'])->middleware(\App\Http\Middleware\SanitizeInputMiddleware::class);
        Route::get('/{purchase_requirement}', [\App\Http\Controllers\Api\V1\PurchaseRequirementsController::class, 'show']);
        Route::post('/', [\App\Http\Controllers\Api\V1\PurchaseRequirementsController::class, 'create']);
    });

    Route::group(['prefix' => 'meetings'], function () {
        Route::post('/{meeting}/links', [\App\Http\Controllers\Api\V1\MeetingController::class, 'getLinks']);
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/search', [\App\Http\Controllers\Api\V1\OrderController::class, 'search']);
    });

    Route::post('/search/filters', [\App\Http\Controllers\Api\V1\SearchController::class, 'getFilters']);
    Route::post('/search', [\App\Http\Controllers\Api\V1\SearchController::class, 'search']);

    Route::group(['prefix' => 'leads'], function () {
        Route::post('/', [\App\Http\Controllers\Api\V1\LeadController::class, 'create']);
    });

    Route::group(['prefix' => 'availability'], function () {
        Route::post('/get_time_slots', [\App\Http\Controllers\Api\V1\AvailabilityController::class, 'getTimeSlotsByDay']);
        Route::post('/check_month_availability', [\App\Http\Controllers\Api\V1\AvailabilityController::class, 'checkAvailabilityForMonth']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/search', [\App\Http\Controllers\Api\V1\UserController::class, 'search']);
    });

    Route::group(['prefix' => 'packages'], function () {
        Route::get('/searchByPerson', [\App\Http\Controllers\Api\V1\PackageController::class, 'getByPerson']);
    });

    Route::group(['prefix' => 'people'], function () {
        Route::get('/search', [\App\Http\Controllers\Api\V1\PersonController::class, 'search']);
        Route::get('/{person}', [\App\Http\Controllers\Api\V1\PersonController::class, 'get']);
        Route::get('/', [\App\Http\Controllers\Api\V1\PersonController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Api\V1\PersonController::class, 'create']);
        Route::post('/export', [\App\Http\Controllers\Api\V1\PersonController::class, 'export']);

        Route::group(['prefix' => '{person}/availability'], function () {
            Route::post('/date_override', [\App\Http\Controllers\Api\V1\AvailabilityController::class, 'addDateOverride']);
        });
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/{user}', [\App\Http\Controllers\Api\V1\UserController::class, 'get']);
        Route::get('/', [\App\Http\Controllers\Api\V1\UserController::class, 'index']);
    });

    Route::group(['prefix' => 'communications'], function () {
        Route::get('/conversations', [\App\Http\Controllers\Api\V1\CommunicationsController::class, 'getConversations']);
        Route::post('/conversations', [\App\Http\Controllers\Api\V1\CommunicationsController::class, 'createConversation']);
        Route::get('/conversations/{conversation}', [\App\Http\Controllers\Api\V1\CommunicationsController::class, 'getConversation']);
        Route::post('/conversations/{conversation}/message', [\App\Http\Controllers\Api\V1\CommunicationsController::class, 'saveMessage']);
    });
});
