<?php

namespace App\Enums\Package;

use BenSampo\Enum\Enum;

final class PackageStatus extends Enum
{
    const Awaiting_Payment = 0;
    const Active = 1;
}