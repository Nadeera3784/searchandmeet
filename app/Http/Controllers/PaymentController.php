<?php

namespace App\Http\Controllers;

use App\Enums\Order\OrderItemType;
use App\Enums\Order\OrderStatus;
use App\Enums\PaymentSourceStatus;
use App\Http\Requests\Web\Order\CheckoutRequest;
use App\Models\Order;
use App\Services\Cart\CartService;
use App\Services\Order\OrderServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    private $cartService;
    private $orderService;

    public function __construct(CartService $cartService, OrderServiceInterface $orderService)
    {
        $this->cartService  = $cartService;
        $this->orderService  = $orderService;
    }

    public function checkout(CheckoutRequest $request)
    {
        $total = null;
        $user = null;
        $order = null;
        try {
            if ($request->has('order_id')) {
                $id = \Hashids::connection(Order::class)->decode($request->validated()['order_id'])[0] ?? null;
                $order = Order::find($id);
                $user = $order->person;
            } else {
                $cartItems = $this->cartService->getItems();
                $user = auth('person')->user();

                if (count($cartItems) === 0) {
                    throw new \Exception('No items in cart');
                }

                $order = $user->orders()->create([
                    'status' => OrderStatus::Draft
                ]);

                foreach ($cartItems as $cartItem) {
                    if ($cartItem['type'] != OrderItemType::AccessInformation) {
                        throw new \Exception('Unable to checkout item type');
                    }

                    $order->items()->create([
                        'purchase_requirement_id' => $cartItem['purchase_requirement']->id,
                        'timeslot_id' => $cartItem['timeslot'] ? $cartItem['timeslot']->id : null,
                        'type' => $cartItem['type'],
                    ]);
                }
            }

            $use_default_card = $request->validated()['use_default_card'];
            $payment_method_id = null;

            if (!$use_default_card) {
                $payment_method = $request->validated()['payment_method'];
                $save_as_default = $request->validated()['save_as_default'];

                if ($save_as_default) {
                    $user->updateDefaultPaymentMethod($payment_method['id']);
                } else {
                    $payment_method_id = $payment_method['id'];
                }
            }

            $this->orderService->pay($order, $user, $payment_method_id);
            $this->cartService->clearCart();
            return response()->json(['message' => 'success'], 200);

        } catch (\Exception $exception) {
            if (property_exists($exception, 'payment')) {
                if ($exception->payment->requiresAction()) {
                    return response()->json(['message' => 'requires_action', 'client_secret' => $exception->payment->client_secret], 400);
                }

                if ($exception->payment->requiresConfirmation()) {
                    return response()->json(['message' => 'requires_confirmation', 'client_secret' => $exception->payment->client_secret], 400);
                }
            } else {
                return response()->json(['message' => 'failed', 'error' => $exception->getMessage()], 400);
            }
        }
    }

    public function get_payment_source(Request $request)
    {
        $total = null;
        $order = null;
        try {
            if ($request->has('order_id')) {
                $id = \Hashids::connection(Order::class)->decode($request->order_id)[0] ?? null;
                $order = Order::find($id);
                $total = $this->orderService->getTotal($order);
            } else {
                $total = $this->cartService->getTotal();
                $cartItems = $this->cartService->getItems();
                $user = auth('person')->user();

                if (count($cartItems) === 0) {
                    throw new \Exception('No items in cart');
                }

                $order = $user->orders()->create([
                    'status' => OrderStatus::Draft
                ]);

                foreach ($cartItems as $cartItem) {
                    $order->items()->create([
                        'purchase_requirement_id' => $cartItem['purchase_requirement']->id,
                        'timeslot_id' => $cartItem['timeslot'] ? $cartItem['timeslot']->id : null,
                        'type' => $cartItem['type'],
                    ]);
                }
            }

            $stripe = new \Stripe\StripeClient(config('services.stripe.key'));
            $source = $stripe->sources->create([
                "type" => "wechat",
                "currency" => "usd",
                "amount" => $total * 100
            ]);

            DB::table('payment_sources')->insert([
                'type' => 'wechat',
                'source_id' => $source->id,
                'order_id' => $order->id
            ]);

            return response()->json(['message' => 'success', 'qr_code_url' => $source->wechat->qr_code_url, 'source_id' => $source->id], 200);

        } catch (\Exception $exception) {
            return response()->json(['message' => 'failed', 'error' => $exception->getMessage()], 400);
        }
    }

    public function check_source_authorization(Request $request)
    {
        try
        {
            if(!$request->has('source_id'))
            {
                throw new \Exception('Payment source is required');
            }

            $payment_source = DB::table('payment_sources')->where('source_id', $request->source_id)->first();
            $order = Order::findorfail($payment_source->order_id);

            if(!$payment_source || !$order)
            {
                throw new \Exception('Order expired');
            }

            if($order->status !== OrderStatus::Completed && $payment_source->status === PaymentSourceStatus::Chargeable)
            {
                return response()->json(['message' => 'success', 'status' => 'authorized'], 200);
            }
            else
            {
                return response()->json(['message' => 'success', 'status' => 'unauthorized'], 200);
            }

        } catch (\Exception $exception) {
            return response()->json(['message' => 'failed', 'error' => $exception->getMessage()], 400);
        }
    }


    public function process_source_payment(Request $request)
    {
        try
        {
            if(!$request->has('source_id'))
            {
                throw new \Exception('We chat source is required');
            }

            $payment_source = DB::table('payment_sources')->where('source_id', $request->source_id)->first();
            $order = Order::findorfail($payment_source->order_id);


            if($payment_source->status === PaymentSourceStatus::Chargeable)
            {
                if($order->status === OrderStatus::Completed)
                {
                    return response()->json(['message' => 'success', 'status' => 'completed'], 200);
                }
                else
                {
                    $this->orderService->payWithWechat($order, $payment_source);

                    $this->cartService->clearCart();
                    return response()->json(['message' => 'success', 'status' => 'completed'], 200);
                }
            }
            else
            {
                throw new \Exception('Source is not chargeable');
            }

        } catch (\Exception $exception) {
            return response()->json(['message' => 'failed', 'error' => $exception->getMessage()], 400);
        }
    }
}
