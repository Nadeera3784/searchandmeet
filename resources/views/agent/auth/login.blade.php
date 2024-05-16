@extends('layouts.auth')


@section('content')
    @if (session('success'))
        <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 bg-green-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500 dark:text-green-400">Success</span>
                    <p class="text-sm text-gray-600 dark:text-gray-200">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <section class="w-full max-w-sm p-6 mt-20 m-auto bg-white rounded-md shadow-md dark:bg-gray-800">
        <div class="flex flex-col justify-center items-center text-center">
            <img src="{{asset('./img/Search-Meetings-Logo.png')}}" class="w-40" alt="">
            <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 pb-12 pt-6">Welcome back!</h1>
            
            {!! Form::open(['route' => 'agent.login', 'class'=> 'w-full']) !!}
                <div class="flex justify-between">
                    {!! Form::label('email','Email Address') !!}
                </div>

                <div class="mt-2">
                    {!! Form::email('email',null,  ['id' => 'email', 'class' => 'block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring' , 'placeholder' => 'Email']); !!}

                    @error('email') <div class="text-xs text-red-500 text-left">{{ $message }}</div> @enderror
                </div>

                {{-- @if(request()->query('w') == 'password') --}}
                    <div class="mt-4 flex justify-between">
                        {!! Form::label('password','Password') !!}
                    </div>

                    <div class="mt-2">
                        {!! Form::password('password',  ['id' => 'password', 'class' => 'block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring' , 'placeholder' => 'Password']); !!}

                        @error('password') <div class="text-xs text-red-500 text-left">{{ $message }}</div> @enderror
                    </div>
                {{-- @endif --}}

                <div class="mt-8">
                    {!! Form::submit('Continue', ['class' => 'w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600']); !!}
                </div>

                {{-- <div class="mt-4">
                    @if(request()->query('w') == 'password')
                        <a class="text-sm hover:text-primary" href="{{ route('login') }}">Login with Magic link</a>
                    @else
                        <a class="text-sm hover:text-primary" href="{{ route('login', ['w' => 'password']) }}">Login with Email/Password</a>
                    @endif
                </div> --}}
            {!! Form::close() !!}
        </div>
    </section>
@endsection
