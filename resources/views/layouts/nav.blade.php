@inject('cartService', 'App\Services\Cart\CartService')
<nav id="navbar" class="absolute top-0 left-0 z-30 w-full h-20 transition duration-300 ease-in-out bg-white dark:bg-gray-800">
    <div class="container flex items-center justify-between px-6 mx-auto h-full">
        <div class="flex items-center">
            <a class="text-xl font-bold text-gray-800 dark:text-white lg:text-2xl hover:text-gray-700 dark:hover:text-gray-300" href="{{route('home')}}">
                @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                    <img src="{{asset('img/meetco-logo.png')}}" class="h-11" alt="logo">
                @else
                    <img src="/img/logo.svg" alt="Logo" class="h-11 ">
                @endif
            </a>
        </div>


        <div class="flex items-center" x-data="{showWatchlist : false,showProfile : false, showMenu : false}" @click.away="showMenu = false ">
                <div @click.prevent="showMenu = !showMenu " class="p-2 hover:bg-gray-200 cursor-pointer lg:hidden block " >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <div class="overflow-hidden bg-gray-100 lg:overflow-visible lg:h-full h-0 flex flex-col lg:flex-row lg:items-center gap-x-6 absolute h-max left-0 bottom-0 transform translate-y-full lg:translate-y-0 lg:bg-white lg:relative w-full transition-all duration-200 ease-in-out " style="z-index:900;" x-bind:style="showMenu ? 'height:max-content' : 'height:0px'">
                    {{-- <a class="py-3 lg:py-0 px-9 lg:px-0 text-base font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400  {{ request()->routeIs('purchase_requirements.search') ? "text-pink-500" : "" }}" href="{{route('purchase_requirements.search')}}">Search</a> --}}
                    {!! Form::open(['url' => route('purchase_requirements.search'), 'method' => 'get','class' => 'lg:w-max w-full px-9 pr-36 lg:px-0 lg:mt-0']) !!}
                        <div class="relative w-full lg:w-96 py-3 lg:py-0">
                            {!! Form::text('keyword', old('keyword'), ['class' => 'block w-full bg-white  text-md p-2 px-3 pr-10  rounded border border-gray-100 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md', 'placeholder' => 'Search Meetings']) !!}
                            <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 text-gray-500 focus:outline-none focus:ring-0 focus:border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    {!! Form::close() !!}
                    @if(!auth()->guard('person')->check())
                        <a class="py-3 lg:py-0 px-9 lg:px-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400 {{ request()->routeIs('person.login.show') ? "text-pink-500" : "" }}" href="{{ route('person.login.show') }}">Login</a>
                        <a class="py-3 lg:py-0 px-9 lg:px-0 pb-5 lg:pb-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400 {{ request()->routeIs('person.register.show') ? "text-pink-500" : "" }}" href="{{ route('person.register.show') }}">Register</a>
                        {{-- <div @click="$dispatch('click-contact', '')" class="py-3 px-9 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary lg:hover:text-white hover:border-primary lg:hover:bg-primary dark:hover:text-red-400 lg:border border-gray-700 lg:px-5 lg:py-2 transition-all duration-150 ease-in-out cursor-pointer">Contact Us</div> --}}
                        <div id="inquiry-container"></div>
                    @else
                        <a class="py-3 lg:py-0 px-9 lg:px-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400  {{ request()->routeIs('home') ? "text-pink-500" : "" }}" href="/">Home</a>
                        <a class="py-3 lg:py-0 px-9 lg:px-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400  {{ request()->routeIs('person.dashboard') ? "text-pink-500" : "" }}" href="{{route('person.dashboard')}}">Dashboard</a>
                        <a class="py-3 lg:py-0 px-9 lg:px-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400  {{ request()->routeIs('person.schedule.show') ? "text-pink-500" : "" }}" href="{{route('person.schedule.show')}}">Availability</a>
                        <a class="py-3 lg:py-0 px-9 lg:px-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400 {{ request()->routeIs('person.purchase_requirements.index') ? "text-pink-500" : "" }}" href="{{route('person.purchase_requirements.index')}}">Requirements</a>
                        <a class="py-3 lg:py-0 px-9 lg:px-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400  {{ request()->routeIs('person.orders.index') ? "text-pink-500" : "" }}" href="{{ route('person.orders.index') }}">Contacts</a>
                        <a class="py-3 lg:py-0 px-9 lg:px-0 pb-5 lg:pb-0 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary dark:hover:text-red-400  {{ request()->routeIs('person.meetings.index') ? "text-pink-500" : "" }}" href="{{ route('person.meetings.index') }}">Meetings</a>
                        <div class="absolute top-4 lg:top-0 right-0 lg:relative pb-5 lg:pb-0 px-9 lg:px-0 flex flex-row-reverse lg:flex-row items-center gap-5">
                            <div class="relative" @click.away="showProfile = false">
                                <div class="relative h-full w-full">
                                    <div class="">
                                        <button @click="showProfile=!showProfile" type="button" class="max-w-xs rounded-full flex items-center text-sm focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                            <div class="w-10 h-10 relative flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Facades\Session::get('user_color', 'gray')}}-500 text-s text-white uppercase">{{\Illuminate\Support\Facades\Session::get('user_initials', 'U')}}</div>
                                        </button>
                                    </div>

                                    <div x-show="showProfile" class="origin-top-right absolute right-0   mt-2 w-64 max-w-xs rounded-md shadow-lg py-1 bg-white focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                        <!-- Active: "bg-gray-100", Not Active: "" -->
                                        <a href="{{route('person.profile.show')}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" >Your Profile</a>
                                        <a class="block px-4 py-2 text-sm text-gray-700" href="{{ route('person.business.show') }}">Business</a>
                                        <a class="block px-4 py-2 text-sm text-gray-700" href="{{ route('person.billing.show') }}">Billing</a>
                                        <a class="block px-4 py-2 text-sm text-gray-700" href="{{ route('person.logout') }}">Logout</a>
                                    </div>
                                </div>
                            </div>
                            @if(auth('person')->check() && auth('person')->user()->watchList)
                            <div class="relative" @click.away="showWatchlist = false">
                                <button @click="showWatchlist=!showWatchlist" type="button" class="max-w-xs rounded-full flex items-center text-sm focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <div x-show="showWatchlist" class="origin-top-right absolute -right-full mt-2 w-64 max-w-xs rounded-md shadow-lg pt-1 bg-white focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    @if(auth('person')->check() && auth('person')->user()->watchList->items->count() === 0)
                                            <div class="h-15 flex justify-center items-center px-2 py-4">
                                                <span class="text-sm">Your watchlist is empty</span>
                                            </div>
                                        @else
                                        @foreach(auth('person')->user()->watchList->items as $item)
                                            <div class="h-15 px-4 py-2 flex border-b-2 border-gray-100 relative hover:bg-gray-50" x-data="{showRemove: false}" @mouseover="showRemove = true" @mouseout="showRemove = false">
                                                <a href="{{route('purchase_requirements.show', $item->purchase_requirement->getRouteKey())}}">
                                                    <div class="flex-col flex">
                                                        <span class="text-sm capitalize">{{$item->purchase_requirement->product}}</span>
                                                        <span class="text-xs capitalize text-black-200">{{$item->purchase_requirement->category->name}}</span>
                                                    </div>
                                                    <div>
                                                        <form action="{{route('person.watchlist.remove')}}" method="POST"  class="absolute top-4 right-4">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="purchase_requirement_id" value="{{$item->purchase_requirement->id}}" />
                                                            <button x-show="showRemove" type="submit" class="h-6 w-6 max-w-xs rounded-full flex items-center text-sm focus:outline-none text-red-500 stroke-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                            <div class="flex justify-center items-center px-2 py-2 bg-gray-50">
                                                <span class="text-sm">{{auth('person')->user()->watchList->items->count()}} item{{auth('person')->user()->watchList->items->count() > 1 ? 's' : ''}} in list</span>
                                            </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    @endif
                </div>

        </div>
    </div>
</nav>
