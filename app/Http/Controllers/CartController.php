<?php

namespace App\Http\Controllers;

use App\Enums\Order\OrderItemType;
use App\Enums\Order\OrderStatus;
use App\Models\PurchaseRequirement;
use App\Services\Cart\CartService;
use App\Services\Events\EventTrackingService;
use App\Services\Language\TranslationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    const DURATION = 30;
    private $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService  = $cartService;
    }

    public function show(TranslationService $translationService)
    {
        $current_purchase_requirement = null;
        $translationCombinations = [];
        $personA = auth('person')->user();
        if ($this->cartService->getItemCount()>0) {
            $current_purchase_requirement = $this->cartService->getItemProduct(1);
            $translationCombinations = $translationService->getTranslationCombinations($personA, $current_purchase_requirement->person);
        }
        return view('cart.show', get_defined_vars());
    }

    public function addToCart(Request $request, EventTrackingService $userEventsService)
    {
        if($request->type != OrderItemType::AccessInformation && !$request->timeslot)
        {
            return redirect()->back()->with('error', 'Please select a time slot');
        }

        $userEventsService->track('Meet and close the deal pick', array(
           "selected_product" => PurchaseRequirement::find($request->purchase_requirement)->product,
           "selected_method"  => $this->cartService->getItemTypeDescription($request->type),
           "sessionId"        => Session::getId()
        ));

        $this->cartService->addToCart($request->purchase_requirement, $request->type, $request->timeslot);
        return redirect()->route('person.cart.show')->with('success', 'Added to reservation list successfully!');

    }

    public function removeFromCart(Request $request)
    {
        $this->cartService->removeFromCart($request->item_id);
        return redirect()->back()->with('success', 'Removed from list successfully!');
    }

    public function reserve(Request $request)
    {
        $user = auth('person')->user();
        $cart = $this->cartService->getItems();

        $order = $user->orders()->create([
            'status' => OrderStatus::Draft
        ]);

        $translator_required = false;
        if($request->has('translator') && $request->translator !== 'none')
        {
            $translator_required = $request->translator;
        }

        foreach($cart as $cartItem)
        {
            $start_time = Carbon::parse($cartItem['timeslot']);
            $end_time = Carbon::parse($cartItem['timeslot'])->addMinutes(self::DURATION);

            $start = $start_time->toString();
            $end   = $end_time->toString();

            $order_item = $order->items()->create([
                'purchase_requirement_id' => $cartItem['purchase_requirement']->id,
                'type' => $cartItem['type'],
                'required_translator' => $translator_required
            ]);

            $order_item->timeSlot()->create([
                'start' => $start,
                'end'   => $end
            ]);
        }

        \App\Events\OrderReserved::dispatch($order);

        $this->cartService->clearCart();

        return redirect()->route('person.orders.index')->with('success', 'Reserved meeting successfully!');
    }



}
