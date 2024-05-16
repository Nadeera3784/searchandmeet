<?php

namespace App\Repositories\Schedule;

use Carbon\Carbon;

class ScheduleEloquentRepository implements ScheduleRepositoryInterface
{
    public function getByPerson($person)
    {
        return $person->schedule;
    }

    public function create($data, $person)
    {
        return $person->schedule()->create($data);
    }

    public function update($data, $person)
    {
        $primary_custom_availability = json_decode($data['custom_availability']);
        $secondary_custom_availability = json_decode($data['custom_availability']);

        foreach ($primary_custom_availability as $override)
        {
            foreach ($secondary_custom_availability as $existing_override)
            {
                if($existing_override->id !== $override->id)
                {
                    if(Carbon::parse($override->date)->isSameDay(Carbon::parse($existing_override->date)))
                    {
                        $timeSlotStart = Carbon::parse($existing_override->from)->format('H:i');
                        $timeSlotEnd = Carbon::parse($existing_override->to)->format('H:i');

                        $compareStart = Carbon::parse($override->from)->format('H:i');
                        $compareEnd = Carbon::parse($override->to)->format('H:i');

                        if (($timeSlotStart < $compareEnd) && ($compareStart < $timeSlotEnd)) {
                            throw new \Exception('overlapping time slot provided');
                        }
                    }
                }
            }
        }

        return $person->schedule()->update($data);
    }
}