<?php


namespace App\Services\Order;

use App\Enums\Meeting\MeetingStatus;
use App\Enums\Order\OrderItemType;
use App\Enums\Order\OrderStatus;
use App\Enums\TransactionStatus;
use App\Events\ActiveMeetingCreated;
use App\Events\OrderCompleted;
use App\Models\Order;
use App\Services\Payment\PaymentService;
use App\Services\VideoCommService\VideoCommProviderInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderService implements OrderServiceInterface
{
    private $videoCommProvider;
    private $meetingRepository;
    private $orderRepository;
    private $costCalculatorService;
    private $transactionRepository;
    private $videoCommEnabled = false;
    private $paymentService;

    public function __construct(VideoCommProviderInterface $videoCommProvider, $meetingRepository, $orderRepository, $transactionRepository, $costCalculatorService, PaymentService $paymentService)
    {
        $this->videoCommProvider = $videoCommProvider;
        $this->meetingRepository = $meetingRepository;
        $this->meetingRepository = $meetingRepository;
        $this->transactionRepository = $transactionRepository;
        $this->orderRepository = $orderRepository;
        $this->costCalculatorService = $costCalculatorService;
        $this->paymentService = $paymentService;

        if(config('app.env') === 'production') {
            $this->videoCommEnabled = true;
        }
    }

    public function getItemCost($item)
    {
        $country = $item->purchase_requirement->person->business->country;
        return $this->costCalculatorService->calculate($country->id, $item->cost());
    }

    public function getTotal($order)
    {
        $total = 0;
        foreach ($order->items as $item) {
            $country = $item->purchase_requirement->person->business->country;
            $total = $total + $this->costCalculatorService->calculate($country->id, $item->type);
        }

        return $total;
    }

    public function pay($order, $person = null, $customPaymentMethod = null)
    {
        $transaction = null;
        try {
            if (!$person) {
                if (!auth('person')->check()) throw new \Exception('Person unavailable for payment');
                $person = auth('person')->user();
            }

            if ($customPaymentMethod) {
                $payment_method_id = $customPaymentMethod;
            } else {
                $payment_method_id = $person->defaultPaymentMethod()->id;
            }

            $cost = $this->getTotal($order);
            $total = $cost * 100;

            $transaction = $this->getTransaction($order, $person);

            $charge = $this->paymentService->createCharge('card', [
                'person' => $person,
                'payment_method' => $payment_method_id,
                'transaction' => $transaction,
            ], $total);

            $this->transactionRepository->update([
                'processor_reference' => $charge->id
            ], $transaction->id);

            return $charge;
        } catch (\Exception $exception) {
            if (property_exists($exception, 'payment')) {
                $this->transactionRepository->update([
                    'status' => TransactionStatus::Failed,
                    'processor_reference' => $exception->payment->id
                ], $transaction->id);
            } else {
                $this->transactionRepository->delete($transaction->id);
            }

            throw $exception;
        }
    }

    public function payWithWechat($order, $payment_source, $person = null)
    {
        $transaction = null;
        try {
            $order->update([
                'status' => OrderStatus::Pending
            ]);

            if (!$person) {
                if (!auth('person')->check()) throw new \Exception('Person unavailable for payment');
                $person = auth('person')->user();
            }

            $cost = $this->getTotal($order);
            $total = $cost * 100;

            $transaction = $this->getTransaction($order, $person);

            $charge = $this->paymentService->createCharge('wechat', [
                'person' => $person,
                'payment_source' => $payment_source,
                'transaction' => $transaction,
            ], $total);

            $this->transactionRepository->update([
                'processor_reference' => $charge->id
            ], $transaction->id);

            return $charge;
        } catch (\Exception $exception) {
            if ($transaction) {
                $this->transactionRepository->delete($transaction->id);
            }

            throw $exception;
        }
    }

    public function completeOrder($order)
    {
        $this->orderRepository->update([
            'status' => OrderStatus::Completed
        ], $order->id);

        //delete source records if orders have been completed
        DB::table('payment_sources')->where('order_id', $order->id)->delete();

        OrderCompleted::dispatch($order);
    }

    public function cancelOrder($order, $meetingStatus = MeetingStatus::Cancelled)
    {
        $this->orderRepository->update([
            'status' => OrderStatus::Cancelled
        ], $order->id);

        if($order->items->count() > 0 && $order->items[0]->meeting)
        {
            $order->items[0]->meeting->update([
                'status' => $meetingStatus
            ]);
        }
    }

    public function clearDrafts()
    {
        Order::where('status', OrderStatus::Draft)->delete();
    }

    private function getTransaction($order, $person)
    {
        if ($transaction = $order->transaction) {
            return $transaction;
        } else {
            return $this->transactionRepository->create([
                'order_id' => $order->id,
                'processor_reference' => null,
                'amount' => $this->getTotal($order),
            ], $person);
        }
    }

    public function reserveOrder($order)
    {
        $person = $order->person;

        if ($this->videoCommEnabled) {
            $this->videoCommProvider->setUser();
            $this->videoCommProvider->login();
        }


        foreach ($order->items as $item) {
            $purchase_requirement = $item->purchase_requirement;
            $timeslot = $item->timeSlot;
            $type = $item->type;

            switch ($type) {
                case OrderItemType::MeetingWithHost:
                    $status = MeetingStatus::Scheduled;
                    $agent_id = $purchase_requirement->person->agent_id ?? null;

                    $meeting = $item->meeting()->create([
                        'status' => $status
                    ]);

                    try {
                        $response = null;
                        if ($this->videoCommEnabled) {
                            $response = $this->videoCommProvider->createMeeting([
                                "title" => 'Search Meetings - meeting ' . $meeting->getRouteKey(),
                                "description" => 'Meeting between ' . $purchase_requirement->person->name . ' - ' . $order->person->name,
                                "timezone" => $purchase_requirement->person->timezone->name,
                                "start_on" => $timeslot->start,
                            ]);
                        }

                        if(!$agent_id)
                        {
                            $status = MeetingStatus::Requires_Participant;
                        }

                        $this->meetingRepository->update([
                            'agent_id' => $agent_id,
                            'service_id' => $this->videoCommEnabled ? $response->data->id : Str::random(10),
                            'status' => $status
                        ], $meeting->id);

                        $this->orderRepository->update([
                            'status' => OrderStatus::Pending
                        ], $order->id);

                        $meeting = $this->meetingRepository->getById($meeting->id);
                        ActiveMeetingCreated::dispatch($meeting);
                    } catch (\Exception $exception) {
                        Log::error($exception->getMessage(), ['error' => $exception]);
                        $meeting->delete();
                    }
                    break;
                case OrderItemType::BookAndMeet:

                    $meeting = $item->meeting()->create([
                        'status' => MeetingStatus::Requires_Participant
                    ]);

                    try {
                        $response = null;
                        if ($this->videoCommEnabled) {
                            $response = $this->videoCommProvider->createMeeting([
                                "title" => 'Search Meetings - meeting ' . $meeting->getRouteKey(),
                                "description" => 'Meeting between ' . $purchase_requirement->person->name . ' - ' . $order->person->name,
                                "timezone" => $purchase_requirement->person->timezone->name,
                                "start_on" => $timeslot->start,
                            ]);
                        }

                        $this->meetingRepository->update([
                            'service_id' => $this->videoCommEnabled ? $response->data->id : Str::random(10),
                            'status' => MeetingStatus::Scheduled
                        ], $meeting->id);

                        $this->orderRepository->update([
                            'status' => OrderStatus::Pending
                        ], $order->id);

                        $meeting = $this->meetingRepository->getById($meeting->id);
                        ActiveMeetingCreated::dispatch($meeting);
                    } catch (\Exception $exception) {
                        Log::error($exception->getMessage(), ['error' => $exception]);
                        $meeting->delete();
                    }

                    break;
            }

            if ($this->videoCommEnabled) {
                $this->videoCommProvider->logout();
            }
        }
    }
}
