@extends('layouts.admin')
@section('content')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                	<h1 class="text-xl font-bold text-gray-500">
				    	{{ __('Matchmaking') }}
				  	</h1>
                </div>
                <a href="{{route('agent.matchmaking.create')}}" class="mx-1 bg-blue-200 hover:bg-blue-800 flex items-center text-blue-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg> Add New
                </a>
            </div>
            <div class="flow-root my-3">
                <div class="flex-col">
                    <div class="flex">
                        <span>Search by</span>
                    </div>
                    {!! Form::open(['url' => route('agent.matchmaking.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

                    <div class="flex-col w-96">
                        @component('components.peopleSearch')
                            @slot('nativeSelection')
                                true
                            @endslot
                            @slot('personID')
                                null
                            @endslot
                            @slot('labelClass')
                                block text-sm font-medium text-gray-700 required
                            @endslot
                            @slot('selectClass')
                                mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md
                                shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                                md:text-sm text-base
                            @endslot
                        @endcomponent
                    </div>
                    <div class="flex-col">
                        {!! Form::label('type', 'Type', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('type', \App\Enums\Matchmaking\MatchTypes::asSelectArray(), request()->get('type'), ['placeholder' => 'Select By Type','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'x-model' => "formData.source"]) !!}
                    </div>
                    <div>
                        {!! Form::submit('Search', ['class' => 'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
                        <a href="{{route('agent.matchmaking.index')}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm" >
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" >
                                @if($matches->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                ID
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Items
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Person
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Initiated By
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Notification Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                               Created on
                                            </th>
                                            <th scope="col" class="relative px-3 py-3">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($matches as $match)
                                            <tr>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{ $match->getRouteKey()}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap">
                                                    <div class="flex items-center flex-col">
                                                        <a href="{{route('agent.matchmaking.show', $match->getRouteKey())}}" class="bg-green-600 hover:bg-green-700 rounded text-white px-3 py-1 cursor-pointer">View matches</a>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <a target="_blank" href="{{route('agent.people.show', $match->person->getRouteKey())}}" class="truncate w-20 px-2 hover:bg-blue-800 hover:text-white inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
                                                        {{$match->person->name}}  {{$match->person->email}}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{ \App\Enums\Matchmaking\MatchTypes::getDescription($match->type)}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500 capitalize">
                                                    {{$match->initiator}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500 flex flex-col gap-2">
                                                    {{$match->notification_status === 0 ? 'Not sent' : 'Sent'}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <p class="text-sm my-2"><span>{{$timezoneService->localTime(auth('agent')->user(), $match->created_at, 'd M Y h:i A')}}</span> </p>

                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap text-right text-xs font-medium flex flex-row">
                                                    <form action="{{route('agent.matchmaking.destroy', $match->getRouteKey())}}" class="inline-flex " method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure want to delete this record?')" class="items-center px-2 py-1 ml-1 text-xs text-red-800 font-medium hover:text-red-100 transition-colors duration-150 bg-red-200 rounded focus:shadow-outline hover:bg-red-500">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                </table>
                                @else
                                    <div class="h-16 p-10 flex justify-center items-center">
                                        <span class="text-md italic text-gray-500">No matches to show</span>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="mt-2">
                {{$matches->links()}}
            </div>
        </div>
    </div>

    <script>

    </script>
@endsection