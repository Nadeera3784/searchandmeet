<?php

namespace App\Services\Schedule;

interface ScheduleServiceInterface
{
    public function addDefaultSchedule($person);

    public function getScheduleByPerson($person_id);

    public function getTimeSlotsByDay($person, $date);

    public function checkAvailabilityByRange($person, $date, $range = 'month' || 'week');

    public function updateAvailabilityIndex();

    public function getNextAvailableTimeSlot($person);

}