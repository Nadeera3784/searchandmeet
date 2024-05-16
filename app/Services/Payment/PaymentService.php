<?php


namespace App\Services\Payment;

use App\Models\Person;
use Carbon\Carbon;
use Stripe\Exception\InvalidRequestException;

class PaymentService
{
    private $stripe;

    public function __construct()
    {
        $this->stripe = $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
    }

    public function createPaymentLink()
    {

    }

    public function createCharge($type, $data, $total)
    {
        switch($type)
        {
            case "card":
                $paymentTransaction = $data['person']->charge(
                    $total, $data['payment_method'], [
                        'description' => 'Search meetings reservation charge ' . $data['transaction']->getRouteKey(),
                        'receipt_email' => $data['person']->email
                    ]
                );

                return $paymentTransaction->charges->data[0];
                break;
            case "wechat":
                return \Stripe\Charge::create([
                    'amount' => $total,
                    'currency' => config('cashier.currency'),
                    'source' => $data['payment_source']->source_id,
                ]);
                break;
        }
    }

    public function createProduct($package)
    {
        $product =  $this->stripe->products->create(array(
                "id" => $package->getRouteKey(),
                "name" => $package->title,
            )
        );

        return $product;
    }

    public function deleteProduct($package)
    {
        $product =  $this->stripe->products->delete($package->getRouteKey());
        return $product;
    }

    public function createPrice($product, $price)
    {
        $price = $this->stripe->prices->create([
            'product' => $product->id,
            'unit_amount' => $price * 100,
            'currency' => config('cashier.currency'),
        ]);

        return $price;
    }

    public function createInvoice($person, $price)
    {
        $person = $this->checkStripeCustomer($person);

        try
        {
            $invoiceItem = $this->stripe->invoiceItems->create([
                'customer' => $person->stripeId(),
                'price' => $price->id,
            ]);

            $invoice = $this->stripe->invoices->create([
                'customer' => $person->stripeId(),
                'auto_advance' => false,
                'collection_method' => 'send_invoice',
                'days_until_due' => 7
            ]);

            return $invoice;
        }
        catch(InvalidRequestException $exception)
        {
            $search = strpos($exception->getMessage(), 'No such customer');
            if($search !== false)
            {
                $person = $this->refreshStripeCustomer($person);
                return $this->createInvoice($person, $price);
            }
        }
    }

    public function finalizeInvoice($invoice)
    {
        return $this->stripe->invoices->finalizeInvoice($invoice->id, []);
    }

    private function checkStripeCustomer(Person $person){
        if(!$person->hasStripeId()){
            $person->createAsStripeCustomer();
            $person->refresh();
        }

        return $person;
    }

    private function refreshStripeCustomer(Person $person){
        if($person->hasStripeId())
        {
            $person->stripe_id = null;
            $person->save();
        }

        $person->createAsStripeCustomer();
        $person->refresh();
        return $person;
    }

}
