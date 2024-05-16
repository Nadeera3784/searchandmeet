<?php

namespace App\Enums\Meeting;

use BenSampo\Enum\Enum;

final class MeetingStatus extends Enum
{
    const Draft = 0;
    const Scheduled = 1;
    const Requires_Participant = 2;
    const Expired = 3;
    const Rejected = 4;
    const Reschedule = 5;
    const Cancelled = 6;
}