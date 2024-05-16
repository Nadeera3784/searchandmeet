<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="/css/app.css"/>

    <link rel="icon" href="img/favicon.svg" sizes="any" type="image/svg+xml">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js"></script>

    <title>Search Meetings - Agent</title>
</head>
<body class="my-auto w-full text-sm">
@include('components.toaster')
    <div class="grid grid-cols-12">
        <div class="fixed top-5 right-10 h-5 w-5 z-20">
            <div x-data="{ dropdownOpen: false }" class="relative" x-cloak="">
                <button @click="dropdownOpen = !dropdownOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                    <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 h-full w-full z-10"></div>

                <div x-show="dropdownOpen" class="absolute right-0 mt-2 bg-white rounded-md shadow-lg overflow-hidden z-20" style="width:20rem;">
                    <div class="pt-2">

                        @if(auth('agent')->check())
                            @if(auth('agent')->user()->notifications->count() > 0)
                                @foreach(auth('agent')->user()->notifications as $notification)
                                    @switch($notification->type)
                                        @case(\App\Notifications\MeetingCreated::class)
                                        <a href="#" class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-600 text-sm mx-2">
                                                <span class="font-bold">You have a new </span> <span class="font-bold text-blue-500">meeting</span> related to  <span class="font-bold text-blue-500">order</span>
                                            </p>
                                        </a>
                                        @break
                                        @default
                                        <a href="#" class="flex items-center px-4 py-3 border-b hover:bg-gray-100 -mx-2">
                                            <img class="h-8 w-8 rounded-full object-cover mx-1" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="avatar">
                                            <p class="text-gray-600 text-sm mx-2">
                                                <span class="font-bold" href="#">Sara Salah</span> replied on the <span class="font-bold text-blue-500" href="#">Upload Image</span> artical . 2m
                                            </p>
                                        </a>
                                        @break
                                    @endswitch
                                @endforeach
                            @else
                                <p class="text-gray-600 text-sm mx-2 my-2 text-center">
                                    No notifications to show
                                </p>
                            @endif
                        @endif
                    </div>
                    <a href="#" class="block bg-gray-800 text-white text-center font-bold py-2">See all notifications</a>
                </div>
            </div>
        </div>

        <aside class="col-span-4 bg-gray-50 h-screen w-64 z-10">
            <div class="flex justify-start items-center my-3 mb-5 mx-6 relative">
                <img src="/img/logo.svg" alt="Logo" class="h-10 filter  drop-shadow-md saturate-100">
            </div>
            <div class="my-3">
                <div class="flex flex-row items-center overflow-hidden rounded px-6 py-2">
                    <div class="min-w-max ">
                        <span class="w-10 h-10 rounded-full shadow-md bg-{{\Illuminate\Support\Facades\Session::get('user_color', 'gray')}}-500 text-white font-bold text-lg leading-none flex items-center justify-center">{{\Illuminate\Support\Facades\Session::get('user_initials', 'A')}}</span>
                    </div>

                    <div class="flex flex-col items-start justify-center  ml-3 truncate leading-4">
                        <h4 class=" text-md font-bold  cursor-default text-red-600 dark:text-gray-200">{{ auth('agent')->user()->name}}</h4>
                        <p class=" font-medium cursor-pointer text-gray-600 dark:text-gray-400 hover:underline" style="font-size: 0.8rem">{{ auth('agent')->user()->email}}</p>
                        <span style="font-size: 0.8rem">{{ucfirst(auth('agent')->user()->role->key)}}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col justify-between flex-1 mt-0">
                <nav>
                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.dashboard') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.dashboard')}}">
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                      </svg>

                        <span class="mx-4 font-medium">Dashboard</span>
                    </a>

                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.communication.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.communication.messages')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>

                        <span class="mx-4 font-medium">Communications</span>
                    </a>
                    @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.purchase_requirements.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.purchase_requirements.index')}}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Requirements</span>
                    </a>
                    @endif
                    @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
                        <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.packages.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                           href="{{route('agent.packages.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>

                            <span class="mx-4 font-medium">Packages</span>
                        </a>
                    @endif
                    @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
                        <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.meeting_requests.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                           href="{{route('agent.meeting_requests.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>

                            <span class="mx-4 font-medium">Requests</span>
                        </a>
                    @endif
                    @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
                        <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.matchmaking.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                           href="{{route('agent.matchmaking.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>

                            <span class="mx-4 font-medium">Matchmaking</span>
                        </a>
                    @endif
                    @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.people.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.people.index')}}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">People</span>
                    </a>
                    @endif
                    @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.order.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.order.index')}}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Orders</span>
                    </a>
                    @endif
                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.meetings.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.meetings.index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>

                        <span class="mx-4 font-medium">Meetings</span>
                    </a>
                    @if(auth('agent')->check() && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.claims.*') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.leads.index')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="mx-4 font-medium">Leads</span>
                    </a>
                    @endif
                    @if(auth('agent')->user()->role->value == \App\Enums\Agent\AgentRoles::admin)
                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.users.index') && request()->get('type') === 'agents' ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{route('agent.users.index', ['type' => 'agents'])}}">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <span class="mx-4 font-medium">Agents</span>
                    </a>
                    @endif
                    @if(auth('agent')->user()->role->value == \App\Enums\Agent\AgentRoles::admin)
                        <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.users.index') && request()->get('type') === 'translators' ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                           href="{{route('agent.users.index', ['type' => 'translators'])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>

                            <span class="mx-4 font-medium">Translators</span>
                        </a>
                    @endif

                    @if(auth('agent')->user()->role->value == \App\Enums\Agent\AgentRoles::admin)
                        <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.users.index') && request()->get('type') === 'support' ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                           href="{{route('agent.users.index', ['type' => 'support'])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>

                            <span class="mx-4 font-medium">Support team</span>
                        </a>
                    @endif
                    @if(auth('agent')->user()->role->value == \App\Enums\Agent\AgentRoles::admin)
                        <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('admin.settings') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                           href="{{ route('admin.settings') }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.3246 4.31731C10.751 2.5609 13.249 2.5609 13.6754 4.31731C13.9508 5.45193 15.2507 5.99038 16.2478 5.38285C17.7913 4.44239 19.5576 6.2087 18.6172 7.75218C18.0096 8.74925 18.5481 10.0492 19.6827 10.3246C21.4391 10.751 21.4391 13.249 19.6827 13.6754C18.5481 13.9508 18.0096 15.2507 18.6172 16.2478C19.5576 17.7913 17.7913 19.5576 16.2478 18.6172C15.2507 18.0096 13.9508 18.5481 13.6754 19.6827C13.249 21.4391 10.751 21.4391 10.3246 19.6827C10.0492 18.5481 8.74926 18.0096 7.75219 18.6172C6.2087 19.5576 4.44239 17.7913 5.38285 16.2478C5.99038 15.2507 5.45193 13.9508 4.31731 13.6754C2.5609 13.249 2.5609 10.751 4.31731 10.3246C5.45193 10.0492 5.99037 8.74926 5.38285 7.75218C4.44239 6.2087 6.2087 4.44239 7.75219 5.38285C8.74926 5.99037 10.0492 5.45193 10.3246 4.31731Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <span class="mx-4 font-medium">System settings</span>
                        </a>
                    @endif

                    <a class="flex rounded items-center border-l-4 border-gray-100 hover:border-indigo-500 my-1 px-5 py-2 {{request()->routeIs('agent.profile') ? 'text-gray-700 bg-gray-200 border-indigo-500' : 'text-gray-600'}} transition-colors duration-200 transform dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 dark:hover:text-gray-200 hover:text-gray-700"
                       href="{{ route('agent.profile') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>

                        <span class="mx-4 font-medium">Account</span>
                    </a>
                    <a class="flex rounded items-center justify-center m-6 px-3 py-2 text-white shadow-md bg-indigo-500 transition-colors duration-200 transform dark:text-gray-400 hover:bg-indigo-600 hover:shadow-md "
                        href="{{ route('agent.logout') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>

                        <span class="ml-1 font-medium">Logout</span>
                    </a>
                </nav>
            </div>
        </aside>


        <div class="col-span-4 absolute px-4  w-full pr-10 overflow-x-auto h-screen">

            <div class="bg-white ml-64  mt-5">
            @yield('content')
        </div>

        </div>

    </div>
    <script type="text/javascript" src="{{'/js/app.js'}}"></script>
    @yield('custom-js')
    @stack('bottom-scripts')
</body>
</html>
