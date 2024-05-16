<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PersistDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($current_domain = $request->current_domain)
        {
            if((session()->has('current_domain') && $current_domain !== session()->get('current_domain')) || !session()->has('current_domain'))
            {
                session()->put('current_domain', $current_domain);
            }
        }
        else if($current_domain = $request->getHost())
        {
            if($current_domain)
            {
                if((session()->has('current_domain') && $current_domain !== session()->get('current_domain')) || !session()->has('current_domain'))
                {
                    session()->put('current_domain', $current_domain);
                }
            }
        }

        return $next($request);
    }
}
