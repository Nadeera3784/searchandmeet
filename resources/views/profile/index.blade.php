@extends('layouts.app')

@section('content')

@if (session('reserve-success'))
    <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 relative z-50">
        <div class="flex items-center justify-center w-12 bg-green-500">
            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
            </svg>
        </div>

        <div class="px-4 py-2 -mx-3">
            <div class="mx-3">
                <span class="font-semibold text-green-500 dark:text-green-400">Success</span>
                <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('reserve-success') }} Go to <a href="{{route('checkout')}}" class="text-red-500 font-semibold">Checkout</a></p>
            </div>
        </div>
    </div>
@endif
@php
$timeslots = []; @endphp
@foreach(unserialize($purchaserequirement->timeslots) as $key => $slot)
@php
    $timeslots[serialize($slot)] = $slot['date'] .' from '. $slot['from'] .' to '. $slot['to']; @endphp
@endforeach
@include('profile.modal',['timeslots' => $timeslots]);
<div class="bg-gray-50  pb-8">
    <div class="container mx-auto pt-24">
        <div>
            <a href="{{ url()->previous() }}" class="flex items-center px-4 width-fit-content">
                <span class="bg-white shadow rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>

                <span class="text-sm font-bold ml-2 text-gray-500">Back</span>
            </a>
        </div>

        <div class="flex items-start md:flex-row flex-col">
            {{-- <div class="md:w-1/4 w-full px-5 pt-5 pb-0 md:pb-5">
                <p class="text-xl font-bold mb-5">Other Profile</p>
                <div class="md:block hidden">
                   @for($i=0;$i<8;$i++)
                       @include('demo.profile.single-other-profile')
                   @endfor
                </div>

                <div class="owl-carousel owl-theme   md:hidden block">
                    @for($i=0;$i<8;$i++)
                      @include('demo.profile.single-other-profile')
                    @endfor
                </div>
            </div> --}}

            <div class="md:w-7/12 w-full p-3  pt-0">
                <div class="bg-white shadow p-5 mt-5 md:px-8 rounded-lg">

                    {{-- <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Category T1,T2,T3</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->contact->first_name}}</div>
                    </div> --}}

                    <p class="text-lg font-bold mb-8">Purchasing Requirment</p>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Categories</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->category->name}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Product</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->product}}</div>
                    </div> <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Detailed Description</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->description}}</div>
                    </div>

                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Purchase Quantity</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->quantity}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Preferred Unit Price</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{number_format($purchaserequirement->price, 2)}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Purchase Value USD</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{number_format(($purchaserequirement->quantity*1 * $purchaserequirement->price*1), 2)}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Product URL</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->url}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Images</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4 grid md:grid-cols-4 grid-cols-2 gap-4">

                            @for($i=0;$i<8;$i++)
                                <img class="w-full object-cover max-h-24" src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NXx8Z2lybHxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60" alt="image">
                            @endfor

                        </div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Pre-Meeting Samples</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->pre_meeting_sample}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Trade Terms</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->trade_term}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Cash Down</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->payment_term}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Certification Requirment</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->certification_requirement}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">HS Code</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{strtoupper($purchaserequirement->hs_code)}}</div>
                    </div>

                    <p class="text-lg font-bold my-8">Company Information</p>

                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Company</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->name}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Company Type</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->business_type->name}}</div>
                    </div> <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Current Importer</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->current_importer}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Phone Number</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->phone}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Website</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->website}}</div>
                    </div>

                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">LinkedIn Profile</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->linkedin}}</div>
                    </div>

                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Facebook Business Profile</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->facebook}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Address</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->address}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">City</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->city}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">State</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->state}}</div>
                    </div>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Country</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->business->country->name}}</div>
                    </div>
                </div>
            </div>

            <div class="md:w-5/12 w-full p-3">
                <div class="bg-white shadow rounded-lg p-5 ">
                    <p class="text-lg font-bold mb-4">Contact Information</p>
                    <?php $is_logged = auth()->guard('person')->check() ?>
                    <div class="flex items-center relative">
                        <div class="px-3 py-4 bg-gray-100  w-2/6">Contact Name</div>
                        <div class="px-3 py-4 bg-gray-50 w-4/6 filter blur-sm">Lorem, ipsum.</div>
                        {{-- @if(!$is_logged)
                        @else
                            <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->contact->first_name}} {{$purchaserequirement->contact->last_name}}</div>
                        @endif --}}
                        <div class="absolute right-3 flex items-center text-green-400" >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg><p class="text-xs ml-1 sm:block hidden">Verified</p>
                        </div>
                    </div>

                    <div class="flex items-center relative">
                        <div class="px-3 py-4 bg-gray-100 w-2/6">Title</div>
                        <div class="px-3 py-4 bg-gray-50 w-4/6 filter blur-sm">Loremipsum dolor.</div>
                        {{-- @if(!$is_logged)
                        @else
                            <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->contact->contact_title->name}}</div>
                        @endif --}}
                        <div class="absolute right-3 flex items-center text-green-400 " >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg><p class="text-xs ml-1 sm:block hidden">Verified</p>
                        </div>
                    </div> 
                    <div class="flex items-center relative">
                        <div class="px-3 py-4 bg-gray-100 w-2/6">Email</div>
                        <div class="px-3 py-4 bg-gray-50  w-4/6 filter blur-sm">ipsumdolor@sit.com</div>
                        {{-- @if(!$is_logged)
                        @else
                            <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->contact->email}}</div>
                        @endif --}}
                        <div class="absolute right-3 flex items-center text-green-400 " >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg><p class="text-xs ml-1 sm:block hidden">Verified</p>
                        </div>
                    </div>

                    <div class="flex items-center relative">
                        <div class="px-3 py-4 bg-gray-100 w-2/6">Mobile</div>
                        <div class="px-3 py-4 bg-gray-50 w-4/6 filter blur-sm">+28 723 892 929</div>
                        {{-- @if(!$is_logged)
                        @else
                            <div class="px-3 py-4 bg-gray-50 w-3/4">{{$purchaserequirement->contact->msistn}}</div>
                        @endif --}}
                        <div class="absolute right-3 flex items-center text-green-400 " >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg><p class="text-xs ml-1 sm:block hidden">Verified</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg mt-5   border-gray-200  p-5 py-8 relative">
                    {!! Form::open(['url' => (auth()->guard('person')->check() ? route('person.orders.reserve') : route('exLogin'))]) !!}
                        <p class="text-center font-bold text-xl text-primary">Meet & Close The Deal</p>

                        <p class="text-center text-sm text-gray-400 mt-2">Select one of the available time slots or request a new time</p>


                        {{-- @foreach(unserialize($purchaserequirement->timeslots) as $timeslot)
                            <span>{{ $timeslot['date'] }} <br> <span class="text-xs">from {{ $timeslot['from'] }} to {{ $timeslot['to'] }}</span></span> <br>
                        @endforeach --}}

