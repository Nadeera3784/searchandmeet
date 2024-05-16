<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Availability\GetAvailableTimeslotsRequest;
use App\Repositories\PurchaseRequirement\PurchaseRequirementRepositoryInterface;
use App\Repositories\Schedule\ScheduleRepositoryInterface;
use App\Services\Schedule\ScheduleServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

class AvailabilityController extends ApiController
{
    private $scheduleService;
    private $purchaseRequirementRepository;
    private $scheduleRepository;

    public function __construct(ScheduleServiceInterface $scheduleService,ScheduleRepositoryInterface $scheduleRepository, PurchaseRequirementRepositoryInterface $purchaseRequirementRepository)
    {
        $this->scheduleService = $scheduleService;
        $this->purchaseRequirementRepository = $purchaseRequirementRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function getTimeSlotsByDay(GetAvailableTimeslotsRequest $request)
    {
        $id = Hashids::connection(\App\Models\PurchaseRequirement::class)->decode($request->purchase_requirement_id)[0] ?? null;
        $pr = $this->purchaseRequirementRepository->getById($id);
        $timeSlots = $this->scheduleService->getTimeSlotsByDay($pr->person, $request->date);
        return response()->json($timeSlots, 200);
    }

    public function checkAvailabilityForMonth(Request $request)
    {
        $id = Hashids::connection(\App\Models\PurchaseRequirement::class)->decode($request->purchase_requirement_id)[0] ?? null;
        $pr = $this->purchaseRequirementRepository->getById($id);
        $days = $this->scheduleService->checkAvailabilityByRange($pr->person, $request->date, 'month');
        return response()->json($days, 200);
    }

    public function addDateOverride(Request $request, $person)
    {
        try
        {
            $schedule = $this->scheduleRepository->getByPerson($person);
            $custom_availability = json_decode($schedule->custom_availability);

            $date = Carbon::parse($request->start)->format('Y-m-d');
            $start = Carbon::parse($request->start)->format('H:i');
            $end = Carbon::parse($request->end)->format('H:i');

            array_push($custom_availability, [
                'id' => Str::uuid()->toString(),
                'date' => $date,
                'from' => $start,
                'to' => $end,
            ]);

            $this->scheduleRepository->update([
                'custom_availability' => json_encode($custom_availability)
            ], $person);

            return response()->json(['message' => 'success'], 200);
        }
        catch(\Exception $exception)
        {
            return response()->json(['message' => $exception->getMessage()], 400);
        }
    }
}
