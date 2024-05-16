<?php

namespace App\Enums\Person;

use BenSampo\Enum\Enum;

final class AccountStatus extends Enum
{
    const OnBoarding = 0;
    const Unverified = 1;
    const Verified = 2;
    const Suspended = 3;

}