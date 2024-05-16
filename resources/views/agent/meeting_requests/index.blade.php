@extends('layouts.admin')
@section('content')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                	<h1 class="text-xl font-bold text-gray-500">
				    	{{ __('Meeting requests') }}
				  	</h1>
                </div>
            </div>
            <div class="flow-root my-3">
                <div class="flex-col">
                    <div class="flex">
                        <span>Search by</span>
                    </div>
                    {!! Form::open(['url' => route('agent.meeting_requests.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

                    <div class="flex-col">
                        {!! Form::label('status', 'Status', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('status', ['processed' => 'Processed', 'processing' => 'Processing'], request()->get('status'), ['placeholder' => 'Search by status', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>
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
                    <div>
                        {!! Form::submit('Search', ['class' => 'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
                        <a href="{{route('agent.meeting_requests.index')}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                @if($meeting_requests->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Purchase Requirement
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Person
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Custom timeslot available
                                            </th>
                                            @if(auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::agent)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Allocated agent
                                            </th>
                                            @endif
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Submitted On
                                            </th>
                                            <th scope="col" class="relative px-3 py-3">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($meeting_requests as $meeting_request)
                                            <tr>
                                                <td class="px-6 py-3 whitespace-nowrap">
                                                    <div class="flex text-center flex-col">
                                                        <a href="{{route('agent.purchase_requirements.show', $meeting_request->purchase_requirement->getRouteKey())}}" class="truncate w-20 px-2 hover:bg-blue-800 hover:text-white inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
                                                            {{$meeting_request->purchase_requirement->product}}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <a href="{{route('agent.people.show', $meeting_request->person->getRouteKey())}}" class="px-2 inline-flex items-center hover:bg-blue-800 hover:text-white p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
                                                        {{ $meeting_request->person->name}}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                   {{$meeting_request->custom_timeslot ? 'Yes' : 'No'}}
                                                </td>
                                                @if(auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::agent)
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @if($meeting_request->purchase_requirement->person->agent)
                                                        {{$meeting_request->purchase_requirement->person->agent->email}}
                                                    @else
                                                        <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-red-500 font-bold rounded focus:shadow-outline">
                                                            Unallocated
                                                        </span>
                                                    @endif
                                                </td>
                                                @endif
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @switch($meeting_request->status)
                                                        @case(\App\Enums\MeetingRequest\MeetingRequestStatus::Processing)
                                                        <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-green-500 rounded focus:shadow-outline hover:bg-green-600">
                                                            Processing
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\MeetingRequest\MeetingRequestStatus::Processed)
                                                        <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-500 rounded focus:shadow-outline hover:bg-green-600">
                                                            Processed
                                                        </span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <p class="text-sm my-2"><span>{{$timezoneService->localTime(auth('agent')->user(), $meeting_request->created_at, 'd M Y h:i A')}}</span> </p>
                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap justify-center text-xs font-medium flex flex-row">
                                                   @if($meeting_request->status !== App\Enums\MeetingRequest\MeetingRequestStatus::Processed && auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent)
                                                    <form action="{{route('agent.meeting_requests.update_status', $meeting_request->getRouteKey())}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-blue-800">
                                                           Mark as processed
                                                        </button>
                                                    </form>
                                                    @endif
                                                    <a href="{{route('agent.meeting_requests.show', $meeting_request->getRouteKey())}}" class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-blue-800">
                                                       View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                </table>
                                @else
                                    <div class="h-16 p-10 flex justify-center items-center">
                                        <span class="text-md italic text-gray-500">No meeting requests to show</span>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="mt-2">
                {{$meeting_requests->links()}}
            </div>
        </div>
    </div>

    <script>

    </script>
@endsection
