<?php

namespace App\Http\Middleware;

use App\Enums\Person\AccountStatus;
use App\Models\Business;
use Closure;
use \Illuminate\Http\Request;
use \Illuminate\Support\Facades\Auth;

class CheckPersonStatus
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
        if(Auth::guard('person')->check())
        {
            $person = Auth::guard('person')->user();
            if($person->status === AccountStatus::OnBoarding)
            {
                $request->session()->put('redirect_after_onboarding', $request->url());
                return redirect()->route('person.onboarding')->with('warning', 'Please complete the on boarding process.');
            }
        }

        return $next($request);
    }
}
