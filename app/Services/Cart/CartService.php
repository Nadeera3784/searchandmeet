<?php


namespace App\Services\Cart;

use App\Enums\Order\OrderItemType;
use App\Models\PurchaseRequirement;
use App\Models\Timeslot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    private $costCalculatorService;
    public function __construct($costCalculatorService)
    {
        $this->costCalculatorService = $costCalculatorService;
    }

    public function addToCart($purchase_requirement, $type, $timeslot = null)
    {
        $this->clearCart();
        if($cart = Session::get('cart'))
        {
            $id = count($cart) + 1;

            $cartItem = [];
            $cartItem['purchase_requirement'] = $purchase_requirement;
            $cartItem['timeslot'] = $timeslot;
            $cartItem['type'] = $type;

            $cart[$id] = $cartItem;

            Session::put('cart', $cart);
        }
        else
        {
            $cart = [];
            $id = 1;

            $cartItem = [];
            $cartItem['purchase_requirement'] = $purchase_requirement;
            $cartItem['timeslot'] = $timeslot;
            $cartItem['type'] = $type;

            $cart[$id] = $cartItem;

            Session::put('cart', $cart);
        }
    }

    public function removeFromCart($id)
    {
        if($cart = Session::get('cart'))
        {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
    }

    public function getTotal()
    {
        $total = 0;
        $cart = Session::get('cart');
        foreach ($cart as $item)
        {
            $purchase_requirement = PurchaseRequirement::find($item['purchase_requirement']);
            $cost = $this->getItemCost($item['type'], $purchase_requirement->person->business->country->id);
            $total = $total + $cost;
        }

        return $total;
    }

    public function getItemCost($type, $country_id = null)
    {
        $base_cost = DB::table('product_pricing')->where('product_type',  $type)->first();
        $price = $base_cost->price;
        switch($type)
        {
            case OrderItemType::AccessInformation:
                return $country_id ? $this->costCalculatorService->calculate($country_id, OrderItemType::AccessInformation) : $price;
            case OrderItemType::BookAndMeet:
                return $country_id ? $this->costCalculatorService->calculate($country_id, OrderItemType::BookAndMeet) : $price;
            case OrderItemType::MeetingWithHost:
                return $country_id ? $this->costCalculatorService->calculate($country_id, OrderItemType::MeetingWithHost) : $price;
        }
    }

    public function clearCart()
    {
        Session::put('cart', []);
    }

    public function getItemCount()
    {
        $count = 0;
        $cart = Session::get('cart');
        if($cart && count($cart) > 0)
        {
            $count = count($cart);
        }

        return $count;
    }

    public function getItems()
    {
        $cart = Session::get('cart');
        $items = [];
        if($cart && count($cart) > 0)
        {
            foreach($cart as $key => $cartItem)
            {

                $purchase_requirement = PurchaseRequirement::find($cartItem['purchase_requirement']);
                $type = $cartItem['type'];

                $cartItem['id'] = $key;
                $cartItem['purchase_requirement'] = $purchase_requirement;
                $cartItem['type'] = $type;

                array_push($items,  $cartItem);
            }
        }

        return $items;
    }

    public function getItemProduct($index)
    {
        $cartItems = Session::get('cart');
        $id = $cartItems[$index]['purchase_requirement'];

        return PurchaseRequirement::find($id);
    }

    public function getItemTypeDescription($type){
        $native_type = '';

        if(!empty($type)){
            if (array_key_exists($type, OrderItemType::asSelectArray())) {
                $native_type = OrderItemType::asSelectArray()[$type];
            }
        }

        return $native_type;
    }
}
