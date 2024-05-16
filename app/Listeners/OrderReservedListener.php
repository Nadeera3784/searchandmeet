<?php

namespace App\Listeners;

use App\Events\OrderReserved;
use App\Services\Order\OrderServiceInterface;
use Illuminate\Support\Facades\Log;

class OrderReservedListener
{
    private $orderService;
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function handle(OrderReserved $event)
    {
        $order = $event->order;

        try
        {
            $this->orderService->reserveOrder($order);
            $event->order->person->notify(new \App\Notifications\OrderReserved($event->order));
        }
        catch (\Exception $exception)
        {
            Log::error($exception->getMessage(), ['error' => $exception]);
        }
    }
}
