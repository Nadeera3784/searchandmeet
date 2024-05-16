<?php

namespace App\Services\Schedule;

use App\Models\Person;
use App\Models\Schedule;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class ScheduleService implements ScheduleServiceInterface
{
    private $DURATION = null;
    private $scheduleRepository;

    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->DURATION = config('meeting.default_duration');
        $this->scheduleRepository = $scheduleRepository;
    }

    public function addDefaultSchedule($person)
    {
        $default_availability = ["from" => "09:00", "to" => "17:00"];

        $day_availability = [
            ["id" => 0, "name" => "monday", "availability" => [], "active" => true],
            ["id" => 1, "name" => "tuesday", "availability" => [], "active" => true],
            ["id" => 2, "name" => "wednesday", "availability" => [], "active" => true],
            ["id" => 3, "name" => "thursday", "availability" => [], "active" => true],
            ["id" => 4, "name" => "friday", "availability" => [], "active" => true],
            ["id" => 5, "name" => "saturday", "availability" => [], "active" => false],
            ["id" => 6, "name" => "sunday", "availability" => [], "active" => false],

        ];

        $data = [
            'default_availability' => json_encode($default_availability),
            'day_availability' => json_encode($day_availability),
            'custom_availability' => json_encode([])
        ];

        $schedule = $this->scheduleRepository->create($data, $person);
        return $schedule;
    }

    public function getScheduleByPerson($person_id)
    {
        return Schedule::where('person_id', $person_id)->first();
    }

    public function getTimeSlotsByDay($person, $date)
    {
        $time_slots = collect([]);
        $schedule = $person->schedule;
        $day_found = false;
        $date = Carbon::parse($date);
        $timezone = $person->timezone->name;

        if($date->isPast())
        {
            return [
                'time_zone' => $timezone,
                'time_slots' => $time_slots
            ];
        }

        $custom_availability = json_decode($schedule->custom_availability);

        if (!empty($custom_availability) and count($custom_availability) > 0) {
            foreach ($custom_availability as $customDay) {
                if (!empty($customDay)) {
                    if (Carbon::parse($customDay->date) == $date) {
                        $from = $this->combineDateTime($date, $customDay->from);
                        $to = $this->combineDateTime($date, $customDay->to);
                        $time_slots = $time_slots->merge($this->getTimeSlots($from, $to));
                        $day_found = true;
                    }
                }
            }
        }

        if (!$day_found) {
            //day
            $day_availability = json_decode($schedule->day_availability);
            $dayName = strtolower($date->format('l'));

            $day = $this->getDay($dayName, $day_availability);

            if ($day) {

                if ($day->active) {
                    $slots = $day->availability;
                    foreach ($slots as $slot) {
                        if ($slot and is_object($slot)) {
                            $from = $this->combineDateTime($date, $slot->from);
                            $to = $this->combineDateTime($date, $slot->to);
                            $time_slots = $time_slots->merge($this->getTimeSlots($from, $to));
                            $day_found = true;
                        }
                    }
                } else {
                    $day_found = true;
                }
            }
        }

        if (!$day_found) {
            //default
            $default_availability = json_decode($schedule->default_availability);

            $from = $this->combineDateTime($date, $default_availability->from);
            $to = $this->combineDateTime($date, $default_availability->to);

            $time_slots = $time_slots->merge($this->getTimeSlots($from, $to));
        }

        $time_slots = $this->applyTimezone($timezone, $time_slots);

        $time_slots = $this->filterExistingBookings($person, $time_slots);

        return [
            'time_zone' => $timezone,
            'time_slots' => $time_slots
        ];
    }

    public function excludeDayTimes($from, $to, $timeslots)
    {
        $timeslots = collect($timeslots);
        $timeslots = $timeslots->filter(function($timeslot) use ($from, $to){
            $start = Carbon::parse($timeslot)->format('H:i');
            $end = Carbon::parse($timeslot)->addMinutes($this->DURATION)->format('H:i');

            if($end < $from && $start > $to)
            {
                return true;
            }

            return false;

        })->toArray();

        return $timeslots;
    }

    public function checkAvailabilityByRange($person, $date, $range = 'month' || 'week' || 'day')
    {
        $days = [];
        $date = Carbon::parse($date);

        $from = clone $date;
        $to = null;
        switch ($range) {
            case "day":
                $to = $date->addDay();
                break;
            case "month":
                $to = $date->addMonth();
                break;
            case "week":
                $to = $date->addWeek();
                break;
        }

        $periods = new CarbonPeriod($from, '1 day', $to);

        foreach ($periods as $day) {
            $day_string = $day->format('Y-m-d');
            $day_availability = $this->getTimeSlotsByDay($person, $day);
            $days[$day_string] = $day_availability['time_slots']->count() > 0;
        }

        return $days;
    }

    public function updateAvailabilityIndex()
    {
        $people = Person::all();
        foreach ($people as $person) {
            $checks = $this->checkAvailabilityByRange($person, Carbon::today(), 'day');
            $today = $this->checkIfAvailable($checks);

            $checks = $this->checkAvailabilityByRange($person, Carbon::tomorrow(), 'day');
            $tomorrow = $this->checkIfAvailable($checks);

            $checks = $this->checkAvailabilityByRange($person, Carbon::today(), 'week');
            $this_week = $this->checkIfAvailable($checks);

            $checks = $this->checkAvailabilityByRange($person, Carbon::today(), 'month');
            $this_month = $this->checkIfAvailable($checks);

            $checks = $this->checkAvailabilityByRange($person, Carbon::today()->addMonth(), 'month');
            $next_month = $this->checkIfAvailable($checks);

            DB::table('people_availabilities')->upsert([
                ['person_id' => $person->id, 'today' => $today, 'tomorrow' => $tomorrow, 'this_week' => $this_week, 'this_month' => $this_month, 'next_month' => $next_month],
            ], ['person_id'], ['today', 'tomorrow', 'this_week', 'this_month', 'next_month']);
        }
    }

    public function getNextAvailableTimeSlot($person)
    {
        $schedule = $this->checkAvailabilityByRange($person, Carbon::now(), 'month');
        $nextAvailableDate = null;
        $nextAvailableTimeSlot = null;
        foreach ($schedule as $day => $check)
        {
            if($check)
            {
                $nextAvailableDate = $day;
                break;
            }
        }

        $timeSlots = $this->getTimeSlotsByDay($person, $nextAvailableDate);
        if($timeSlots['time_slots']->count() > 0)
        {
            $nextAvailableTimeSlot = $timeSlots['time_slots'][0];
        }

        return $nextAvailableTimeSlot;
    }

    private function checkIfAvailable($periods)
    {
        foreach ($periods as $key => $value) {
            if ($value) {
                return true;
            }
        }

        return false;
    }

    private function filterExistingBookings($person, $timeSlots)
    {
        foreach ($person->purchase_requirements as $pr) {
            foreach ($pr->orderItems as $order_item) {
                $meeting_time_slot = $order_item->timeSlot;
                $start = $meeting_time_slot->start;
                $end = $meeting_time_slot->end;
                $duration = $this->DURATION;

                $timeSlots = $timeSlots->filter(function ($timeSlot) use ($start, $end, $duration) {

                    if(Carbon::parse($start)->isSameDay(Carbon::parse($timeSlot)))
                    {
                        $timeSlotStart = Carbon::parse($timeSlot)->format('H:i');
                        $timeSlotEnd = Carbon::parse($timeSlot)->addMinutes($duration)->format('H:i');

                        $compareStart = Carbon::parse($start)->format('H:i');
                        $compareEnd = Carbon::parse($end)->format('H:i');

                        if (($timeSlotStart < $compareEnd) && ($compareStart < $timeSlotEnd)) {
                            return false;
                        }
                    }
                    return true;

                })->values();
            }
        }

        return $timeSlots;
    }

    private function getDay($dayName, $day_availability)
    {
        $day = null;
        if (!empty($day_availability)) {
            foreach ($day_availability as $item) {
                if ($item->name == $dayName) {
                    $day = $item;
                    break;
                }
            }
        }
        return $day;
    }

    private function getTimeSlots($from, $to)
    {
        $periods = new CarbonPeriod($from, "$this->DURATION minutes", $to);
        $slots = collect([]);
        foreach ($periods as $period) {
            $slots->push(Carbon::parse($period)->format('Y-m-d H:i:s'));
        }

        return $slots;
    }

    private function combineDateTime($date, $time)
    {
        return str_replace('00:00:00', $time, $date);
    }

    private function applyTimezone($timezone, $timeSlots)
    {
        $timeSlots = $timeSlots->map(function ($item) use ($timezone) {
            return Carbon::parse($item, $timezone)->setTimezone('UTC')->format('Y-m-d H:i');
        });
        return $timeSlots;
    }
}
