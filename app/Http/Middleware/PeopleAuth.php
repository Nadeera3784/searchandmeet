<?php

namespace App\Http\Middleware;

use App\Services\Cart\CartService;
use Closure;
use \Illuminate\Support\Facades\Auth;

class PeopleAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (false == Auth::guard('person')->check()) {
            if($request->url() === route('person.cart.add'))
            {
                $cartService = app()->make(CartService::class);
                $cartService->addToCart($request->purchase_requirement, $request->type, $request->timeslot);
                $request->session()->put('redirect_after_login', route('person.cart.show'));
            }
            else
            {
                $request->session()->put('redirect_after_login', $request->url());
            }

            return redirect()->route('person.login');
        }

        return $next($request);
    }
}
