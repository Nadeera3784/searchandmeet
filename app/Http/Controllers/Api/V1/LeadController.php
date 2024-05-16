<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ProspectType;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Lead\CreateLeadRequest;
use App\Models\Category;
use App\Models\Country;
use App\Repositories\Lead\LeadRepositoryInterface;
use App\Services\Events\EventTrackingService;
use Illuminate\Support\Facades\Session;

class LeadController extends ApiController
{
    private $leadRepository;
    public function __construct(LeadRepositoryInterface $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function create(CreateLeadRequest $request, EventTrackingService $userEventsService)
    {
        $userEventsService->track('Search Page Popup', [
            'name' =>$request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'phone_code' => $request->phone_code,
            'website' => $request->website,
            'country_id' => Country::find($request->country_id)->name,
            'looking_for' => ProspectType::getDescription($request->looking_for),
            'category_id' => Category::find($request->category_id)->name,
            'business_name' => $request->business_name,
            'business_description' => $request->business_description,
            'sessionId' => Session::getId()
        ]);

        $userEventsService->identify([
            "email" => $request->email,
            "name" => $request->name,
            "phone"=> $request->phone_code . ' ' . $request->phone,
            "lookingToMeet" => ProspectType::getDescription($request->looking_for),
        ]);

        $this->leadRepository->create($request->validated());
        $this->sendResponse('success', null, 200);
    }
}
