@extends('layouts.app')

@section('content')
    @inject('orderService',  'App\Services\Order\OrderServiceInterface')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    <div class="pb-12 pt-20 min-h-screen bg overflow-hidden">
        <div class="absolute bg-white bg-opacity-60 inset-0 pointer-events-none"></div>
        <div class="md:w-10/12 w-full mx-auto relative px-4">
            <div class="flex flex-col bg-purple-800 bg-opacity-70 rounded-md my-10 ">
                <div class="px-4 pt-5 sm:p-6">
                    <h1 class="text-2xl m-0 text-white font-bold">
                        {{ __('Contacts Details') }}
                    </h1>
                    <div class="flex flex-col">
                        <div class="col-span-6 md:col-start-1 md:col-end-4 md:row-start-1 text-gray-200">
                            <p class="text-md my-2 flex content-start gap-2"><span class="font-semibold ">Items</span>:<span>{{$order->items->count()}}</span></p>
                            <p class="text-md my-2 flex content-start gap-2"><span class="font-semibold ">Total Amount</span>:<span>${{$orderService->getTotal($order)}}</span></p>
                        </div>
                        <h1 class="text-xl font-bold text-white">Item List</h1>
                        <div class="container grid grid-cols-1 overflow-hidden gap-4 py-5 max-h-128 overflow-y-auto">
                            @if(count($order->items) == 0 )
                                <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                                    <div class="text-xl font-semibold">
                                        No Items Found
                                    </div>
                                </div>
                            @endif
                            @foreach($order->items as $item)
                            <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 hover:bg-gray-100 shadow-md rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                                <div>
                                    <h2 class="text-md font-bold mb-1">
                                        <a href="{{route('purchase_requirements.show', $item->purchase_requirement->getRouteKey())}}" class="inline-flex items-center text-primary hover:text-primary_hover transition-colors duration-150 rounded">
                                            {{$item->purchase_requirement->product}}
                                        </a>
                                    </h2>
                                    <div class="text-lg font-normal mr-3 flex items-center">
                                        <div class="text-sm text-gray-600 font-semibold mr-3 flex flex-col items-start">
                                            @if($timeslot = $item->timeslot)

                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-flex text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{$timezoneService->localTime(auth('person')->user(), $timeslot->start, 'd D M Y')}}</span>

                                                </p>
                                                <p class="flex items-center space-x-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-flex text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>{{$timezoneService->localTime(auth('person')->user(), $timeslot->start, 'H:i A')}}</span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-flex text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                    </svg>
                                                    <span>{{$timezoneService->localTime(auth('person')->user(), $timeslot->end, 'H:i A')}}</span>
                                                </p>
                                            @else
                                                <span class="text-left  font-semibold text-sm text-muted">No time slot selected</span>
                                            @endif
                                            @if($order->status === \App\Enums\Order\OrderStatus::Cancelled)
                                                <div class="font-semibold text-white bg-black-100 transform px-2 py-1 rounded mt-2 text-xs">
                                                    Order cancelled
                                                </div>
                                            @elseif($order->status != \App\Enums\Order\OrderStatus::Completed)
                                                <div class="font-semibold text-white bg-black-100 transform px-2 py-1 rounded mt-2 text-xs">
                                                    Order not complete
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-auto flex items-center w-max gap-2">
                                    @if($item->purchase_requirement->person->trashed())
                                        <span class="font-semibold text-white bg-black-400 transform px-3 py-2 mt-1 rounded flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                            </svg>
                                            Purchase requirement not available
                                            </span>
                                    @else
                                        @if($order->status !== \App\Enums\Order\OrderStatus::Cancelled)
                                            <div x-data="{show: false, isDialogOpen: false}" @click.away="show = false">
                                        <button @click="isDialogOpen = true" class="font-semibold text-purple-100 transform hover:bg-purple-700 hover:text-purple-100 bg-purple-500 px-3 py-2 mt-1 rounded flex items-center text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path st    roke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View contact details
                                        </button>
                                        <div class="overflow-auto bg-black-900 bg-opacity-50" x-show="isDialogOpen" :class="{ 'fixed inset-0 z-40 flex items-start justify-center': isDialogOpen }">
                                            <div class="bg-white shadow-2xl m-4 sm:m-8 rounded sm:w-4/6 w-full overflow-hidden" x-show="isDialogOpen" @click.away="isDialogOpen = false" >
                                                <div class="flex justify-between items-center border-b py-4 px-4 text-xl">
                                                    <h6 class="text-xl font-bold">Contact details</h6>
                                                    <button type="button" class="h-6 w-6" @click="isDialogOpen = false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="grid grid-cols-6 gap-x-5 gap-y-0">
                                                    <div class="col-span-6 md:col-span-3 shadow-md bg-gray-50 text-gray-600 rounded">
                                                        <div class="w-full bg-gray-50 overflow-hidden flex flex-col shadow-md">
                                                            <div class="py-14 w-full px-8">
                                                                <div>
                                                                    <img class="rounded-full h-32 w-32 mx-auto object-cover shadow-md" src="/img/hero-image-2.png" alt="hero-image-2hero-image-2.png.png">
                                                                    <div>
                                                                        <h1 class="text-center mt-3 text-2xl font-bold uppercase">
                                                                           {{$item->purchase_requirement->person->name}}
                                                                        </h1>
                                                                        <p class="text-center text-md uppercase mt-0 ">
                                                                            {{$item->purchase_requirement->person->business->country->name ?? '-'}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="flex flex-col space-y-2 mt-2 ">
                                                                    <h1 class="text-left uppercase font-medium my-3">{{ __('Contact') }}</h1>
                                                                    <div class="flex items-center space-x-2 relative">
                                                                        <div class="border-r-2 border-gray-300">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                            </svg>
                                                                        </div>
                                                                        <span class="text-left text-sm {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                            @if($item->order->status !== \App\Enums\Order\OrderStatus::Completed)
                                                                                {{$faker->address}}
                                                                            @else
                                                                                {{$item->purchase_requirement->person->business->address ?? ''}}, {{$item->purchase_requirement->person->business->city ?? ''}}, {{$item->purchase_requirement->person->business->state ?? ''}}, {{$item->purchase_requirement->person->business->country->name ?? ''}}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 relative">
                                                                        <div class="border-r-2 border-gray-300">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                                            </svg>
                                                                        </div>
                                                                        <span class="text-left text-sm {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                             @if($item->order->status !== \App\Enums\Order\OrderStatus::Completed)
                                                                                {{$faker->phoneNumber}}
                                                                            @else
                                                                                {{$item->purchase_requirement->person->formattedPhoneNumber() ?? '-'}}
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 relative">
                                                                        <div class="border-r-2 border-gray-300">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                            </svg>
                                                                        </div>
                                                                        <span class="text-left text-sm text-blue-500 {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                            {{$item->purchase_requirement->person->email ?? '-'}}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <hr class="mt-5">
                                                                <div class="flex flex-col space-y-2 mt-2 ">
                                                                    <h1 class="text-left uppercase font-medium my-3">{{ __('Business Details') }}</h1>
                                                                    <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->person->business->name == "" ? 'hidden' : '' }}">
                                                                        <div class="text-gray-500 border-gray-300 w-max">
                                                                            <span class="font-medium ml-2 whitespace-nowrap">Name : </span>
                                                                        </div>
                                                                        <p class="text-left text-sm font-semibold {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                            {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? $faker->name : $item->purchase_requirement->person->business->name}}
                                                                        </p>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 my-1 {{\App\Enums\Business\BusinessType::getDescription($item->purchase_requirement->person->business->type_id) == "" ? 'hidden' : '' }}">
                                                                        <div class="text-gray-500 border-gray-300 w-max">
                                                                            <span class="font-medium ml-2 whitespace-nowrap">Business Type : </span>
                                                                        </div>
                                                                        <p class="text-left text-sm font-semibold">{{ \App\Enums\Business\BusinessType::getDescription($item->purchase_requirement->person->business->type_id)}}</p>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->person->business->current_importer == "" ? 'hidden' : '' }}">
                                                                        <div class="text-gray-500 border-gray-300 w-max">
                                                                            <span class="font-medium ml-2 whitespace-nowrap">Current Importer : </span>
                                                                        </div>
                                                                        <p class="text-left text-sm font-semibold">{{$item->purchase_requirement->person->business->current_importer}}</p>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->person->business->phone == "" ? 'hidden' : '' }}">
                                                                        <div class="text-gray-500 border-gray-300 w-max">
                                                                            <span class="font-medium ml-2 whitespace-nowrap">Phone : </span>
                                                                        </div>
                                                                        <p class="text-left text-sm font-semibold {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                            @if($item->order->status !== \App\Enums\Order\OrderStatus::Completed)
                                                                                {{$faker->phoneNumber}}
                                                                                @else
                                                                                {{$item->purchase_requirement->person->business->phone}}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->person->business->website == "" ? 'hidden' : '' }}">
                                                                        <div class="text-gray-500 border-gray-300 w-max">
                                                                            <span class="font-medium ml-2 whitespace-nowrap">Website : </span>
                                                                        </div>
                                                                        <p class="text-left text-sm font-semibold text-blue-500 {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                            @if($item->order->status !== \App\Enums\Order\OrderStatus::Completed)
                                                                                {{$faker->url}}
                                                                            @else
                                                                                {{$item->purchase_requirement->person->business->website}}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->person->business->linkedin == "" ? 'hidden' : '' }}">
                                                                        <div class="text-gray-500 border-gray-300 w-max">
                                                                            <span class="font-medium ml-2 whitespace-nowrap">Linkedin : </span>
                                                                        </div>
                                                                        <p class="text-left text-sm font-semibold {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                            @if($item->order->status !== \App\Enums\Order\OrderStatus::Completed)
                                                                                {{$faker->url}}
                                                                            @else
                                                                                {{$item->purchase_requirement->person->business->linkedin}}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                    <div class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->person->business->facebook == "" ? 'hidden' : '' }}">
                                                                        <div class="text-gray-500 border-gray-300 w-max">
                                                                            <span class="font-medium ml-2 whitespace-nowrap">Facebook : </span>
                                                                        </div>
                                                                        <p class="text-left text-sm font-semibold {{$item->order->status !== \App\Enums\Order\OrderStatus::Completed ? 'blur-sm filter' : ''}}">
                                                                            @if($item->order->status !== \App\Enums\Order\OrderStatus::Completed)
                                                                                {{$faker->url}}
                                                                            @else
                                                                                {{$item->purchase_requirement->person->business->facebook}}
                                                                            @endif
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-span-6 md:col-span-3 text-gray-600 ">
                                                        <div class="flex flex-col space-y-2 px-8 py-10">
                                                            <h1 class="text-left uppercase font-medium mb-3">{{ __('Product Details') }}</h1>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->product == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Product : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold">{{$item->purchase_requirement->product}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->description == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Description : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold">{{$item->purchase_requirement->description}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Quantity : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold">{{$item->purchase_requirement->quantity." ".$item->purchase_requirement->metric->name }}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->price == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Price : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold">$ {{number_format($item->purchase_requirement->price,2)}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->url == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Url : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold text-blue-500">{{$item->purchase_requirement->url}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->pre_meeting_sample == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Pre Meeting Sample : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold ">{{$item->purchase_requirement->pre_meeting_sample}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->trade_term == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Trade Term : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold ">{{$item->purchase_requirement->trade_term}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->payment_term == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Payment Term : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold ">{{$item->purchase_requirement->payment_term}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->certification_requirement == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">Certification Requirement : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold ">{{$item->purchase_requirement->certification_requirement}}</p>
                                                            </div>
                                                            <div  class="flex items-center space-x-2 my-1 {{$item->purchase_requirement->hs_code == "" ? 'hidden' : '' }}">
                                                                <div class="text-gray-500 border-gray-300 w-max">
                                                                    <span class="font-medium ml-2 whitespace-nowrap">HS Code : </span>
                                                                </div>
                                                                <p class="text-left text-sm font-semibold ">{{$item->purchase_requirement->hs_code}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        @endif
                                        @if($item->meeting && $order->status !== \App\Enums\Order\OrderStatus::Cancelled)
                                            <a href="{{route('person.meeting.waiting_room', $item->meeting->getRouteKey())}}" class="font-semibold text-white transform hover:bg-green-700 bg-green-500 px-3 py-2 mt-1 rounded flex items-center text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Enter waiting room
                                            </a>
                                            <a href="{{route('person.meetings.show', $item->meeting->getRouteKey())}}" class="font-semibold text-purple-100 transform hover:bg-purple-700 hover:text-purple-100 bg-purple-500 px-3 py-2 mt-1 rounded flex items-center text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View meeting
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="px-4 pb-3 text-left mb-3 sm:px-6">
                    <a href="{{route('person.orders.index')}}" class="py-2 px-6 bg-purple-100 hover:bg-purple-300 border border-purple-100 rounded-md shadow-md text-sm font-semibold text-gray-800 focus:outline-none focus:ring-0">
                        Back
                </a>
                </div>
            </div>
        </div>
    </div>

@endsection
