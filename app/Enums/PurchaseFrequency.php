<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PurchaseFrequency extends Enum
{
    const One_Off = 1;
    const Monthly = 2;
    const Quarterly = 3;
    const Regular = 4;
}