<?php

namespace App\Enums\Payment;

use BenSampo\Enum\Enum;

final class TradeTerms extends Enum
{
    const Free_On_Board = 1;
    const Cost_Insurance_And_Freight = 2;
    const Cost_And_Freight = 3;
    const Other = 4;
}