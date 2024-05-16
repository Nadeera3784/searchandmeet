@extends('layouts.admin')

@section('content')
    @inject('orderService',  'App\Services\Order\OrderServiceInterface')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    <div id="wrapper" class="max-w-full px-4  py-4 ">
        <div class="grid gap-y-5 gap-x-8 grid-cols-5">
            <h1 class="col-span-6 text-xl font-bold text-gray-500">
                {{ __('Dashboard') }}
            </h1>
            <a  href="{{route('agent.order.index')}}" class="cursor-pointer hover:bg-green-600 text-white col-span-6 sm:col-span-2 lg:col-span-1  flex flex-col justify-center px-4 py-4 bg-green-500 shadow-md rounded">
                <div>
                    <p class="text-3xl font-bold text-center ">{{$completed_orders->count()}}/{{$total_orders->count()}}</p>
                    <p class="text-lg text-center">Completed / Total orders</p>
                </div>
            </a>

            <a href="{{route('agent.meetings.index')}}" class="cursor-pointer hover:bg-blue-600 text-white col-span-6 sm:col-span-2 lg:col-span-1 flex flex-col justify-center px-4 py-4 bg-blue-500 shadow-md rounded">
                <div>
                    <p class="text-3xl font-bold text-center">{{$meetings->count()}}</p>
                    <p class="text-lg text-center">Meetings</p>
                </div>
            </a>
            @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
            <a href="{{route('agent.people.index', ['status' => 'onboarding'])}}" class="cursor-pointer hover:bg-purple-500 text-white col-span-6 sm:col-span-2 lg:col-span-1  flex flex-col justify-center px-4 py-4 bg-purple-400 shadow-md rounded">
                <div>
                    <p class="text-3xl font-bold text-center">{{$onBoardingAccounts->count()}}</p>
                    <p class="text-lg text-center">On boarding accounts</p>
                </div>
            </a>


            <a href="{{route('agent.people.index', ['status' => 'suspended'])}}" class="cursor-pointer hover:bg-black-600 text-white col-span-6 sm:col-span-2 lg:col-span-1  flex flex-col justify-center px-4 py-4 bg-black-500 shadow-md rounded">
                <div>
                    <p class="text-3xl font-bold text-center">{{$suspendedAccounts->count()}}</p>
                    <p class="text-lg text-center">Suspended accounts</p>
                </div>
            </a>
            @endif
            <div class="col-span-6 md:pt-5">
                <h1 class="text-xl font-semibold text-gray-800">Upcoming meetings</h1>
                <span class="text-sm text-gray-600">Your upcoming meetings, sorted with the earliest meeting first</span>
                @if($upcomingMeetings->count() > 0)
                <table class="min-w-full divide-y divide-gray-200 mt-3 overflow-x-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Meeting
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Order
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Meeting Time
                            </th>
                            <th scope="col" class="relative px-3 py-3">
                               Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($upcomingMeetings as $meeting)
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap">
                                @if($meeting->agent_id === auth('agent')->user()->id || $meeting->translator_id === auth('agent')->user()->id)
                                    <a href="{{route('agent.meeting.waiting_room.show', $meeting->getRouteKey())}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">
                                        {{$meeting->orderItem->purchase_requirement->person->name}} - {{$meeting->orderItem->order->person->name}}
                                    </a>
                                @else
                                    <span class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">
                                          {{$meeting->orderItem->purchase_requirement->person->name}} - {{$meeting->orderItem->order->person->name}}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                <a href="{{route('agent.order.show', $meeting->orderItem->order->getRouteKey())}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">{{$meeting->orderItem->order->getRouteKey()}}</a>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                               {{$timezoneService->localTime(auth('agent')->user(), $meeting->orderItem->timeslot->start, 'd D M Y h:i A')}}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-center text-xs font-medium">
                                @if($meeting->agent_id === auth('agent')->user()->id || $meeting->translator_id === auth('agent')->user()->id)
                                <a href="{{route('agent.meeting.waiting_room.show', $meeting->getRouteKey())}}"
                                   class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-500 rounded focus:shadow-outline hover:bg-blue-800">
                                    Go to waiting room
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="my-3 px-2">
                    {{$upcomingMeetings->links()}}
                </div>
                @else
                <div class="h-16 p-10 flex justify-center items-center">
                    <span class="text-md italic text-gray-500">No upcoming meetings to show</span>
                </div>
                @endif
            </div>
{{--            @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::support)--}}
{{--            <div class="col-span-6 md:pt-5">--}}
{{--                <h1 class="text-xl font-semibold text-gray-800">Verified buyers with no meetings</h1>--}}
{{--                <span class="text-sm text-gray-600">These verified buyers have purchase requirements created but have no meetings requested</span>--}}
{{--                @if($verifiedBuyersWithNoMeetings->count() > 0)--}}
{{--                <table class="min-w-full divide-y divide-gray-200 mt-3 overflow-x-auto">--}}
{{--                    <thead class="bg-gray-100">--}}
{{--                    <tr>--}}
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">--}}
{{--                            Person--}}
{{--                        </th>--}}
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">--}}
{{--                            Business--}}
{{--                        </th>--}}
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">--}}
{{--                            Purchase Requirements--}}
{{--                        </th>--}}
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">--}}
{{--                            Status--}}
{{--                        </th>--}}
{{--                        <th scope="col" class="relative px-3 py-3">--}}
{{--                            <span class="sr-only">Actions</span>--}}
{{--                        </th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="bg-white divide-y divide-gray-200">--}}
{{--                    @foreach($verifiedBuyersWithNoMeetings as $person)--}}
{{--                        <tr>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap">--}}
{{--                                <a href="{{route('agent.people.show', $person->getRouteKey())}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">--}}
{{--                                    {{$person->name}}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">--}}
{{--                                <a href="{{route('agent.people.show', $person->getRouteKey())}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">--}}
{{--                                    {{$person->business->name}}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">--}}
{{--                                <a href="{{route('agent.purchase_requirements.index', ['person_id' => $person->id])}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">--}}
{{--                                    View all--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">--}}
{{--                                @switch($person->status)--}}
{{--                                    @case(\App\Enums\Person\AccountStatus::Unverified)--}}
{{--                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">--}}
{{--                                        Unverified--}}
{{--                                    </span>--}}
{{--                                    @break--}}
{{--                                    @case(\App\Enums\Person\AccountStatus::Verified)--}}
{{--                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">--}}
{{--                                        Verified--}}
{{--                                    </span>--}}
{{--                                    @break--}}
{{--                                    @case(\App\Enums\Person\AccountStatus::OnBoarding)--}}
{{--                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">--}}
{{--                                        On Boarding--}}
{{--                                    </span>--}}
{{--                                    @break--}}
{{--                                    @case(\App\Enums\Person\AccountStatus::Suspended)--}}
{{--                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">--}}
{{--                                        Suspended--}}
{{--                                    </span>--}}
{{--                                @break--}}
{{--                            @endswitch--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap text-right text-xs font-medium">--}}
{{--                                <a href="{{route('agent.people.show', $person->getRouteKey())}}" class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-blue-800">--}}
{{--                                    Contact--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                    <tfoot>--}}
{{--                </table>--}}
{{--                <div class="my-3 px-2">--}}
{{--                    {{$verifiedBuyersWithNoMeetings->links()}}--}}
{{--                </div>--}}
{{--                @else--}}
{{--                    <div class="h-16 p-10 flex justify-center items-center">--}}
{{--                        <span class="text-md italic text-gray-500">No people to show</span>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="col-span-6 md:pt-5 overflow-x-auto">--}}
{{--                <h1 class="text-xl font-semibold text-gray-800">Purchase requirements with expired with time slots</h1>--}}
{{--                <span class="text-sm text-gray-600">These purchase requirements have time slots that are expired or are fully booked out.</span>--}}
{{--                @if($purchaseRequirementsWithNoTimeSlots->count() > 0)--}}
{{--                <table class="min-w-full divide-y divide-gray-200 mt-3">--}}
{{--                    <thead class="bg-gray-100">--}}
{{--                    <tr>--}}
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">--}}
{{--                            Name--}}
{{--                        </th>--}}
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">--}}
{{--                            Person--}}
{{--                        </th>--}}
{{--                        <th scope="col"--}}
{{--                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">--}}
{{--                            Orders--}}
{{--                        </th>--}}
{{--                        <th scope="col" class="relative px-3 py-3">--}}
{{--                            <span class="sr-only">Actions</span>--}}
{{--                        </th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody class="bg-white divide-y divide-gray-200">--}}
{{--                    @foreach($purchaseRequirementsWithNoTimeSlots as $purchaseRequirement)--}}
{{--                        <tr>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap">--}}
{{--                                <a href="{{route('agent.purchase_requirements.show', $purchaseRequirement->getRouteKey())}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">--}}
{{--                                    {{$purchaseRequirement->product}}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">--}}
{{--                                <a href="{{route('agent.people.show', $purchaseRequirement->person->getRouteKey())}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">--}}
{{--                                    {{$purchaseRequirement->person->name}}--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">--}}
{{--                                {{$purchaseRequirement->orderItems->count()}}--}}
{{--                            </td>--}}
{{--                            <td class="px-6 py-3 whitespace-nowrap text-right text-xs font-medium">--}}
{{--                                <a href="{{route('agent.purchase_requirements.show', $purchaseRequirement->getRouteKey())}}"--}}
{{--                                   class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-blue-800">--}}
{{--                                    View--}}
{{--                                </a>--}}
{{--                                <a href="{{route('agent.purchase_requirements.edit', $purchaseRequirement->getRouteKey())}}"--}}
{{--                                   class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-blue-800">--}}
{{--                                    Update--}}
{{--                                </a>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--                <div class="my-3 px-2">--}}
{{--                    {{$purchaseRequirementsWithNoTimeSlots->links()}}--}}
{{--                </div>--}}
{{--                @else--}}
{{--                    <div class="h-16 p-10 flex justify-center items-center">--}}
{{--                        <span class="text-md italic text-gray-500">No purchase requirements to show</span>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--            </div>--}}
{{--        </div>--}}
{{--        @endif--}}
    </div>
@endsection
