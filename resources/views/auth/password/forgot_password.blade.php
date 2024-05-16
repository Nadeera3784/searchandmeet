@extends('layouts.app')

@section('content')
    <div class="shadow h-full w-full">
            <div class="flex justify-center items-center w-full min-h-screen h-screen pt-20 px-8 relative overflow-hidden">
                <div  class="absolute inset-0 object-fit h-full w-full z-0 overflow-visible" style="z-index: -1;">
                    <div class="relative inset-0 object-cover h-full w-full bg opacity-40" style="z-index: 1;">
                    </div>
                    <img src="/img/Login-left.png" class=" absolute left-0 bottom-1/2  w-1/3 transform translate-y-1/2 transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >
                    <img src="/img/Login-right.png" class=" absolute right-0 top-1/2 w-1/3 transform -translate-y-1/2  transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >
                </div>
                <div class="py-3 rounded text-center flex flex-col w-full md:w-96  justify-center items-center gap-2 relative">
                    <h1 class="text-2xl font-bold">Forgot password</h1>
                    <div>
                        <span>Enter your email to receive a password reset link</span> <br>
                        <span class="text-xs text-black-100">You will only receive a link if the email submitted has an account within the system</span>
                    </div>
                    <form action="{{route('person.password.reset_link')}}" method="POST"  class="flex flex-col justify-center items-center gap-2 relative w-full">
                        @csrf
                        <div class="flex flex-col space-y-4 p-4 w-full">
                            <div class="w-full">
                                {!! Form::email('email', old('email'), ['placeholder' => 'Email Address', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('email') <div class="text-xs text-red-700 text-left mt-2">{{ $message }}</div> @enderror
                            </div>
                            <button type="submit" class="text-white bg-primary hover:bg-primary_hover cursor-pointer font-bold p-2 rounded"> Get reset link </button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection
