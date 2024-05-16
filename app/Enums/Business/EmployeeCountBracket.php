<?php

namespace App\Enums\Business;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class EmployeeCountBracket extends Enum
{
    const OneToFive = 1;
    const FiveToTen = 2;
    const TenToFifty = 3;
    const FiftyToHundred = 4;
    const HundredToTwoHundred = 5;
    const TwoHundredAndAbove = 6;
}