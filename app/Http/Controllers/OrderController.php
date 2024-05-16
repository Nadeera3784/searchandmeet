<?php

namespace App\Http\Controllers;

use App\Enums\Order\OrderStatus;
use App\Repositories\Order\OrderRepositoryInterface;
use Faker\Factory;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OrderRepositoryInterface $orderRepository)
    {
        $draftOrders = Order::where('status', OrderStatus::Draft)->where('person_id', auth('person')->user()->id)->get();
        foreach ($draftOrders as $order)
        {
            $orderRepository->delete($order->id);
        }

        $orders = $orderRepository->getByUser(auth('person')->user());
        return view('orders.index', get_defined_vars());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $order)
    {
        $faker = Factory::create();
        return view('orders.show', get_defined_vars());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($order)
    {
        if ($order->delete()) {
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
        }

        return back()->with('error', 'Something went wrong!');
    }
}
