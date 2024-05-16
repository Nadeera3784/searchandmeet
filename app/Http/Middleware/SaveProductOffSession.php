<?php

namespace App\Http\Middleware;

use App\Enums\Person\AccountStatus;
use App\Models\Business;
use Closure;
use \Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveProductOffSession
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
        if($request->has('purchase_requirement') && !auth('person')->check())
        {
            $request->session()->put('persist_cart', [
                'purchase_requirement_id' => $request->purchase_requirement,
                'time_slot_id' => $request->timeslot,
                'type' => $request->type,
            ]);
        }

        return $next($request);
    }
}
