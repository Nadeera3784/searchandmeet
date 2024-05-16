<?php

namespace App\Enums\MeetingRequest;

use BenSampo\Enum\Enum;

/**
 * @method static static Stripe()
 * @method static static Paypal()
 */
final class MeetingRequestStatus extends Enum
{
    const Processing =   0;
    const Processed =   1;
}
