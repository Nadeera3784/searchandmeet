@extends('layouts.app')

@section('content')
	@inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
<div id="wrapper" class="max-w-full min-h-screen px-4 md:px-24 pt-28 pb-20 bg relative">
    <div class="bg-white bg-opacity-60 inset-0 absolute pointer-events-none"></div>

	@include('components.alerts')
	<div class="grid gap-y-8 gap-x-8 grid-cols-4 relative">

		<div class="md:col-span-2 col-span-4 row-span-3 w-full">
			<div class="p-4 rounded-md shadow-md bg-white">
				<h1 class="text-xl font-semibold text-gray-900 flex items-center space-x-3 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                      </svg>
					  <span>
							Meetings
					  </span>
				</h1>
                <div class="navigation flex justify-between items-center my-3  mx-auto">
                    <div class="flex items-center gap-4">
                        <div class="prev-btn cursor-pointer w-7 h-7 rounded-full flex items-center justify-center text-gray-900 bg-gray-300 hover:bg-gray-400 transition-all ease-linear duration-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </div>
                        <div class="title">...</div>
                        <div class="next-btn cursor-pointer w-7 h-7 rounded-full flex items-center justify-center text-gray-900 bg-gray-300 hover:bg-gray-400 transition-all ease-linear duration-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="Cal_views flex items-center mb-5 mx-auto">
                    <div class="month-btn btn cursor-pointer w-max h-7 text-sm rounded-l px-3 flex items-center justify-center text-gray-900 bg-gray-300 hover:bg-gray-400 transition-all ease-linear duration-100">
                        Month
                    </div>
                    <div class="week-btn btn cursor-pointer w-max h-7 text-sm border-l border-r border-gray-200 px-3 flex items-center justify-center text-gray-900 bg-gray-300 hover:bg-gray-400 transition-all ease-linear duration-100">
                        Week
                    </div>
                    <div class="day-btn btn cursor-pointer w-max h-7 text-sm rounded-r px-3 flex items-center justify-center text-gray-900 bg-gray-300 hover:bg-gray-400 transition-all ease-linear duration-100">
                        Day
                    </div>
                    <div class="ml-auto today-btn cursor-pointer w-max h-7 text-sm rounded px-3 flex items-center justify-center text-white bg-primary hover:bg-primary_hover transition-all ease-linear duration-100">
                        Today
                    </div>
                </div>
				<div id="calendar" class="h-full w-full" >
				</div>
			</div>
		</div>
        <div class="col-span-4 md:col-span-2 row-start-1 grid gap-y-3 gap-x-8 md:grid-cols-6 grid-cols-4">
			<a href="{{route('person.orders.index')}}" class="col-span-6 flex flex-row justify-center mt-4 sm:mt-0 overflow-hidden">
				<div class="w-max px-3 py-3">
					<img src="/img/OrderIcon.png" alt="" class="object-cover w-12">
				</div>
				<div class="w-full px-6 py-3 flex flex-row-reverse justify-between items-center gap-4 bg-primary bg rounded-md relative overflow-hidden">
					<div class="absolute w-full h-full top-0 left-0 bg-gray-600" style="clip-path: polygon(100% 0%,60% 0%,50% 50%,60% 100%,100% 100%);"></div>
					<p class="relative text-3xl font-bold text-white">{{$orders->count()}}</p>
					<p class="relative text-lg text-white">Total Contacts</p																																						>
				</div>
			</a>
			{{-- <a href="{{route('person.orders.index')}}" class="col-span-6 flex flex-row justify-center mt-4 sm:mt-0 overflow-hidden">
				<div class="w-max px-3 py-3">
					<img src="/img/PenOrderIcon.png" alt="" class="object-cover w-12">
				</div>
				<div class="w-full px-6 py-3 flex flex-row-reverse justify-between items-center gap-4 bg-primary bg rounded-md relative overflow-hidden">
					<div class="absolute w-full h-full top-0 left-0 bg-gray-600" style="clip-path: polygon(100% 0%,60% 0%,50% 50%,60% 100%,100% 100%);"></div>
					<p class="relative text-3xl font-bold text-white">{{$orders->where('status', \App\Enums\Order\OrderStatus::Pending)->count()}}</p>
					<p class="relative text-lg text-white">Pending Orders</p																																						>
				</div>
			</a> --}}
			<a href="{{route('person.meetings.index')}}" class="col-span-6 flex flex-row justify-center mt-4 sm:mt-0 overflow-hidden">
				<div class="w-max px-3 py-3">
					<img src="/img/MeetingIcon.png" alt="" class="object-cover w-12">
				</div>
				<div class="w-full px-6 py-3 flex flex-row-reverse justify-between items-center gap-4 bg-primary bg rounded-md relative overflow-hidden">
					<div class="absolute w-full h-full top-0 left-0 bg-gray-600" style="clip-path: polygon(100% 0%,60% 0%,50% 50%,60% 100%,100% 100%);"></div>
					<p class="relative text-3xl font-bold text-white">{{$meetings->count()}}</p>
					<p class="relative text-lg text-white">Meetings</p																																						>
				</div>
			</a>
		</div>
		<div class="md:col-span-2 col-span-4 h-max p-4 rounded-md shadow-md w-full bg-white">
			<h1 class="text-xl font-semibold text-gray-900 flex items-center space-x-3 rounded-md px-3 py-2">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h5m0 0v5m0-5l-6 6M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
				  </svg>
				  <span>
					  Upcoming Meetings
				  </span>
			</h1>
			<div class="w-full overflow-auto max-h-64">
				<table class="w-full mt-5 text-sm table-auto">
					<thead>
					<tr class="text-left border-b">
						<th class="px-3 py-2">Scheduled Date</th>
						<th class="px-3 py-2">Scheduled Time</th>
						<th class="px-3 py-2">Contact</th>
						<th class="px-3 py-2">Action</th>
					</tr>
					</thead>
					<tbody>
					@foreach($meetings as $meeting)
						<tr class="border-b">
							<td class="px-3 py-2 whitespace-nowrap">{{$timezoneService->localTime(auth('person')->user(), $meeting->orderItem->timeslot->start, "d D M Y")}}</td>
							<td class="px-3 py-2 whitespace-nowrap">{{$timezoneService->localTime(auth('person')->user(), $meeting->orderItem->timeslot->start, "h:i A")}}</td>
							<td class="px-3 py-2">
								{{$meeting->orderItem->order->person->id === auth('person')->user()->id ? $meeting->orderItem->order->person->name : $meeting->orderItem->purchase_requirement->person->name}}
							</td>
							<td class="px-3 py-2">
								<a href="{{route('person.meetings.show', $meeting->getRouteKey())}}" class="w-max text-white transform hover:bg-purple-700 bg-purple-500 px-3 py-2 mt-1 rounded inline-flex items-center text-sm">
									<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
									</svg>
									View
								</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="md:col-span-2 col-span-4 h-max p-4 rounded-md shadow-md w-full bg-white">
			<h1 class="text-xl font-semibold text-gray-900 flex items-center space-x-3 rounded-md px-3 py-2">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
				</svg>
				<span>
					Recent Orders
				</span>
			</h1>
			<div class="w-full overflow-auto max-h-64">
				<table class="w-full mt-5 text-sm table-auto">
					<thead>
						<tr class="text-left border-b">
							<th class="px-3 py-2">Id</th>
							<th class="px-3 py-2">Status</th>
							<th class="px-3 py-2">Created on</th>
							<th class="px-3 py-2">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $order)
							<tr class="border-b">
								<td class="px-3 py-2">
									<a href="{{route('person.orders.show', $order->getRouteKey())}}" class=" transform py-1 mt-1 rounded flex items-center text-sm">
										{{$order->getRouteKey()}}
									</a>
								</td>
								<td class="px-3 py-2">
									<p class="text-sm text-gray-600 font-bold mr-3">
										<span class="text-purple-500 bg-purple-200 font-normal text-sm px-2 py-1 rounded-md">
											{{\App\Enums\Order\OrderStatus::getKey($order->status)}}
										</span>
									</p>
								</td>
								<td class="px-3 py-2  whitespace-nowrap">{{$timezoneService->localTime(auth('person')->user(), $order->created_at)}}</td>
								<td class="px-3 py-2">
									<a href="{{route('person.orders.show', $order->getRouteKey())}}" class=" text-white transform hover:bg-purple-700 bg-purple-500 px-3 py-2 mt-1 rounded inline-flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
										</svg>
										View
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<script>
	window.addEventListener('load',()=>{
		$(()=>{
			var events = {!! $meetings->map(function($meeting) use ($timezoneService) {
                return array(
                    'title' => 'Meeting - '.$meeting->getRouteKey(),
                    'start' => $timezoneService->localTime(auth('person')->user(), $meeting->orderItem->timeslot->start),
                    'end' => $timezoneService->localTime(auth('person')->user(), $meeting->orderItem->timeslot->end),
                    'url' => route('person.meetings.show', $meeting->getRouteKey()),
                );
            }) !!}
			var calendarEl = document.getElementById('calendar');

            var calendar = new Calendar(calendarEl, {
                plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
				headerToolbar: false,
                navLinks: false,
                editable: false,
                eventLimit: false,
                events: events,
                views: {
                    week: {
                        dayHeaderFormat: { weekday: 'narrow' }
                    },
                    month: {
                        dayHeaderFormat: { weekday: 'narrow' }
                    }
                }
            });

            calendar.render();
            const idToday = () => {
                var view = calendar.view;
                var start = moment(view.activeStart);
                var end = moment(view.activeEnd);
                var today = moment().isBetween(start,end);
                $('.today-btn').removeClass('bg-primary_hover');
                if(today){
                    $('.today-btn').addClass('bg-primary_hover');
                }
            }
            $('.today-btn').click((e) => {
                calendar.today();
                $('.today-btn').addClass('bg-primary_hover');
                $('.title').html(calendar.view.title)
            });
            $('.prev-btn').click((e) => {
                calendar.prev();
                $('.title').html(calendar.view.title)
                idToday();
            });
            $('.next-btn').click((e) => {
                calendar.next();
                $('.today-btn').removeClass('bg-gray-400');
                $('.title').html(calendar.view.title)
                idToday()
            });

            $('.day-btn').click((e) => {
                calendar.changeView('timeGridDay');
                $('.Cal_views .btn').removeClass('bg-gray-400');
                $('.day-btn').addClass('bg-gray-400');
                $('.title').html(calendar.view.title)
            });
            $('.week-btn').click((e) => {
                calendar.changeView('timeGridWeek');
                $('.Cal_views .btn').removeClass('bg-gray-400');
                $('.week-btn').addClass('bg-gray-400');
                $('.title').html(calendar.view.title)
            });
            $('.month-btn').click((e) => {
                calendar.changeView('dayGridMonth');
                $('.Cal_views .btn').removeClass('bg-gray-400');
                $('.month-btn').addClass('bg-gray-400');
                $('.title').html(calendar.view.title)
            });
            $('.month-btn').click();
            $('.today-btn').click();
		});
	});
</script>
@endsection
