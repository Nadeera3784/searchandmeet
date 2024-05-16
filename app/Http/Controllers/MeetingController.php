<?php

namespace App\Http\Controllers;

use App\Enums\Order\OrderStatus;
use App\Events\UserJoinedWaitingRoom;
use App\Http\Requests\Web\Meeting\JoinMeetingRequest;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use App\Services\Agora\RtmTokenBuilder;
use App\Services\VideoCommService\VideoCommProviderInterface;
use Carbon\Carbon;

class MeetingController extends Controller
{
    private $meetingRepository;
    public function __construct(MeetingRepositoryInterface $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function index()
    {
        $meetings = $this->meetingRepository->getAll(auth('person')->user(), true);
        return view('meetings.index',get_defined_vars());
    }

    public function room($meeting)
    {
        if($meeting->timeSlot->start <= Carbon::now() && $meeting->orderItem->order->status === OrderStatus::Pending && $meeting->alert_count === 0)
        {
            UserJoinedWaitingRoom::dispatch($meeting, auth('person')->user());
            $meeting->update(['alert_count' => 1]);
        }

        return view('meetings.room',get_defined_vars());
    }

    public function join(JoinMeetingRequest $request, $meeting, VideoCommProviderInterface $videoCommProvider)
    {
        $videoCommProvider->setUser(auth('person')->user());
        $link  = $videoCommProvider->getChannelParticipantJoinLink('meeting', $meeting->service_id);
        $videoCommProvider->logout();
        return response()->json(['link' => $link], 200);
    }

    public function show($meeting)
    {
        return view('meetings.show',get_defined_vars());
    }
    
    public function init_waiting_room($meeting)
    {
        $uid = $meeting->userAlias(auth('person')->user());
        $channel = $meeting->getRouteKey();
        $token = RtmTokenBuilder::buildToken(config('services.agora.app_id'), config('services.agora.app_certificate'), $uid, 86400);
        $capacity = $meeting->agent_id ? 3 : 2;
        $shouldCheckout = $meeting->orderItem->order->person == auth('person')->user() && $meeting->orderItem->order->status !== OrderStatus::Completed;

        return response()->json(['appId' => config('services.agora.app_id'), 'token' => $token, 'uid' => $uid, 'channel' => $channel, 'capacity' => $capacity, 'shouldCheckout' => $shouldCheckout], 200);
    }

    public function alert($meeting)
    {
        if($meeting->alert_count < 2)
        {
            UserJoinedWaitingRoom::dispatch($meeting, auth('person')->user());
            $meeting->update(['alert_count' => $meeting->alert_count + 1]);
            return response()->json(['message' => 'success'], 200);
        }
        else
        {
            return response()->json(['message' => 'failed', 'reason' => 'Alert count reached'], 400);
        }
    }
}
