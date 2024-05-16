<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Events\EventTrackingService;

class PageTracker{

    public function handle($request, Closure $next){
        $eventService = app()->make(EventTrackingService::class);
        $eventService->page('Page', $request->path(), array('path' => $request->fullUrl()));
        return $next($request);
    }
}
