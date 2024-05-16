<?php

namespace App\Http\Controllers\Agent;

use App\Enums\Agent\AgentRoles;
use App\Enums\Order\OrderStatus;
use App\Enums\Person\AccountStatus;
use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\OrderItem;
use App\Models\Person;
use App\Models\PurchaseRequirement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $auth_id = auth('agent')->user()->id;
        $role = auth('agent')->user()->role->value;
        $userType = null;
        if($role === AgentRoles::agent)
        {
            $userType = 'agent_id';
        }
        elseif($role === AgentRoles::translator)
        {
            $userType = 'translator_id';
        }

        //--OrdersStart
        $items = OrderItem::with('meeting')->with('order');
        if($role === AgentRoles::agent || $role === AgentRoles::translator) {
            $items = $items->whereHas('meeting', function ($q) use ($auth_id, $userType) {
                $q->where($userType, $auth_id);
            });
        }
        $total_orders = $items->orderBy('id', 'desc')->get();
        $completed_orders = $items->whereHas('order',function($q) {
            $q->where('status', OrderStatus::Completed);
        } );
        //--OrdersEnd

        //--MeetingsStart
        if($role === AgentRoles::admin || $role === AgentRoles::support) {
            $meetings = Meeting::all();
            $upcomingMeetings = Meeting::whereHas('orderItem.timeslot', function($q) {
                $q->where('start', '>', Carbon::now());
            })->paginate(10, ["*"], 'um');
        }
        else
        {
            $meetings = Meeting::where($userType, auth('agent')->user()->id)->get();
            $upcomingMeetings = Meeting::where($userType, auth('agent')->user()->id)->whereHas('orderItem.timeslot', function($q) {
                $q->where('start', '>', Carbon::now());
            })->paginate(10, ["*"], 'um');
        }
        //--MeetingsEnd

        //--AccountsStart
        $onBoardingAccounts = Person::where('status', AccountStatus::OnBoarding)->get();
        if($role === AgentRoles::admin || $role === AgentRoles::support) {
            $suspendedAccounts = Person::where('status', AccountStatus::Suspended)->get();
//            $verifiedBuyersWithNoMeetings = Person::has('purchase_requirements')->whereDoesntHave('orders.items', function ($query) {
//                $query->where('type', '!=',3);
//            })->where('status', AccountStatus::Verified)->paginate(10, ["*"], 'vb_no_m');
        }
        else
        {
            $suspendedAccounts = Person::where('agent_id', auth('agent')->user()->id)->where('status', AccountStatus::Suspended)->get();
//            $verifiedBuyersWithNoMeetings = Person::has('purchase_requirements')->whereDoesntHave('orders.items', function ($query) {
//                $query->where('type', '!=',3);
//            })->where('status', AccountStatus::Verified)->where('agent_id', auth('agent')->user()->id)->paginate(10, ["*"], 'vb_no_m');
        }
        //--AccountsEnd

        //--PRStart
//        if($role === AgentRoles::admin || $role === AgentRoles::support) {
//            $purchaseRequirements = PurchaseRequirement::all();
//        }
//        else {
//            $purchaseRequirements = PurchaseRequirement::whereHas('person', function ($q) use ($auth_id) {
//                $q->where('agent_id', $auth_id);
//            })->get();
//        }
//
//        $purchaseRequirementsWithNoTimeSlots = [];
//        foreach ($purchaseRequirements as $purchaseRequirement)
//        {
//            if($purchaseRequirement->available_timeslots()->count() === 0)
//            {
//                array_push($purchaseRequirementsWithNoTimeSlots, $purchaseRequirement);
//            }
//        }
//        $page = $request->pr_no_t ?? 1;
//        $perPage = 15;
//        $offset = ($page - 1) * $perPage;
//        $items = array_slice($purchaseRequirementsWithNoTimeSlots, $offset, 10);
//        $purchaseRequirementsWithNoTimeSlots = new LengthAwarePaginator($items, count($purchaseRequirementsWithNoTimeSlots), $perPage, $request->pr_no_t);
//        $purchaseRequirementsWithNoTimeSlots->withPath($request->url());
//        $purchaseRequirementsWithNoTimeSlots->setPageName('pr_no_t');
        //--PREnd

        return view('agent.dashboard.index',get_defined_vars());
    }
}
