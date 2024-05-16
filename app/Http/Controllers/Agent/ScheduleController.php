<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\Schedule\UpdateScheduleRequest;
use App\Repositories\Schedule\ScheduleRepositoryInterface;

class ScheduleController extends Controller
{
    private $scheduleRepository;
    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository  = $scheduleRepository;
    }

    public function show($person)
    {
        return view('agent.schedule.show', get_defined_vars());
    }

    public function update(UpdateScheduleRequest $request, $person)
    {
        $data = $request->validated();
        $data['default_availability'] = json_encode($data['default_availability']);
        $data['day_availability'] = json_encode($data['day_availability']);
        $data['custom_availability'] = json_encode($data['custom_availability']);

        $this->scheduleRepository->update($data, $person);
        return response()->json(['message' => 'success'], 200);
    }
}
