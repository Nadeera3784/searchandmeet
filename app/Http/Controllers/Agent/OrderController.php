<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\Order\OrderItemType;
use App\Enums\Order\OrderStatus;
use App\Events\OrderReserved;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\Order\CreateOrderRequest;
use App\Models\Package;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\Order\OrderServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller {

    public function __construct(){
        $this->middleware(\App\Http\Middleware\OrderLimit::class)->only(['store']);
    }

    public function index(Request $request)
    {
        $role = auth('agent')->user()->role->value;
        $orders = Order::with('person')->with('items');
        $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id');

        $orders->where('status', '!=', OrderStatus::Draft);

        if($role === AgentRoles::agent)
        {
            $orders = $orders->whereHas('person', function ($q){
                $q->where('agent_id', '=', auth('agent')->user()->id);
            });

            $orders = $orders->orWhereHas('purchase_requirement', function ($q){
                $q->whereHas('person', function ($q){
                    $q->where('agent_id', '=', auth('agent')->user()->id);
                });
            });

            $people = $people->where('agent_id', auth('agent')->user()->id);
        }

        $people = $people->pluck('name', 'id');

        if($request->has('id'))
        {
            $id = \Hashids::connection(Order::class)->decode($request->get('id'))[0] ?? null;
            $orders = $orders->where('id', $id);
        }

        if($request->has('status'))
        {
            $orders = $orders->where('status', $request->get('status'));
        }

        if($request->has('person_id'))
        {
            $orders = $orders->where('person_id', $request->person_id);
        }

        $orders = $orders->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('agent.orders.index', get_defined_vars());
    }

    public function show(Request $request, $order)
    {
        return view('agent.orders.show', get_defined_vars());
    }

    public function create(Request $request)
    {
        $order_types = OrderItemType::asSelectArray();

        return view('agent.orders.create', get_defined_vars());
    }

    public function store(CreateOrderRequest $request, OrderRepositoryInterface $orderRepository){

        $personId =\Hashids::connection(Person::class)->decode($request->validated()['person_id'])[0] ?? null;
        $person = Person::findOrFail($personId);

        $order = $orderRepository->create([
            'person_id' => $person->id,
            'status' => OrderStatus::Draft
        ]);

        $translator_required = $request->has('requires_translator');

        $purchase_requirement =\Hashids::connection(PurchaseRequirement::class)->decode($request->validated()['purchase_requirement_id'])[0] ?? null;

        $find_purchase_requirement_by_id = PurchaseRequirement::find($purchase_requirement);

        $data = array(
            'buyer_id'             => $request->validated()['person_id'],
            'supplier_id'          => $find_purchase_requirement_by_id->person_id,
            'order_id'             => $order->id,
            'is_buyer_attended'    => '0',
            'is_supplier_attended' => '0'
        );

        if($request->order_type == '1'){
            $data['agent_id']          = $find_purchase_requirement_by_id->person_id;
            $data['is_agent_attended'] = '0';
        }

        $start_time = Carbon::parse($request->validated()['timeslot']);
        $end_time = Carbon::parse($request->validated()['timeslot'])->addMinutes(config('meeting.default_duration'));

        $start = $start_time->toString();
        $end   = $end_time->toString();

        $package_id = null;
        if($request->has('package_id')) {
            $package_id = \Hashids::connection(Package::class)->decode($request->validated()['package_id'])[0] ?? null;
        }

        $order_item = $orderRepository->addItem($order, [
            'purchase_requirement_id' => $purchase_requirement,
            'type' => $request->validated()['order_type'],
            'required_translator' => $translator_required,
            'package_id' => $package_id,
        ]);

        $order_item->timeSlot()->create([
            'start' => $start,
            'end'   => $end
        ]);

        OrderReserved::dispatch($order);

      return redirect()->route('agent.order.index')->with('success','Order created successfully!');
    }

    public function destroy($order)
    {
        if ($order->delete()) {
            return redirect()->route('agent.order.index')->with('success', 'Order deleted successfully!');
        }

        return back()->with('error', 'Something went wrong!');
    }

    public function updateStatus(Request $request, OrderServiceInterface $orderService)
    {
        $status = $request->get('status');
        $orderId = \Hashids::connection(Order::class)->decode($request->get('order_id'))[0] ?? null;
        $order = Order::find($orderId);

        if(!$status)
        {
            return redirect()->back()->with('error', 'Please select a new status');
        }

        if($order && ($order->status !== OrderStatus::Cancelled && $order->status !== OrderStatus::Completed))
        {
            if($status == OrderStatus::Completed)
            {
                if($order->items[0]->package)
                {
                    $package = $order->items[0]->package;
                    if($package->quota_used < $package->allowed_meeting_count)
                    {
                        $order->items[0]->package->update([
                            'quota_used' => $package->quota_used + 1
                        ]);

                        $orderService->completeOrder($order);
                    }
                    else
                    {
                        return redirect()->route('agent.order.index')->with('error', 'Unable to complete order, Package quota limit reached');
                    }
                }

                $orderService->completeOrder($order);
                return redirect()->route('agent.order.index')->with('success', 'Order updated successfully!');
            }
            else if ($status == OrderStatus::Cancelled)
            {
                $orderService->cancelOrder($order);
                return redirect()->route('agent.order.index')->with('success', 'Order updated successfully!');
            }
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }
}
