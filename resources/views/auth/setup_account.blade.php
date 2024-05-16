@extends('layouts.app')

@section('content')
    <div class="">
            <div class="flex justify-center items-center w-screen min-h-screen h-screen pt-20 relative overflow-hidden">
                <div  class="absolute inset-0 object-fit h-full w-full z-0 overflow-visible" style="z-index: -1;">
                    <div class="relative inset-0 object-cover h-full w-full bg opacity-40" style="z-index: 1;">
                    </div>
                    <img src="/img/Login-left.png" class=" absolute left-0 bottom-1/2  w-1/3 transform translate-y-1/2 transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >
                    <img src="/img/Login-right.png" class=" absolute right-0 top-1/2 w-1/3 transform -translate-y-1/2  transition-opacity duration-150 ease-out opacity-0 md:opacity-50 object-cover" style="z-index: 2;" >
                </div>
                <div class=" py-3 text-center flex flex-col w-full md:w-96 justify-center items-center gap-2">
                    <h1 class="text-2xl font-bold">Setup account</h1>
                    <div><span>Enter new password</span></div>
                    <form action="{{route('person.account.setup', ['token' => request()->get('token')])}}" method="POST"  class="flex flex-col justify-center items-center gap-2">
                        @csrf
                        <div class="flex flex-col space-y-4 p-4">
                            <div>
                                {!! Form::password('password', ['placeholder' => 'Password','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-96 shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                @error('password') <div class="text-xs text-red-700 text-left mt-2">{{ $message }}</div> @enderror
                            </div>
                            <div >
                                {!! Form::password('password_confirmation', ['placeholder' => 'Confirm Password','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-96 shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                            </div>
                            <button type="submit" class="text-white bg-primary hover:bg-primary_hover cursor-pointer font-bold p-2 rounded"> Set password </button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection
