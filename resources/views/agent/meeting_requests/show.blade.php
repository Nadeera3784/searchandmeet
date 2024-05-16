@extends('layouts.admin')
@section('content')
	@inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="bg-white"> 
			<div class="flex flex-col">
				<div class="shadow overflow-hidden sm:rounded-md text-gray-500">
					<div class="px-4 py-5 bg-white sm:p-6">
						<h1 class="text-2xl m-0 ">
							{{ __('Meeting request Details') }}
						</h1>
						<hr class="my-1 mb-5">
						<div class="grid grid-cols-6 gap-5">
							<div class="col-span-6 md:col-start-1 md:col-end-4 md:row-start-1 text-gray-600">
								<div class="grid grid-cols-2 gap-4">
									<div class="col-span-1">
										<span class="font-bold">Submitted by </span>
									</div>
									<div class="col-span-1">
										<a href="{{route('agent.people.show', $meeting_request->person->getRouteKey())}}" class="cursor-pointer inline-flex items-center text-xs text-blue-800 transition-colors font-bold duration-150 rounded focus:shadow-outline">
											{{ $meeting_request->person->name}}
										</a>
										<span class="mx-3">|</span>
										<a class="cursor-pointer inline-flex items-center text-xs text-blue-800 transition-colors font-bold duration-150 rounded focus:shadow-outline" href="mailto://{{ $meeting_request->person->email}}">Send an email to {{ $meeting_request->person->email}}</a>
									</div>
									<div class="col-span-1">
										<span class="font-bold">Purchase requirement </span>
									</div>
									<div class="col-span-1">
										<a href="{{route('agent.purchase_requirements.show', $meeting_request->purchase_requirement->getRouteKey())}}" class="cursor-pointer truncate w-20inline-flex items-center text-xs text-blue-800 transition-colors font-bold duration-150 rounded focus:shadow-outline">
											{{$meeting_request->purchase_requirement->product}}
										</a>
									</div>
									<div class="col-span-1">
										<span class="font-bold">Default week day availability </span>
									</div>
									<div class="col-span-1 font-bold">
										From {{$timezoneService->localTime(auth('agent')->user(), $meeting_request->default_availability['start'], 'h:i A')}} To {{$timezoneService->localTime(auth('agent')->user(), $meeting_request->default_availability['end'], 'h:i A')}}
									</div>
									<div class="col-span-2">
										<span class="font-bold">Custom week day availability  </span>
									</div>
									<div class="col-span-2">
										<table class="min-w-full text-sm text-gray-400">
											<thead class="bg-gray-800 text-xs uppercase font-medium">
											<tr>
												<th scope="col" class="px-6 py-3 text-left tracking-wider">
													Monday
												</th>
												<th scope="col" class="px-6 py-3 text-left tracking-wider">
													Tuesday
												</th>
												<th scope="col" class="px-6 py-3 text-left tracking-wider">
													Wednesday
												</th>
												<th scope="col" class="px-6 py-3 text-left tracking-wider">
													Thursday
												</th>
												<th scope="col" class="px-6 py-3 text-left tracking-wider">
													Friday
												</th>
											</tr>
											</thead>
											<tbody class="bg-indigo-800 text-white">
											<tr>
												@foreach($meeting_request->day_availability as $weekday)
													<td class="px-6 py-3 text-left tracking-wider">
														@if(count($weekday['availability']) === 0)
															Default
															@else
															{{$timezoneService->localTime(auth('agent')->user(), $weekday['availability']['from'], 'h:i A')}} - {{$timezoneService->localTime(auth('agent')->user(), $weekday['availability']['to'], 'h:i A')}}
														@endif
													</td>
												@endforeach
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-span-1">
										<span class="font-bold">Custom timeslot  </span>
									</div>
									<div class="col-span-1">
										<span class="font-bold">
											@if($meeting_request->custom_timeslot)
												{{$meeting_request->custom_timeslot->appointment_time()}}
											@else
												Custom meeting timeslot not provided
											@endif
										</span>
									</div>
									<div class="col-span-1">
										<span class="font-bold">
											Recommend similar requirements?
										</span>
									</div>
									<div class="col-span-1">
										<span class="font-bold">
											@if($meeting_request->recommend_similar_products === 1)
												Yes
											@else
												No
											@endif
										</span>
									</div>
									<div class="col-span-1">
										<span class="font-bold">
											Status
										</span>
									</div>
									<div class="col-span-1">
										 @switch($meeting_request->status)
											@case(\App\Enums\MeetingRequest\MeetingRequestStatus::Processing)
											<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-green-500 rounded focus:shadow-outline hover:bg-green-600">
												Processing
											</span>
											@break
											@case(\App\Enums\MeetingRequest\MeetingRequestStatus::Processed)
											<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-500 rounded focus:shadow-outline hover:bg-green-600">
												Processed
											</span>
											@break
										@endswitch
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="px-4 py-3 text-left mb-3 sm:px-6">
						<a href="{{route('agent.meeting_requests.index')}}" class="cursor-pointer inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
							Back
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
