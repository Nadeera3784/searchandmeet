<?php


namespace App\Repositories\Schedule;

interface ScheduleRepositoryInterface
{
    public function getByPerson($person);

    public function create($data, $person);

    public function update($data, $person);
}