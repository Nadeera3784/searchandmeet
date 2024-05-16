@extends('layouts.app')

@section('content')
    <div class="bg relative">
        <div class="bg-white bg-opacity-60 inset-0 absolute pointer-events-none"></div>
        <div class="container mx-auto md:w-4/5 h-full md:px-0 px-5 py-28 relative ">
            <div class="grid grid-cols-8 gap-x-0 bg-white shadow-md border-gray-200 rounded-md overflow-hidden" x-data="menuClick()" x-init="init()">
                <div class="col-span-8 md:col-span-2 py-6 bg-primary text-white">
                    <p class="px-6 text-left font-bold text-xl mb-3">Profile Details</p>
                    <li class="flex">
                        <div @click="change('profile')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white text-gray-800': is_open('profile') }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            <span class="ml-2">Profile</span>
                        </div>
                    </li>
                    <li class="flex">
                        <div @click="change('password')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white text-gray-800': is_open('password') }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                            </svg>
                            <span class="ml-2">Reset Password</span>
                        </div>
                    </li>
                    <li class="flex">
                        <div @click="change('cards')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white text-gray-800': is_open('cards') }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span class="ml-2">Payment methods</span>
                        </div>
                    </li>
                </div>
                <div class="grid grid-cols-8 col-span-8 md:col-span-6 p-6 px-8 pb-10">
                    <div x-show="is_open('profile')" class="col-span-8 md:col-span-5 lg:col-span-4">
                        {!! Form::open(['url' => route('person.profile.update')]) !!}
                        {!! method_field('PUT') !!}
                        {!! csrf_field() !!}
                        <div class="grid grid-cols-6 gap-5 rounded-lg">
                            <div class="col-span-6">
                                <p class="text-left font-bold text-xl text-gray-800 mb-1">Profile Details</p>
                            </div>
                            <div class="col-span-6">
                                {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                {!! Form::text('name', old('name') ?? $person->name, ['placeholder' => "Enter Your Name",'class' => 'mt-1 border-0 shadow-md  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('name') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-span-6">
                                {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                {!! Form::text('email', old('email') ?? $person->email, ['placeholder' => 'Enter Your Email Address','disabled' => 'disabled', 'class' => 'mt-1 border-0 shadow-md  focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('email') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-span-6">
                                <div class="flex">
                                    {!! Form::label('phone_number', 'Phone number', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    @if(auth('person')->user()->formattedPhoneNumber() && !auth('person')->user()->phone_verified_at)
                                    <form action="{{route('person.phone.verification.send')}}" method="POST">
                                        @csrf
                                        <a href="{{route('person.phone.verification')}}" class="text-blue-500 cursor-pointer text-sm font-bold mx-2 flex justify-center items-center gap-1 hover:text-blue-800">
                                            Verify now
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    </form>
                                    @endif
                                </div>
                                <div class="flex gap-2 mt-1">
                                    <div class="w-1/3">
                                        {!! Form::select('phone_code_id', $countries,  old('phone_code_id') ?? $person->country_id, ['class' => 'select2 mt-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'placeholder' => '--']); !!}
                                    </div>
                                    {!! Form::text('phone_number', old('phone_number') ?? $person->phone_number, ['placeholder'=>'Enter Phone number','class' => ' border-0 shadow-md focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                                </div>
                                @error('phone_number') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                @error('phone_code_id') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-span-6">
                                {!! Form::label('languages', 'Preferred languages', ['class' => 'block text-sm font-medium text-gray-700 required mb-1']); !!}
                                {!! Form::select('languages[]', $languages, old('languages[]') ?? $person->preferredLanguages->pluck('id'), ['multiple'=> 'multiple', 'placeholder' => 'Pick preferred languages...','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                @error('languages') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-span-6">
                                {!! Form::label('designation', 'Designation', ['class' => 'block text-sm font-medium text-gray-700 required mb-1']); !!}
                                {!! Form::select('designation', \App\Enums\Designations\DesignationType::asSelectArray(), old('designation') ?? $person->designation, ['placeholder' => 'Pick a job title...','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                @error('designation') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-span-6 md:col-span-3">
                                {!! Form::label('looking_for', 'Looking to meet..', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                {!! Form::select('looking_for', \App\Enums\ProspectType::asSelectArray(), old('looking_for') ?? $person->looking_for, ['placeholder' => 'Who are you looking to meet','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                @error('looking_for') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                @component('components.categorySearch', ['selectedCategory' => $person->lookingForCategory])
                                    @slot('label')
                                        Looking for meetings in category..
                                    @endslot
                                    @slot('labelClass')
                                        block text-sm font-medium text-gray-700 required
                                    @endslot
                                    @slot('selectClass')
                                        mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base
                                    @endslot
                                @endcomponent

                                @error('looking_for_category') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                            </div>


                            <div class="col-span-6 sm:col-span-3">
                                {!! Form::label('timezone_id', 'Timezone', ['class' => 'block text-sm font-medium text-gray-700 mb-1']); !!}
                                {!! Form::select('timezone_id', $timezones, old('timezone_id') ?? $person->timezone_id, ['class' => 'select2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('timezone_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                            </div>

                            {!! Form::submit('Save', ['class' => 'col-span-6 cursor-pointer text-sm mt-2 font-medium font-semibold w-max block text-center py-2 px-6 border-r  bg-primary text-white rounded-md ']); !!}
                        </div>
                        {!! Form::close() !!}
                        <form action="{{route('person.profile.delete')}}" method="POST" onsubmit="return confirm('Are you sure you want to delete account?');">
                            @csrf
                            @method('DELETE')
                            <div class="grid grid-cols-6 gap-5 rounded-lg mt-10">
                                <div class="col-span-6">
                                    <p class="text-left font-bold text-xl text-gray-800 mb-1">Account actions</p>
                                    <div class="flex justify-between items-center mt-3">
                                        <div class="flex flex-col justify-center">
                                            <span class="text-sm font-medium text-black-500 mb-1">Delete your account</span>
                                            <span class="text-xs font-medium text-gray-700 mb-1">By deleting your account, all related records will be removed from our system and <b>cannot be restored</b></span>
                                        </div>
                                        {!! Form::submit('Delete', ['class' => 'col-span-6 cursor-pointer text-sm mt-2 font-medium font-semibold w-max block text-center py-2 px-6 border-r focus:outline-none bg-primary hover:bg-primary_hover text-white rounded-md ']); !!}
                                    </div>
                                </div>

                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div x-show="is_open('password')" class="col-span-8 md:col-span-5 lg:col-span-4">
                        {!! Form::open(['url' => route('person.update_password')]) !!}
                        {!! method_field('PUT') !!}
                        {!! csrf_field() !!}
                        <div class="grid grid-cols-6 gap-5 rounded-lg">
                            <div class="col-span-6">
                                <p class="text-left font-bold text-xl text-gray-800 mb-3">Change Password</p>
                            </div>
                            <div class="col-span-6">
                                {!! Form::label('old_password', 'Old Password', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                {!! Form::password('old_password', ['placeholder' => "Enter Old Password", 'class' => 'border-0 shadow-md mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('old_password') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-span-6">
                                {!! Form::label('password', 'New Password', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                {!! Form::password('password', ['placeholder' => "Enter New Password", 'class' => 'border-0 shadow-md mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('password') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-span-6">
                                {!! Form::label('password_confirmation', 'Confirm New Password', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                {!! Form::password('password_confirmation', ['placeholder' => "Enter New Password Again", 'class' => 'border-0 shadow-md mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('password_confirmation') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                            </div>
                            {!! Form::submit('Change Password', ['name' => 'update_form','class' => 'col-span-6 cursor-pointer text-sm mt-2 font-medium font-semibold w-max block text-center py-2 px-6 border-r  bg-primary text-white rounded-md ']); !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div x-show="is_open('cards')" class="col-span-8 md:col-span-5 lg:col-span-4">
                        <div class="flex flex-col justify-center m-auto gap-5">
                            <div class="col-span-6">
                                <p class="text-left font-bold text-xl text-gray-800 mb-3">Update default payment method</p>
                            </div>
                            @if(auth('person')->user()->defaultPaymentMethod())
                                <div class="w-96 h-56 bg-red-100 rounded-xl relative text-white shadow-2xl transition-transform transform hover:scale-105">
                                    <img class="relative object-cover w-full h-full rounded-xl" src="https://i.imgur.com/kGkSg1v.png">

                                    <div class="w-full px-8 absolute top-8">
                                        <div class="flex justify-between">
                                            <div class="">
                                                <p class="font-light">
                                                    Name
                                                    </h1>
                                                <p class="font-medium tracking-widest">
                                                    {{auth('person')->user()->defaultPaymentMethod()->billing_details->name}}
                                                </p>
                                            </div>
                                            @if(auth('person')->user()->defaultPaymentMethod()->card->brand === 'visa')
                                                <img class="w-14 h-14" src="{{asset('img/placeholder/visa-brand.png')}}"/>
                                            @elseif(auth('person')->user()->defaultPaymentMethod()->card->brand === 'mastercard')
                                                <img class="w-14 h-14" src="{{asset('img/placeholder/mastercard-brand.png')}}"/>
                                            @else
                                                <img class="w-14 h-14" src="{{asset('img/placeholder/card-brand-placeholder.png')}}"/>
                                            @endif
                                        </div>
                                        <div class="pt-1">
                                            <p class="font-light">
                                                Card Number
                                                </h1>
                                            <p class="font-medium tracking-more-wider">
                                                ****  ****  ****  {{auth('person')->user()->defaultPaymentMethod()->card->last4}}
                                            </p>
                                        </div>
                                        <div class="pt-6 pr-6">
                                            <div class="flex justify-between">
                                                <div class="">
                                                    <p class="font-light text-xs">
                                                        Valid
                                                        </h1>
                                                    <p class="font-medium tracking-wider text-sm">
                                                        {{auth('person')->user()->defaultPaymentMethod()->card->exp_month}}/{{auth('person')->user()->defaultPaymentMethod()->card->exp_year}}
                                                    </p>
                                                </div>
                                                <div class="">
                                                    <p class="font-light text-xs">
                                                        Expiry
                                                        </h1>
                                                    <p class="font-medium tracking-wider text-sm">
                                                        {{auth('person')->user()->defaultPaymentMethod()->card->exp_month}}/{{auth('person')->user()->defaultPaymentMethod()->card->exp_year}}
                                                    </p>
                                                </div>

                                                <div class="">
                                                    <p class="font-light text-xs">
                                                        CVV
                                                        </h1>
                                                    <p class="font-bold tracking-more-wider text-sm">
                                                        ***
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                            <div class="col-span-6 mt-5">
                                {!! Form::label('card_name', 'Cardholder name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                {!! Form::text('card_name', old('type_id'), ['id' => 'card-holder-name', 'placeholder' => 'Enter the cardholder\'s name','class' => 'mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                @error('card_name')
                                <div class="text-xs text-red-700 text-left">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="card-element" class="col-span-6 px-2 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base"></div>

                            <div class="text-xs text-red-700 text-left" id="error-box"></div>
                            <button id="card-button" class="font-semibold w-max block text-center py-2 px-6 border-r  bg-primary text-white rounded-md ">
                                Save as default card
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function menuClick(){
            return {
                currentmenu : 'profile',
                change(vars){
                    this.currentmenu = vars
                },
                is_open(vars){
                    return this.currentmenu === vars
                },
                init() {
                    const url = new URL(window.location.href);
                    const tab = url.searchParams.get('tab');
                    if(tab) {
                        this.currentmenu = tab;
                    }
                }
            }
        }
    </script>
    <script>
        const stripe = Stripe('{{config('services.stripe.key')}}');

        const elements = stripe.elements();
        const cardElement = elements.create('card',{
            hidePostalCode: true,
            style: {
                base: {
                    iconColor: '#666EE8',
                    color: '#31325F',
                    lineHeight: '40px',
                    fontWeight: 300,
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSize: '15px',

                    '::placeholder': {
                        color: '#CFD7E0',
                    },
                },
            }
        });

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const errorBox = document.getElementById('error-box');

        cardButton.addEventListener('click', async (e) => {
            if(cardHolderName.value === '')
            {
                errorBox.innerHTML = 'Please enter the cardholder name';
                return;
            }
            const { paymentMethod, error } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: { name: cardHolderName.value }
                }
            );

            if (error) {
                errorBox.innerHTML = error.message;
            } else {
                errorBox.innerHTML = '';
                const url = '{{route('person.cards.update')}}';
                const options = {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_method: paymentMethod,
                    })
                };

                fetch(url, options)
                    .then(async response => {
                        let data = await response.json();

                        if(response.status !== 200)
                        {
                            throw new Error(data.error)
                        }
                    })
                    .then(data => {
                        let event = new CustomEvent('notice', {
                            detail: {
                                'type' : 'success',
                                'text': 'Payment method updated successfully!'
                            }});

                        window.dispatchEvent(event);
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    })
                    .catch((error) => {
                        //handle additional actions and new payment method
                        errorBox.innerHTML =  error.message;
                    });
            }
        });
    </script>
@endsection
