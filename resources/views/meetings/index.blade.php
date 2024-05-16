@extends('layouts.app')

@section('content')
	@inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
	<div class="bg flex pt-20 min-h-screen px-4 relative">
        <div class="absolute bg-white bg-opacity-60 inset-0 pointer-events-none"></div>
		<div class='overflow-x-auto bg-purple-800 bg-opacity-70 rounded-md my-10 w-full h-full  px-4 md:w-10/12 mx-auto relative'>
			<h1 class="text-2xl font-bold text-white pt-5 px-2">Meetings List</h1>
			<div class="container grid grid-cols-1 overflow-hidden gap-4 py-5 px-2 max-h-screen overflow-y-auto">
                @if(count($meetings) == 0 )
					<div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
						<div class="text-xl font-semibold">
							No Meetings Found
						</div>
					</div>
                @endif
                @foreach($meetings as $meeting)
                <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 hover:bg-gray-100 shadow-md rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div>
                        <h2 class="text-md font-bold mb-1">
							<a href="{{route('person.orders.show', $meeting->orderItem->order->getRouteKey())}}" class="inline-flex items-center text-primary hover:text-primary_hover transition-colors duration-150 rounded">
								Meeting between {{$meeting->orderItem->order->person->name}} - {{$meeting->orderItem->purchase_requirement->person->name}}
							</a>
							@switch($meeting->status)
								@case(\App\Enums\Meeting\MeetingStatus::Requires_Participant)
								<span  class="font-semibold px-2 inline-flex items-center p-1 md:ml-1 text-xs transition-colors duration-150 text-white bg-orange-600 rounded focus:shadow-outline">
									Requires participants
								</span>
								@break
								@case(\App\Enums\Meeting\MeetingStatus::Scheduled)
								<span  class="font-semibold px-2 inline-flex items-center p-1 md:ml-1 text-xs transition-colors duration-150 text-green-50 bg-green-500 rounded focus:shadow-outline">
									Active
								</span>
								@break
								@case(\App\Enums\Meeting\MeetingStatus::Draft)
								<span  class="font-semibold px-2 inline-flex items-center p-1 md:ml-1 text-xs transition-colors duration-150 text-white bg-blue-500 rounded focus:shadow-outline">
									Draft
								</span>
								@case(\App\Enums\Meeting\MeetingStatus::Expired)
								<span  class="font-semibold px-2 inline-flex items-center p-1 md:ml-1 text-xs transition-colors duration-150 text-white bg-red-500 rounded focus:shadow-outline">
									Expired
								</span>
								@break
								@case(\App\Enums\Meeting\MeetingStatus::Rejected)
								@case(\App\Enums\Meeting\MeetingStatus::Reschedule)
								@case(\App\Enums\Meeting\MeetingStatus::Cancelled)
								<span  class="font-semibold px-2 inline-flex items-center p-1 md:ml-1 text-xs transition-colors duration-150 text-white bg-green-500 rounded focus:shadow-outline">
									Cancelled
								</span>
								@break
							@endswitch
                        </h2>
						<div class="text-lg font-normal mr-3 flex items-center">
							<div class="text-sm text-gray-600 font-semibold mr-3 flex flex-col items-start">
								<p class="flex items-center space-x-2">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-flex text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
									</svg>
									<span>{{$timezoneService->localTime(auth('person')->user(), $meeting->orderItem->timeslot->start, 'd D M Y')}}</span>

								</p>
								<p class="flex items-center space-x-2">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-flex text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									<span>{{$timezoneService->localTime(auth('person')->user(), $meeting->orderItem->timeslot->start, 'H:i A')}}</span>
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-flex text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
									</svg>
									<span>{{$timezoneService->localTime(auth('person')->user(), $meeting->orderItem->timeslot->end, 'H:i A')}}</span>
								</p>
							</div>

						</div>
                    </div>
                    <div class="md:ml-auto flex items-center justify-between md:justify-end">
						<div class="text-lg font-bold mr-3 flex items-center">
							@switch($meeting->initiator)
								@case(0)
								<p class="text-sm my-2">Initiated by you</p>
								@break
								@case(1)
								<p class="text-sm my-2">Initiated by Contact</p>
								@break
							@endswitch
						</div>
						@if($meeting->orderItem->purchase_requirement->person->trashed())
						<span class="font-semibold text-white bg-black-400 transform px-3 py-2 mt-1 rounded flex items-center text-sm">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
							</svg>
							Person not available
						</span>
						@else
                        <a href="{{route('person.meetings.show', $meeting->getRouteKey())}}" class="mr-3 font-semibold text-purple-100 transform hover:bg-purple-700 hover:text-purple-100 bg-purple-500 px-3 py-2 mt-1 rounded flex items-center text-sm">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
							</svg>
							Show
						</a>
						@endif
                    </div>
                </div>
                @endforeach
            </div>
		</div>
	</div>

@endsection
