<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\Meeting\MeetingStatus;
use App\Enums\Order\OrderItemType;
use App\Enums\Order\OrderStatus;
use App\Events\UserJoinedWaitingRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\Order\MakeClaimRequest;
use App\Models\Meeting;
use App\Repositories\Meeting\MeetingRepositoryInterface;
use App\Services\Agora\RtmTokenBuilder;
use App\Services\Order\OrderServiceInterface;
use App\Services\VideoCommService\VideoCommProviderInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $meetings = Meeting::with('orderItem');
        $role = auth('agent')->user()->role->value;

        if($request->get('intent') === 'claims')
        {
            if(auth('agent')->user()->role->value === AgentRoles::agent)
            {
                $meetings = $meetings->whereHas('orderItem', function($query){
                    $query->where('type', OrderItemType::MeetingWithHost);
                })->where('agent_id', null);

            }
            else if(auth('agent')->user()->role->value === AgentRoles::translator)
            {
                $meetings = $meetings->whereHas('orderItem', function($query){
                    $query->where('required_translator', '!=', false);
                })->where('translator_id', null);
            }
        }
        else if($role === AgentRoles::agent)
        {
            $meetings = $meetings->where(function($q){
                $q->where('agent_id', auth('agent')->user()->id);
                $q->orWhereHas('orderItem', function ($q) {
                    $q->whereHas('order', function ($q) {
                        $q->whereHas('person', function ($q) {
                            $q->where('agent_id', auth('agent')->user()->id);
                        });
                    });
                });

                $q->orWhereHas('orderItem', function ($q) {
                    $q->whereHas('purchase_requirement', function ($q) {
                        $q->whereHas('person', function ($q) {
                            $q->where('agent_id', auth('agent')->user()->id);
                        });
                    });
                });
            });

        }
        else if($role === AgentRoles::translator)
        {
            $meetings = $meetings->where('translator_id', auth('agent')->user()->id);
        }
        else if ($role === AgentRoles::admin || $role === AgentRoles::support)
        {

        }

        if($request->has('date'))
        {
            $date = $request->get('date');
            $meetings = $meetings->whereHas('orderItem', function ($q) use ($date) {
                $q->whereHas('timeSlot', function ($q) use ($date) {
                   $q->whereDate('start', $date);
                });
            });
        }

        if($request->has('status'))
        {
            switch ($request->get('status'))
            {
                case "requires_participants":
                    $meetings = $meetings->where('status', MeetingStatus::Requires_Participant);
                    break;
                case "completed":
                    $meetings = $meetings->where('status', MeetingStatus::Expired);
                    break;
                case "draft":
                    $meetings = $meetings->where('status', MeetingStatus::Draft);
                    break;
                case "active":
                    $meetings = $meetings->where('status', MeetingStatus::Scheduled);
                    break;
            }
        }

        if($request->has('participant_name'))
        {
            $query = $request->get('participant_name');

            $meetings = $meetings->filter(function($meeting) use ($query){
                foreach ($meeting->participants as $participant){
                    if(stristr($participant->name, $query)){
                        return true;
                    }
                }
                return false;

            });
        }

        $meetings = $meetings->paginate(15);
        return view('agent.meetings.index', get_defined_vars());
    }

    public function waiting_room($meeting)
    {
        if($meeting->timeSlot->start <= Carbon::now() && $meeting->orderItem->order->status === OrderStatus::Pending && $meeting->alert_count === 0)
        {
            UserJoinedWaitingRoom::dispatch($meeting, auth('agent')->user());
            $meeting->update(['alert_count' => 1]);
        }

        return view('agent.meetings.room',get_defined_vars());
    }

    public function init_waiting_room($meeting)
    {
        $uid = $meeting->userAlias(auth('agent')->user());
        $channel = $meeting->getRouteKey();
        $token = RtmTokenBuilder::buildToken(config('services.agora.app_id'), config('services.agora.app_certificate'), $uid, 86400);
        $capacity = $meeting->agent_id ? 3 : 2;
        $shouldCheckout = false;

        return response()->json(['appId' => config('services.agora.app_id'), 'token' => $token, 'uid' => $uid, 'channel' => $channel, 'capacity' => $capacity, 'shouldCheckout' => $shouldCheckout], 200);
    }

    public function join($meeting, VideoCommProviderInterface $videoCommProvider)
    {
        $videoCommProvider->setUser(auth('agent')->user());
        $link  = $videoCommProvider->getChannelParticipantJoinLink('meeting', $meeting->service_id);
        $videoCommProvider->logout();
        return response()->json(['link' => $link], 200);
    }

    public function claim(MakeClaimRequest $request, MeetingRepositoryInterface $meetingRepository)
    {
        $meeting = Meeting::find($request->validated()['meeting']);
        if($meeting)
        {
            $status = MeetingStatus::Scheduled;
            if(auth('agent')->user()->role->value === AgentRoles::agent)
            {
                if($meeting->orderItem->required_translator && $meeting->translator_id === null)
                {
                    $status = MeetingStatus::Requires_Participant;
                }

                $meetingRepository->update([
                    'agent_id' => auth('agent')->user()->id,
                    'status' => $status
                ], $meeting->id);
            }
            else if(auth('agent')->user()->role->value === AgentRoles::translator)
            {
                if(!$meeting->agent_id && $meeting->orderItem->type === OrderItemType::MeetingWithHost)
                {
                    $status = MeetingStatus::Requires_Participant;
                }

                $meetingRepository->update([
                    'translator_id' => auth('agent')->user()->id,
                    'status' => $status
                ], $meeting->id);
            }

            return redirect()->route('agent.meetings.index')->with('success','Meeting claimed successfully!');
        }
        else
        {
            return redirect()->route('agent.meetings.index', ['status' => 'claims'])->with('error','Meeting does not exist!');
        }
    }

    public function confirmMeeting($meeting)
    {
        $meeting->update(['is_confirmed' => true]);
        return redirect()->route('agent.meetings.index')->with('success','Meeting confirmed');
    }

    public function updateStatus(Request $request, OrderServiceInterface $orderService)
    {
        $status = $request->get('status');
        $meetingId = \Hashids::connection(Meeting::class)->decode($request->get('meeting_id'))[0] ?? null;
        $meeting = Meeting::find($meetingId);

        if (!$status) {
            return redirect()->back()->with('error', 'Please select a new status');
        }

        if ($meeting && ($meeting->orderItem->order->status !== OrderStatus::Cancelled && $meeting->orderItem->order->status !== OrderStatus::Completed)) {

            if ($status == MeetingStatus::Rejected) {
                $orderService->cancelOrder($meeting->orderItem->order, MeetingStatus::Rejected);

                return redirect()->route('agent.meetings.index')->with('success', 'Meeting updated successfully!');
            } else if ($status == MeetingStatus::Cancelled) {
                $orderService->cancelOrder($meeting->orderItem->order, MeetingStatus::Cancelled);

                return redirect()->route('agent.meetings.index')->with('success', 'Meeting updated successfully!');
            }
            else if ($status == MeetingStatus::Reschedule) {
                $orderService->cancelOrder($meeting->orderItem->order, MeetingStatus::Reschedule);

                return redirect()->route('agent.meetings.index')->with('success', 'Meeting updated successfully!');
            }

        }
        else {
            return redirect()->back()->with('error', 'Related order is already in a fixed state');
        }

        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function alert($meeting)
    {
        if($meeting->alert_count < 2)
        {
            UserJoinedWaitingRoom::dispatch($meeting);
            $meeting->update(['alert_count' => $meeting->alert_count++]);
            return response()->json(['message' => 'success'], 200);
        }
        else
        {
            return response()->json(['message' => 'failed', 'reason' => 'Alert count reached'], 400);
        }
    }
}

