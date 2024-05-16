<?php

namespace App\Enums\Payment;

use BenSampo\Enum\Enum;

/**
 * @method static static Stripe()
 * @method static static Paypal()
 */
final class PaymentProvider extends Enum
{
    const Stripe =   1;
    const Paypal =   2;
}
