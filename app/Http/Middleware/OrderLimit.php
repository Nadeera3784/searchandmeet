<?php

namespace App\Http\Middleware;

use App\Enums\Order\OrderStatus;
use App\Enums\Agent\AgentRoles;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderLimit
{

    public function handle(Request $request, Closure $next)
    {

        $user_id = null;

        if (auth('person')->check()) {
            $user_id = auth('person')->user()->id;

            $orders_exist = Order::where('person_id', $user_id)->get();
            if ($orders_exist) {
                $pending_orders = Order::where('person_id', $user_id)->where('status', OrderStatus::Pending)->count();
                if ($pending_orders >= 10) {
                    return redirect()->back()->with('error', 'You have reached the maximum number of pending orders. please complete the pending orders');
                }
            }

        } else if (auth('agent')->check()) {
            $user_id = auth('agent')->user()->id;

            $role = auth('agent')->user()->role->value;

            if ($role === AgentRoles::agent) {
                $orders_exist = Order::where('person_id', $request->person_id)->get();
                if ($orders_exist) {
                    $pending_orders = Order::where('person_id', $request->person_id)->where('status', OrderStatus::Pending)->count();
                    if ($pending_orders >= 10) {
                        return redirect()->back()->with('error', 'This person has reached the maximum number of pending orders. No more orders can be created until they\'re completed');
                    }
                }
            }
        }
        return $next($request);
    }
}
