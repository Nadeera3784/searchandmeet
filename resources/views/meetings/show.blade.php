@extends('layouts.app')

@section('content')
    <div class="bg pb-12 pt-20 min-h-screen relative">
        <div class="absolute bg-white bg-opacity-60 inset-0 pointer-events-none"></div>
        <div class="md:w-10/12 w-full mx-auto my-4 md:my-10 px-4 relative">
            <div class="flex flex-col bg-purple-800 rounded-md bg-opacity-70 text-white">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex md:flex-row flex-col md:items-center md:justify-between container">
                        <h1 class="text-2xl m-0 text-white font-bold">
                            {{ __('Meeting Details') }}
                        </h1>
                        @if($meeting->orderItem->purchase_requirement->person->trashed())
                            <span class="font-semibold text-white bg-black-400 transform px-3 py-2 mt-1 rounded flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                </svg>
                                Person not available
                            </span>
                        @else
                            @switch($meeting->status)
                                @case(\App\Enums\Meeting\MeetingStatus::Requires_Participant)
                                <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-yellow-400 hover:text-yellow-500 rounded focus:shadow-outline hover:bg-yellow-200">
                                    Requires participants
                                </span>
                                @break
                                @case(\App\Enums\Meeting\MeetingStatus::Scheduled)
                                <a href="{{route('person.meeting.waiting_room', $meeting->getRouteKey())}}" class="font-semibold transform hover:bg-primary_hover text-white bg-primary px-3 py-2 mt-1 rounded flex items-center ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3h5m0 0v5m0-5l-6 6M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z" />
                                    </svg>
                                    Enter waiting room
                                </a>
                                @break
                                @case(\App\Enums\Meeting\MeetingStatus::Draft)
                                <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-400 hover:text-blue-500 rounded focus:shadow-outline hover:bg-blue-200">
                                    Draft
                                </span>
                                @break
                                @case(\App\Enums\Meeting\MeetingStatus::Expired)
                                <span class="font-semibold px-2 inline-flex items-center p-1 ml-1 text-xs transition-colors duration-150 text-white bg-green-400 rounded focus:shadow-outline">
                                    Meeting completed
                                </span>
                                @break
                                @case(\App\Enums\Meeting\MeetingStatus::Rejected)
                                @case(\App\Enums\Meeting\MeetingStatus::Reschedule)
                                @case(\App\Enums\Meeting\MeetingStatus::Cancelled)
                                <span  class="font-semibold px-2 inline-flex items-center p-1 md:ml-1 text-xs transition-colors duration-150 text-white bg-red-500 rounded focus:shadow-outline">
									Cancelled
								</span>
                                @break
                            @endswitch
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <div class="col-span-6 md:col-start-1 md:col-end-4 md:row-start-1 ">
                            <p class="text-md my-2 flex content-start gap-2"><span class="font-semibold ">Meeting ID</span>:<span> {{$meeting->getRouteKey()}}</span></p>
                            <p class="text-md my-2 flex content-start gap-2"><span class="font-semibold ">Appointment time</span>:<span> {{$meeting->orderItem->timeslot->appointment_time()}}</span></p>
                        </div>
                        <div class="container grid grid-cols-1 overflow-hidden gap-4 py-5">
                            <div class="px-5 py-3 flex flex-row justify-between sm:flex-row sm:items-center bg-gray-50 hover:bg-gray-100 shadow-md rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                                <h2 class="text-md font-bold mb-1">
                                    <p class="font-semibold text-gray-900">Related purchase requirement</p>
                                    @if($meeting->orderItem->purchase_requirement->person->trashed())
                                        <span class="font-semibold text-white bg-black-400 transform px-3 py-2 mt-1 rounded flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                        </svg>
                                        Purchase requirement not available
                                    </span>
                                    @else
                                    <a href="{{route('purchase_requirements.show',$meeting->orderItem->purchase_requirement->getRouteKey())}}" class="inline-flex items-center text-primary hover:text-primary_hover transition-colors duration-150 rounded">
                                        {{$meeting->orderItem->purchase_requirement->product}}
                                    </a>
                                    @endif
                                </h2>
                                <div class="text-lg font-normal mr-3 flex items-center">
                                    @if($meeting->orderItem->purchase_requirement->person->trashed())
                                    @else
                                        <a href="{{route('purchase_requirements.show',$meeting->orderItem->purchase_requirement->getRouteKey())}}" class="font-semibold text-purple-100 transform hover:bg-purple-700 hover:text-purple-100 bg-purple-500 px-3 py-2 mt-1 rounded flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="px-5 py-3 flex flex-row justify-between sm:flex-row sm:items-center bg-gray-50 hover:bg-gray-100 shadow-md rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                                <h2 class="text-md font-bold mb-1">
                                    <p class="font-semibold text-gray-900">Related Contacts</p>
                                    <a href="{{route('person.orders.show',$meeting->orderItem->order->getRouteKey())}}" class="inline-flex items-center text-primary hover:text-primary_hover transition-colors duration-150 rounded">
                                        {{$meeting->orderItem->order->getRouteKey()}}
                                    </a>
                                </h2>
                                <div class="text-lg font-normal flex items-center">
                                    <a href="{{route('person.orders.show',$meeting->orderItem->order->getRouteKey())}}" class="font-semibold text-purple-100 transform hover:bg-purple-700 hover:text-purple-100 bg-purple-500 px-3 py-2 mt-1 rounded flex items-center text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 text-left mb-3 sm:px-6">
                    <a href="{{route('person.orders.index')}}" class="py-2 px-6 bg-purple-100 hover:bg-purple-300 hover:border-purple-300 border border-purple-100 rounded-md shadow-md text-sm font-semibold text-gray-800 focus:outline-none focus:ring-0">
                        Back
                </a>
                </div>
            </div>
        </div>
    </div>
@endsection
