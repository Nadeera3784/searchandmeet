@extends('layouts.auth')

@section('content')
    @inject('domainDataService', 'App\Services\Domain\DomainDataService')
    <section>
        <div class="flex items-center w-screen h-screen relative overflow-hidden">
            <div  class="absolute inset-0 object-fit h-full w-full z-0 overflow-visible" style="z-index: -1;">
                <div class="relative inset-0 object-cover h-full w-full bg opacity-40" style="z-index: 1;">
                </div>
                <img src="/img/Login-right.png" class="absolute left-0 top-1/2 w-1/3 rotate-0 transform -translate-y-1/2  transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >

                {{-- <img src="/img/Signup-left.png" class="absolute left-0 bottom-1/2  w-1/3 transform translate-y-1/2 transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" > --}}
                <img src="/img/Signup-right.png" class="absolute right-0 top-1/2 w-1/3 transform -translate-y-1/2  transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >
            </div>
            <div class="flex flex-col w-full md:w-96 px-10 md:px-0 mx-auto justify-center relative ">
                <div class="flex items-center justify-center mb-3 relative">
                    @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                        <img src="{{asset('img/meetco-logo.png')}}" class="h-20 filter  drop-shadow-md saturate-150" alt="">
                    @else
                        <img src="{{asset('./img/logo.svg')}}" class="h-20 filter  drop-shadow-md saturate-150" alt="">
                    @endif
                </div>
                <div class="text-center p-0 mt-4  font-sans">
                    <h1 class=" text-gray-600 text-2xl md:text-3xl  font-primary tracking-wider">Create an account</h1>
                </div>
                {!! Form::open(['route' => 'person.register']) !!}
                    @csrf
                    <div class="flex flex-col gap-3 mt-4">
                        <div>
                            {!! Form::label('name', 'Full name', ['class' => 'block text-xs font-medium text-gray-500 required mb-1 required']); !!}
                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'block w-full text-base md:text-sm rounded px-4 py-2 text-gray-700 bg-white border-0 shadow-md border-gray-300  dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring' , 'placeholder' => 'Name (Required)']); !!}
                            @error('name') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            {!! Form::label('email', 'Email address', ['class' => 'block text-xs font-medium text-gray-500 required mb-1 required']); !!}
                            {!! Form::email('email', null, ['id' => 'email', 'class' => 'block w-full text-base md:text-sm rounded px-4 py-2 text-gray-700 bg-white border-0 shadow-md border-gray-300  dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring' , 'placeholder' => 'Email (Required)']); !!}
                            @error('email') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="flex-col items-center gap-2">
                            {!! Form::label('phone_number', 'Phone number', ['class' => 'block text-xs font-medium text-gray-500 mb-1']); !!}
                            <div class="flex">
                                <div class="w-1/3">
                                    {!! Form::select('phone_code_id', $phoneCodes, null, ['class' => 'select2   px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'placeholder' => '--']); !!}
                                </div>
                                {!! Form::text('phone_number', null, ['class' => 'block w-2/3 rounded px-4 py-2 text-base md:text-sm text-gray-700 bg-white border-0 shadow-md border-gray-300  dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring', 'placeholder' => 'Phone number']); !!}

                            </div>
                            @error('phone_code_id') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                            @error('phone_number') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            {!! Form::label('languages', 'Preferred languages', ['class' => 'block text-xs font-medium text-gray-500 required mb-1']); !!}
                            {!! Form::select('languages[]', $languages, old('languages'), ['multiple'=> 'multiple','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                            @error('languages') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            {!! Form::label('looking_for', 'Who are you looking to meet', ['class' => 'block text-xs font-medium text-gray-500 required mb-1']); !!}
                            {!! Form::select('looking_for', \App\Enums\ProspectType::asSelectArray(), old('looking_for'), ['placeholder' => 'Who are you looking to meet (Required)','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                            @error('looking_for') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            @component('components.categorySearch', ['label' => 'What products are you looking for?'])
                                @slot('labelClass')
                                    block text-xs font-medium text-gray-500 required mb-1
                                @endslot
                                @slot('selectClass')
                                    mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base
                                @endslot
                            @endcomponent
                            @error('category_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                        </div>

                        <div >
                            {!! Form::label('timezone_id', 'Timezone', ['class' => 'block text-xs font-medium text-gray-500 required mb-1']); !!}
                            {!! Form::select('timezone_id', $timezones, old('timezone_id'), ['required' => 'required', 'placeholder' => 'Your timezone (Required)','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                            @error('timezone_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                        </div>

                        <div >
                            <label class="inline-flex items-center text-sm">
                                <input type="checkbox" name="policy_check" class="form-checkbox h-5 w-5 text-gray-600 outline-none cursor-pointer">
                                <span class="ml-3 text-gray-700 leading-1">
                                    I have read and accept the
                                    <a class="font-bold text-gray-600 hover:text-gray-800" target="_blank" href="{{route('policy.terms')}}">Terms & conditions</a>
                                    and the
                                     <a class="font-bold text-gray-600 hover:text-gray-800" target="_blank" href="{{route('policy.terms')}}">Privacy policy</a>
                                </span>
                            </label>
                            @error('policy_check') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                        </div>

                        <div >
                            <label class="inline-flex items-center text-sm">
                                <input type="checkbox" name="opt_in_marketing" class="form-checkbox h-5 w-5 text-gray-600 outline-none cursor-pointer">
                                <span class="ml-3 text-gray-700 leading-none">
                                   Subscribe to marketing and promotional emails?
                                </span>
                            </label>
                        </div>

                        <div class="mt-3">
                            {!! Form::submit('Sign Up', ['class' => ' shadow-md w-full px-4 py-2 font-semibold rounded cursor-pointer tracking-wide text-white transition-colors duration-200 transform bg-primary hover:bg-primary_hover focus:outline-none focus:primary_hover']); !!}
                        </div>
                    {!! Form::close() !!}
                    <div class="mt-2 text-center ">
                        <a class="" href="/login" data-test="Link"><span class="text-blue-600 text-sm">Already have an account?</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
