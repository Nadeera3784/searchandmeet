<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\MeetingResource;
use App\Models\Meeting;
use App\Models\PurchaseRequirement;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use App\Repositories\Person\PersonRepositoryInterface;
use Illuminate\Http\Request;

class MeetingController extends ApiController
{
    private $meetingRepository;
    public function __construct(MeetingRepositoryInterface $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function getLinks(Request $request, $meeting, PersonRepositoryInterface $personRepository){
        $buyer = $meeting->orderItem->purchase_requirement->person;
        $supplier = $meeting->orderItem->order->person;

        $buyerLink = $personRepository->getDirectLoginLink($buyer->id, route('person.meeting.waiting_room', ['meeting' =>$meeting->getRouteKey()]));
        $supplierLink = $personRepository->getDirectLoginLink($supplier->id, route('person.meeting.waiting_room', ['meeting' =>$meeting->getRouteKey()]));

        return response()->json(['buyer' => $buyerLink, 'supplier' => $supplierLink], 200);
    }
}
