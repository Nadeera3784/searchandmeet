<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\MeetingRequest\MeetingRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\MeetingRequest;
use App\Models\Person;
use App\Repositories\MeetingRequest\MeetingRequestRepositoryInterface;
use Illuminate\Http\Request;

class MeetingRequestController extends Controller
{
    private $meetingRequestRepository;
    public function __construct(MeetingRequestRepositoryInterface $meetingRequestRepository)
    {
        $this->meetingRequestRepository = $meetingRequestRepository;
    }

    public function index(Request $request)
    {
        $role = auth('agent')->user()->role->value;
        $auth_id = auth('agent')->user()->id;
        $people = Person::select(\DB::raw("CONCAT(name, ' (', email, ')') AS name"), 'id');
        $meeting_requests = MeetingRequest::with('purchase_requirement')->with('custom_timeslot')->with('person');

        if($role === AgentRoles::agent)
        {
            $people = $people->where('agent_id', $auth_id);
            $meeting_requests = $meeting_requests->whereHas('purchase_requirement.person', function($query) use($auth_id){
                $query->where('agent_id', $auth_id);
            });
        }

        if($request->has('person'))
        {
            $meeting_requests = $meeting_requests->where('person_id', $request->get('person'));
        }

        if($request->has('status'))
        {
            switch($request->get('status'))
            {
                case 'processed':
                    $meeting_requests = $meeting_requests->where('status',MeetingRequestStatus::Processed);
                break;
                case 'processing':
                    $meeting_requests = $meeting_requests->where('status', MeetingRequestStatus::Processing);
                break;
            }
        }

        $people = $people->pluck('name', 'id');
        $meeting_requests = $meeting_requests->paginate(10);
        return view('agent.meeting_requests.index', get_defined_vars());
    }

    public function show(Request $request, $meeting_request)
    {
        return view('agent.meeting_requests.show', get_defined_vars());
    }

    public function update_status(Request $request, $meeting_request)
    {
        $this->meetingRequestRepository->update([
            'status' => MeetingRequestStatus::Processed
        ], $meeting_request);

        return view('agent.meeting_requests.show', get_defined_vars());
    }
}
