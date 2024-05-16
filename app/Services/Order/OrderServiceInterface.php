<?php


namespace App\Services\Order;

use App\Enums\Meeting\MeetingStatus;

interface OrderServiceInterface
{
    public function getItemCost($item);

    public function getTotal($order);

    public function pay($order, $person = null, $customPaymentMethod = null);

    public function payWithWechat($order, $payment_source, $person = null);

    public function completeOrder($order);

    public function cancelOrder($order, $meetingStatus = MeetingStatus::Cancelled);

    public function clearDrafts();

    public function reserveOrder($order);
}
