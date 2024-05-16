<?php

namespace App\Http\Controllers\Webhook;

use App\Enums\Package\PackageStatus;
use App\Enums\PaymentProcessor;
use App\Enums\PaymentSourceStatus;
use App\Enums\TransactionStatus;
use App\Models\Package;
use App\Models\Person;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Services\Cart\CartService;
use App\Services\Order\OrderServiceInterface;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class StripeWebhookController extends CashierController
{
    private $transactionRepository;
    private $orderService;
    private $cartService;

    public function __construct(TransactionRepositoryInterface $transactionRepository, OrderServiceInterface $orderService, CartService $cartService){
        parent::__construct();
        $this->transactionRepository = $transactionRepository;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    protected function getUserByStripeId($stripeId)
    {
        return Person::where('stripe_id', $stripeId)->first();
    }

    public function handlePaymentIntentCreated($payload)
    {

    }

    public function handleChargeSucceeded($payload)
    {
        $charge_id = $payload['data']['object']['id'];
        $receipt_url = $payload['data']['object']['receipt_url'];
        $transaction = $this->transactionRepository->getByService(PaymentProcessor::Stripe, $charge_id);

        if($transaction)
        {
            $this->transactionRepository->update([
                'status' => TransactionStatus::Completed,
                'receipt_url' => $receipt_url
            ], $transaction->id);

            $order = $transaction->order;
            $this->orderService->completeOrder($order);

            $this->orderService->clearDrafts();
            $this->cartService->clearCart();
        }

        return $this->successMethod();
    }

    public function handleChargeFailed($payload)
    {
        $charge_id = $payload['data']['object']['id'];
        $transaction = $this->transactionRepository->getByService(PaymentProcessor::Stripe, $charge_id);

        if($transaction)
        {
            $this->transactionRepository->update([
                'status' => TransactionStatus::Failed,
            ], $transaction->id);
        }

        return $this->successMethod();
    }

    public function handleChargeUpdated($payload)
    {

    }

    public function handleInvoicePaid($payload)
    {
        $invoice_id = $payload['data']['object']['id'];
        $package = Package::where('invoice_id', $invoice_id)->firstOrFail();

        $package->update([
            'status' => PackageStatus::Active
        ]);

        return $this->successMethod();
    }

    public function handleInvoicePaymentSucceeded($payload)
    {

        return $this->successMethod();
    }

    public function handleSourceCancelled($payload)
    {
        $source_id = $payload['data']['object']['id'];
        DB::table('payment_sources')->where('source_id', $source_id)->delete();

        return $this->successMethod();
    }

    public function handleSourceChargeable($payload)
    {
        $source_id = $payload['data']['object']['id'];
        DB::table('payment_sources')->where('source_id', $source_id)->update(['status' => PaymentSourceStatus::Chargeable]);

        return $this->successMethod();
    }

    public function handleSourceFailed($payload)
    {
        $source_id = $payload['data']['object']['id'];
        DB::table('payment_sources')->where('source_id', $source_id)->update(['status' => PaymentSourceStatus::Failed]);

        return $this->successMethod();
    }

}
