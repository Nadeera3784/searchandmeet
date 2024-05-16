@extends('layouts.app')

@section('content')

<div class="container mx-auto pt-20">
    <div class="flex justify-between">
        <div class="w-full mx-auto lg:w-8/12">
            <div class="w-full max-w-4xl my-2 bg-white rounded-lg shadow-xl">
                <div class="p-4 border-b">
                    <h2 class="text-2xl">
                        Contact Information
                    </h2>
                    <p class="text-sm text-gray-500">
                        Personal details and application.
                    </p>
                </div>
                <div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Contact Name
                        </p>
                        <p>
                            {{$purchaserequirement->contact->first_name}} {{$purchaserequirement->contact->last_name}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Title
                        </p>
                        <p>
                            {{$purchaserequirement->contact->contact_title->name}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Email
                        </p>
                        <p>
                            {{$purchaserequirement->contact->email}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Mobile
                        </p>
                        <p>
                            {{$purchaserequirement->contact->msistn}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Category T1,T2,T3
                        </p>
                        <p>
                            {{$purchaserequirement->contact->first_name}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-4xl my-2 bg-white rounded-lg shadow-xl">
                <div class="p-4 border-b">
                    <h2 class="text-2xl ">
                        Purchasing Requirment
                    </h2>
                    <p class="text-sm text-gray-500">
                        Personal details and application.
                    </p>
                </div>
                <div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Categories
                        </p>
                        <p>{{$purchaserequirement->category->name}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Product
                        </p>
                        <p>{{$purchaserequirement->product}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Detailed Description
                        </p>
                        <p>{{$purchaserequirement->description}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Purchase Quantity
                        </p>
                        <p>{{$purchaserequirement->quantity}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Preferred Unit Price
                        </p>
                        <p>{{$purchaserequirement->price}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Purchase Value USD
                        </p>
                        <p>{{$purchaserequirement->quantity*1 * $purchaserequirement->price*1}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Product URL
                        </p>
                        <p>{{$purchaserequirement->url}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Images
                        </p>
                        <ul class="-mx-4 flex">
                            <li class="flex-inline items-center mt-3">
                                <img src="https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=731&amp;q=80" alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            </li>
                            <li class="flex-inline items-center mt-3">
                                <img src="https://images.unsplash.com/photo-1464863979621-258859e62245?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=333&amp;q=80" alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            </li>
                            <li class="flex-inline items-center mt-3">
                                <img src="https://images.unsplash.com/photo-1531251445707-1f000e1e87d0?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=281&amp;q=80" alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            </li>
                            <li class="flex-inline items-center mt-3">
                                <img src="https://images.unsplash.com/photo-1500757810556-5d600d9b737d?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=735&amp;q=80" alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            </li>
                            <li class="flex-inline items-center mt-3">
                                <img src="https://images.unsplash.com/photo-1502980426475-b83966705988?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=373&amp;q=80" alt="avatar" class="object-cover w-10 h-10 mx-4 rounded-full">
                            </li>
                        </ul>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Pre-Meeting Samples
                        </p>
                        <p>{{$purchaserequirement->pre_meeting_sample}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Trade Terms
                        </p>
                        <p>{{$purchaserequirement->trade_term}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Perment Terms
                        </p>
                        <p>{{$purchaserequirement->payment_term}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Certification Requirment
                        </p>
                        <p>{{$purchaserequirement->certification_requirement}}</p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            HS Code
                        </p>
                        <p>{{strtoupper($purchaserequirement->hs_code)}}</p>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl my-2">
                <div class="p-4 border-b">
                    <h2 class="text-2xl">
                        Company Information
                    </h2>
                    <p class="text-sm text-gray-500">
                        Personal details and application.
                    </p>
                </div>
                <div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Company
                        </p>
                        <p>
                            {{$purchaserequirement->business->name}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Company Type
                        </p>
                        <p>
                            {{$purchaserequirement->business->business_type->name}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Current Importer
                        </p>
                        <p>
                            {{$purchaserequirement->business->current_importer}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Phone Number
                        </p>
                        <p>
                            {{$purchaserequirement->business->phone}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Website
                        </p>
                        <p>
                            {{$purchaserequirement->business->website}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            LinkedIn Profile
                        </p>
                        <p>
                            {{$purchaserequirement->business->linkedin}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Facebook Business Profile
                        </p>
                        <p>
                            {{$purchaserequirement->business->facebook}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Address
                        </p>
                        <p>
                            {{$purchaserequirement->business->address}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            City
                        </p>
                        <p>
                            {{$purchaserequirement->business->city}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            State
                        </p>
                        <p>
                            {{$purchaserequirement->business->state}}
                        </p>
                    </div>
                    <div class="p-4 space-y-1 border-b md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0">
                        <p class="text-gray-600">
                            Country
                        </p>
                        <p>
                            {{$purchaserequirement->business->country->name}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
