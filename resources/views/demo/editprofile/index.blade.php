@extends('layouts.app')

@section('content')
<div class="bg-gray-50 pb-8">
    <div class="container mx-auto md:w-4/5 md:px-0 px-5 pt-28 relative">
        <div class="grid grid-cols-8 gap-x-0 bg-white shadow-md border-gray-200 rounded-md " x-data="menuClick()">
            <div class="col-span-8 md:col-span-2 py-6 bg-gray-100">
                <p class="px-6 text-left font-bold text-xl text-gray-800 mb-3">Profile Details</p>
                <li class="flex">
                    <div @click="change('Profile')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white': is_open('Profile') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                          </svg>
                        <span class="ml-2">Profile</span>
                    </div>
                </li>
                <li class="flex">
                    <div @click="change('Bills')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white': is_open('Bills') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                          </svg>
                        <span class="ml-2">Bills</span>
                    </div>
                </li>
                <li class="flex">
                    <div @click="change('Payment')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white': is_open('Payment') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                          </svg>
                        <span class="ml-2">Payment</span>
                    </div>
                </li>
                <li class="flex">
                    <div @click="change('Reset')" class="cursor-pointer inline-flex items-center w-full px-6 py-3 text-sm font-semibold hover:bg-gray-50 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200" :class="{ 'bg-white': is_open('Reset') }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                          </svg>
                        <span class="ml-2">Reset Password</span>
                    </div>
                </li>
            </div>
            <div class="grid grid-cols-8 col-span-8 md:col-span-6 p-6 px-8 pb-10">
                <div x-show="is_open('Profile')" class="col-span-8 md:col-span-5 lg:col-span-4">
                    {!! Form::open() !!}
                    <div class="grid grid-cols-6 gap-5 rounded-lg">
                        <div class="col-span-6">
                            <p class="text-left font-bold text-xl text-gray-800 mb-1">Profile Details</p>
                        </div>
                        <div class="col-span-6">
                            {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('name', old('name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            @error('name') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-6">
                            {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('email', old('email'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            @error('email') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                        </div>

                        {!! Form::submit('Save', ['class' => 'col-span-6 cursor-pointer text-sm mt-2 font-medium font-semibold w-max block text-center py-2 px-6 border-r  bg-primary text-white rounded-sm ']); !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div x-show="is_open('Bills')" class="col-span-8 md:col-span-5 lg:col-span-4">
                    {!! Form::open(['url' => route('users.profile.update')]) !!}
                    <div class="grid grid-cols-6 gap-5 rounded-lg">
                        <div class="col-span-6">
                            <p class="text-left font-bold text-xl text-gray-800 mb-1">Bill Details</p>
                        </div>

                        {!! Form::submit('Save', ['class' => 'col-span-6 cursor-pointer text-sm mt-2 font-medium font-semibold w-max block text-center py-2 px-6 border-r  bg-primary text-white rounded-sm ']); !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div x-show="is_open('Payment')" class="col-span-8 md:col-span-5 lg:col-span-4">
                    {!! Form::open(['url' => route('users.profile.update')]) !!}
                    <div class="grid grid-cols-6 gap-5 rounded-lg">
                        <div class="col-span-6">
                            <p class="text-left font-bold text-xl text-gray-800 mb-1">Payment Details</p>
                        </div>

                        {!! Form::submit('Save', ['class' => 'col-span-6 cursor-pointer text-sm mt-2 font-medium font-semibold w-max block text-center py-2 px-6 border-r  bg-primary text-white rounded-sm ']); !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                <div x-show="is_open('Reset')" class="col-span-8 md:col-span-5 lg:col-span-4">
                    {!! Form::open(['url' => route('users.profile.update')]) !!}
                    <div class="grid grid-cols-6 gap-5 rounded-lg">
                        <div class="col-span-6">
                            <p class="text-left font-bold text-xl text-gray-800 mb-3">Change Password</p>
                        </div>
                        <div class="col-span-6">
                            {!! Form::label('old_password', 'Old Password', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::password('old_password', ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            @error('old_password') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-span-6">
                            {!! Form::label('password', 'New Password', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::password('password', ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            @error('password') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-span-6">
                            {!! Form::label('password_confirmation', 'Confirm New Password', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::password('password_confirmation', ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            @error('password_confirmation') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                        </div>
                        {!! Form::submit('Change Password', ['class' => 'col-span-6 cursor-pointer text-sm mt-2 font-medium font-semibold w-max block text-center py-2 px-6 border-r  bg-primary text-white rounded-sm ']); !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-50  pb-8 hidden">
    <div class="container mx-auto md:w-4/5 md:px-0 px-5 pt-28 relative">
        <div class="grid grid-cols-8 md:gap-x-20 gap-y-5">
            <div class="col-span-8 md:col-span-4">
                {!! Form::open(['url' => route('users.profile.update')]) !!}
                <div class="grid grid-cols-6 gap-5 rounded-lg mt-5  bg-white shadow-md border-gray-200">
                    <div class="col-span-6">
                        <p class="text-left font-bold text-xl text-gray-800 mb-3">Profile Details</p>
                    </div>
                    <div class="col-span-6">
                        {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('name', old('name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                        @error('name') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-span-6">
                        {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('email', old('email'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                        @error('email') <div class="text-xs text-red-700">{{ $message }}</div> @enderror
                    </div>

                    {!! Form::submit('Update', ['class' => 'col-span-6 cursor-pointer text-sm mt-5 font-medium font-semibold w-full block text-center py-3 border-r  bg-primary text-white rounded-sm ']); !!}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>

<script>
    function menuClick(){
        return {
            currentmenu : 'Profile',
            change(vars){
                this.currentmenu = vars
            },
            is_open(vars){
                console.log(this.currentmenu,vars)
                return this.currentmenu === vars
            }
        }
    }
</script>
@endsection
