<?php

namespace App\Enums\Agent;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AgentRoles extends Enum
{
    const admin = 1;
    const agent = 2;
    const translator = 3;
    const support = 4;
}
