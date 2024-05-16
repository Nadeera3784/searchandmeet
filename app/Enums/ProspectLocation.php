<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ProspectLocation extends Enum
{
    const Africa = 1;
    const Asia = 2;
    const Central_America = 3;
    const Eastern_Europe = 4;
    const European_Union = 5;
    const Middle_East = 6;
    const North_America = 7;
    const Oceania = 8;
    const South_America = 9;
}