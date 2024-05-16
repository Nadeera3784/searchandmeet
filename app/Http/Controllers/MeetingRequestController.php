<?php

namespace App\Http\Controllers;

use App\Http\Requests\Web\MeetingRequest\CreateMeetingRequestRequest;
use App\Notifications\MeetingRequestSubmitted;
use App\Repositories\MeetingRequest\MeetingRequestRepositoryInterface;

class MeetingRequestController extends Controller
{
    public function  __construct()
    {
        $this->middleware('auth.person');
    }

    public function create(CreateMeetingRequestRequest $request, MeetingRequestRepositoryInterface $meetingRequestRepository, $purchase_requirement)
    {
        try {
            $meeting_request = $meetingRequestRepository->create($request->validated(), $purchase_requirement, auth('person')->user());
            if ($meeting_request) {

                auth('person')->user()->notify(new MeetingRequestSubmitted($meeting_request));
                return response(['message' => 'success'], 200);
            }
        }
        catch (\Exception $exception)
        {
            return response(['message'=> 'failed','error' => $exception->getMessage()], 400);
        }
    }
}
