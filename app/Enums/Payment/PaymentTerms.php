<?php

namespace App\Enums\Payment;

use BenSampo\Enum\Enum;

final class PaymentTerms extends Enum
{
    const Secure_Escrow = 1;
    const Letter_Of_Credit = 2;
    const Open_Account = 3;
    const Cash_On_Delivery = 4;
    const Cash_Before_Shipment = 5;
    const Payment_In_Advance = 6;
    const Stage_Payment = 7;
    const Open_To_Negotiate = 7;
    const Other = 7;
}