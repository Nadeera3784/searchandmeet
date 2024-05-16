<?php

namespace App\Enums\Business;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CompanyType extends Enum
{
    const Private_Company = 1;
    const Public_Company  = 2;
    const Limited_Partnership = 3;
    const General_Partnership = 4;
    const Chartered_Company = 5;
    const Statutory_Corporation = 6;
    const State_Owned_Enterprise = 7;
    const Holding_Company = 8;
    const Subsidiary_Company = 9;
    const Sole_Proprietorship = 10;
}