<?php

namespace App\Enums\Person;

use BenSampo\Enum\Enum;

final class AccountSourceTypes extends Enum{

    const Api   = "api";
    const Web   = "web";
    const Agent = "agent";
    const Zoho = "zoho";
}