{{--     
                        {!! Form::select('slot', $timeslots, old('slot'), ['placeholder' => 'Available Slot', 'required' => 'required', 'class' => 'block w-full mt-3 text-sm p-2 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300']) !!}
                        
                        <p class="text-center font-bold text-xl text-primary mt-3">Meeting With Host</p>

                        <p class="text-center font-bold text-xl mt-1">$200</p>

                        {!! Form::select('type', [1 => 'Meeting With Host', 2 => 'Book & Meet', 3 => 'Access Information'], old('type'), [/*'placeholder' => 'Host',*/ 'required' => 'required', 'class' => 'block w-full mt-3 text-sm p-2 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300']) !!} --}}

                        {{-- @if(auth()->guard('person')->check())
                        
                            {!! Form::submit('Reserve Now', ['class' => 'hover:bg-red-600 uppercase text-sm mt-5 font-semibold w-full block text-center py-3 border-r  bg-primary text-white rounded-sm']); !!}
                        @else

                        @endif --}}
                        <button onclick="return false" class="modal-open text-sm mt-5 font-semibold w-full block text-center py-3 border-r  bg-primary hover:bg-red-600 text-white rounded-sm" href="{{route('exLogin', ['redirect' => url()->full()])}}">Sign In</button>

                        {!! Form::hidden('pr_id', $purchaserequirement->id) !!}
                    {!! Form::close() !!}
                </div>

                <div class="bg-white shadow rounded-lg mt-5   border-gray-200  p-5 py-8">
                    <p class="text-center text-sm text-gray-400 mt-2">Get a professional consultant to call, organize and host the meeting.</p>

                    <ul class="text-gray-500 mt-5 list-outside px-4">
                        <li class="py-2 ">Access Information</li>
                        <li class="py-2 ">Meeting Management Dashboard</li>
                        <li class="py-2 ">Pick an available time</li>
                        <li class="py-2 ">Request Hoted Meeting</li>
                        <li class="py-2 ">Organize, follow up and facilitate the meeting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
