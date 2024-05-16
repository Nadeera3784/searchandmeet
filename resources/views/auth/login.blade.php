@extends('layouts.auth')

@section('content')
    @inject('domainDataService', 'App\Services\Domain\DomainDataService')
    <section>
        <div class="flex items-center w-screen h-screen relative overflow-hidden">
            <div  class="absolute inset-0 object-fit h-full w-full z-0 overflow-visible" style="z-index: -1;">
                <div class="relative inset-0 object-cover h-full w-full bg opacity-40" style="z-index: 1;">
                </div>
                <img src="/img/Login-left.png" class=" absolute left-0 bottom-1/2  w-1/3 transform translate-y-1/2 transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >
                <img src="/img/Login-right.png" class=" absolute right-0 top-1/2 w-1/3 transform -translate-y-1/2  transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >
            </div>
            <div class="flex flex-col w-full md:w-96 px-10 md:px-0 mx-auto justify-center relative transform ">
                <div class="flex items-center justify-center mb-3 relative">
                    @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                        <img src="{{asset('img/meetco-logo.png')}}" class="h-20 filter  drop-shadow-md saturate-150" alt="">
                    @else
                        <img src="{{asset('./img/logo.svg')}}" class="h-20 filter  drop-shadow-md saturate-150" alt="">
                    @endif
                </div>
                <div class="text-center p-0 mt-4  font-sans">
                    <h1 class=" text-gray-600 text-2xl md:text-3xl  font-primary tracking-wider">Welcome back!</h1>
                </div>
                {!! Form::open(['route' => 'person.login']) !!}
                    @csrf
                    <div class="flex flex-col space-y-4">
                        <div class="mt-4">
                            {!! Form::email('email', null, ['id' => 'email', 'class' => ' shadow-md block w-full px-4 py-2 text-gray-700 bg-white border-0 border-gray-300 rounded dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring-0' , 'placeholder' => 'Email']); !!}
                            @error('email') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mt-4">
                            {!! Form::password('password', ['id' => 'password', 'class' => ' shadow-md block w-full px-4 py-2 text-gray-700 bg-white border-0 border-gray-300 rounded dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring-0' , 'placeholder' => 'Password']); !!}
                            @error('password') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="pt-4">
                            {!! Form::submit('Sign In', ['class' => ' shadow-md w-full px-4 py-2 font-semibold rounded cursor-pointer tracking-wide text-white transition-colors duration-200 transform bg-primary hover:bg-primary_hover focus:outline-none focus:primary_hover']); !!}
                        </div>
                        @error('error') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                    </div>
                {!! Form::close() !!}
                <div class="mt-2 text-center ">
                    <a class="" href="/register" data-test="Link"><span class="text-blue-600 text-sm">Create an new account?</span></a>
                </div>
                <div class="mt-2 text-center">
                    <a class="" href="{{route('person.password.forgot')}}" data-test="Link"><span class="text-blue-600 text-sm">Forgot password</span></a>
                </div>
            </div>
        </div>
    </section>
@endsection
