<?php

namespace App\Enums\Order;

use BenSampo\Enum\Enum;

final class OrderItemType extends Enum
{
    const MeetingWithHost 	= 1;
    const BookAndMeet 		= 2;
    const AccessInformation = 3;
}
