<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PurchasePolicy extends Enum
{
    const On_Price = 1;
    const On_Quality = 2;
    const Delivery_Time = 3;
    const Preferred_Country = 4;
    const Certification = 5;
    const After_Service = 6;
    const Warranty = 7;
}