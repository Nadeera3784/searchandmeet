<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\Schedule\UpdateScheduleRequest;
use App\Models\Category;
use App\Models\Country;
use App\Models\PurchaseRequirement;
use App\Models\Schedule;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Services\Schedule\ScheduleService;
use Faker\Factory;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private $scheduleRepository;
    public function __construct(ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->scheduleRepository  = $scheduleRepository;
    }

    public function show()
    {
        return view('schedule.show', get_defined_vars());
    }

    public function update(UpdateScheduleRequest $request)
    {
        try
        {
            $data = $request->validated();
            $data['default_availability'] = json_encode($data['default_availability']);
            $data['day_availability'] = json_encode($data['day_availability']);
            $data['custom_availability'] = json_encode($data['custom_availability']);

            $this->scheduleRepository->update($data, auth('person')->user());
            return response()->json(['message' => 'success'], 200);
        }
        catch(\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
