<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentSourceStatus extends Enum
{
    const Created = 0;
    const Chargeable = 1;
    const Cancelled = 2;
    const Failed = 3;
}