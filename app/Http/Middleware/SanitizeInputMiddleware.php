<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInputMiddleware
{
    public function handle($request, Closure $next)
    {
        foreach ($request->input() as $key => $value) {
            if (empty($value)) {
                unset($request[$key]);
            }
        }

        return $next($request);
    }
}
