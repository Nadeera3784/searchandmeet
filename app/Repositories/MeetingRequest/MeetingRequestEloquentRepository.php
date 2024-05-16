<?php

namespace App\Repositories\MeetingRequest;

use App\Models\MeetingRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MeetingRequestEloquentRepository implements MeetingRequestRepositoryInterface
{
    public function __construct()
    {

    }

    public function getAll()
    {
        return MeetingRequest::orderBy('id', 'desc')->get();
    }

    public function getByPurchaseRequirement($purchase_requirement)
    {
        return $purchase_requirement->meeting_requests;
    }

    public function create($data, $purchase_requirement, $person)
    {
        if(!$person)
        {
            throw new \Exception('No user available');
        }

        $meeting_request = MeetingRequest::create([
                'message' => $data['message'],
                'day_availability' => $data['day_availability'],
                'default_availability' => $data['default_availability'],
                'recommend_similar_products' => $data['recommend_similar_products'],
                'purchase_requirement_id' => $purchase_requirement->id,
                'person_id' => $person->id
            ]);

        if(isset($data['custom_timeslot']) && isset($data['custom_timeslot']['date']) && isset($data['custom_timeslot']['start']) && isset($data['custom_timeslot']['start']))
        {
            $start = Carbon::parse($data['custom_timeslot']['date'].' '.$data['custom_timeslot']['start'], $person->timeZone->name)->utc();
            $end = Carbon::parse($data['custom_timeslot']['date'].' '.$data['custom_timeslot']['end'], $person->timeZone->name)->utc();

            $meeting_request->custom_timeslot()->create([
                'start' => $start,
                'end' => $end
            ]);
        }

        return $meeting_request;
    }

    public function update($data, $meeting_request)
    {
        return $meeting_request->update($data);
    }
}