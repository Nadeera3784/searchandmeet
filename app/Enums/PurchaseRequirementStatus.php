<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PurchaseRequirementStatus extends Enum
{
    const Unpublished = 0;
    const Published = 1;
}