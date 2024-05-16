<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\PreferredTime;
use App\Models\PricePercentage;
use Illuminate\Database\Seeder;

class PreferredTimesTableSeeder extends Seeder
{
    public function run()
    {
        $preferredTimes = array (
            0 => 'Monday - 7am-9am',
            1 => 'Monday - 9am-12pm',
            2 => 'Monday - 12pm-3pm',
            3 => 'Monday - 3pm-6pm',
            4 => 'Monday - 3pm-6pm',
            5 => 'Monday - 6pm-10pm',
            6 => 'Tuesday - 7am-9am',
            7 => 'Tuesday - 9am-12pm',
            8 => 'Tuesday - 12pm-3pm',
            9 => 'Tuesday - 3pm-6pm',
            10 => 'Tuesday - 3pm-6pm',
            11 => 'Tuesday - 6pm-10pm',
            12 => 'Wed - 7am-9am',
            13 => 'Wed - 9am-12pm',
            14 => 'Wed - 12pm-3pm',
            15 => 'Wed - 3pm-6pm',
            16 => 'Wed - 3pm-6pm',
            17 => 'Wed - 6pm-10pm',
            18 => 'Thu - 7am-9am',
            19 => 'Thu - 9am-12pm',
            20 => 'Thu - 12pm-3pm',
            21 => 'Thu - 3pm-6pm',
            22 => 'Thu - 3pm-6pm',
            23 => 'Thu - 6pm-10pm',
            24 => 'Friday - 7am-9am',
            25 => 'Friday - 9am-12pm',
            26 => 'Friday - 12pm-3pm',
            27 => 'Friday - 3pm-6pm',
            28 => 'Friday - 3pm-6pm',
            29 => 'Friday - 6pm-10pm',
            30 => 'Saturday - 7am-9am',
            31 => 'Saturday - 9am-12pm',
            32 => 'Saturday - 12pm-3pm',
            33 => 'Saturday - 3pm-6pm',
            34 => 'Saturday - 3pm-6pm',
            35 => 'Saturday - 6pm-10pm',
            36 => 'Sunday - 7am-9am',
            37 => 'Sunday - 9am-12pm',
            38 => 'Sunday - 12pm-3pm',
            39 => 'Sunday - 3pm-6pm',
            40 => 'Sunday - 3pm-6pm',
            41 => 'Sunday - 6pm-10pm',
            42 => 'All Weekdays - 9am-5pm',
            43 => 'All Weekend - 9am-5pm',
        );

        foreach ($preferredTimes as $preferredTime) {
            PreferredTime::create([
                'time' => $preferredTime
            ]);
        }
    }
}
