<?php

namespace App\Enums\Business;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AnnualRevenueBracket extends Enum
{
    const ZeroToHundredThousand = 1;
    const HundredThousandToFiveHundredThousand = 2;
    const FiveHundredThousandToFiveMillion = 3;
    const FiveMillionToTenMillion = 4;
    const TenMillionToTwentyMillion = 5;
    const TwentyMillionToFiftyMillion = 6;
    const FiftyMillionAndAbove = 7;
}