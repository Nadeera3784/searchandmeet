<?php

namespace App\Enums\Order;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderStatus extends Enum
{
    const Draft = 0;
    const Completed = 1;
    const Pending = 2;
    const Cancelled = 3;
}
