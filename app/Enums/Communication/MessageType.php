<?php

namespace App\Enums\Communication;

use BenSampo\Enum\Enum;

final class MessageType extends Enum
{
    const Text = 0;
    const Person = 1;
    const Requirement = 2;
    const Order = 3;
}