@extends('layouts.admin')
@section('content')

    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8" x-data="exportToXL()" x-init="init()">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                    <h1 class="text-xl font-bold text-gray-500">
                        {{ __('People') }}
                    </h1>
                </div>
                <a href="{{route('agent.people.index',['status' => 'suspended'])}}" class="mx-1 bg-yellow-200 hover:bg-yellow-800 flex items-center text-yellow-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                    View Suspended
                </a>
                <a href="{{route('agent.people.index',['status' => 'unverified'])}}" class="mx-1 bg-orange-200 hover:bg-orange-800 flex items-center text-orange-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                    View Unverified
                </a>
                <a href="{{route('agent.people.index',['status' => 'onboarding'])}}" class="mx-1 bg-orange-200 hover:bg-orange-800 flex items-center text-orange-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                    View OnBoarding
                </a>
                <a href="{{route('agent.people.index')}}" class="mx-1 bg-green-200 hover:bg-green-800 flex items-center text-green-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                    @if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent)
                        My people
                    @else
                        All people
                    @endif
                </a>
                @if(auth('agent')->check() && auth('agent')->user()->email === 'aka@digitalmediasolutions.com.au')
                <a href="{{route('agent.people.import')}}" class="mx-1 bg-orange-200 hover:bg-orange-800 flex items-center text-orange-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                    Import
                </a>
                @endif
                @if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent)
                    <a href="{{route('agent.people.create')}}" class="bg-blue-200 hover:bg-blue-800 flex items-center text-blue-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg> Add New
                    </a>
                @endif
            </div>
            <div class="flow-root my-3">
                <div class="flex-col">
                    <div class="flex">
                        <span>Search by</span>
                    </div>
                    {!! Form::open(['url' => route('agent.people.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

                    <div class="flex-col">
                        {!! Form::label('keyword', 'Keyword', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('keyword', '', ['placeholder' => 'Search by keyword', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md', 'x-model' => "formData.name"]); !!}
                    </div>
                    <div class="flex-col">
                        {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('email', request()->get('email'), ['placeholder' => 'Search by email', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md', 'x-model' => "formData.email"]); !!}
                    </div>

                    <div class="flex-col">
                        {!! Form::label('looking_for', 'Looking to meet', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('looking_for', \App\Enums\ProspectType::asSelectArray(), request()->get('looking_for'), ['placeholder' => 'Who are you looking to meet','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'x-model' => "formData.looking_for"]) !!}
                    </div>
                    <div class="flex-col">
                        {!! Form::label('source', 'Source', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('source', \App\Enums\Person\AccountSourceTypes::asSelectArray(), request()->get('source'), ['placeholder' => 'Select By Source','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'x-model' => "formData.source"]) !!}
                    </div>

                    <div class="flex-col">
                        {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('country_id',$countries, request()->get('country_id'), ['placeholder' => 'Search by country', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md', 'x-model' => "formData.country_id"]); !!}
                    </div>


                    @if(request()->has('status'))
                        <input type="hidden" name="status" value="{{request()->get('status')}}" />
                    @endif
                </div>
                <div class="flex-col">
                    <button @click="sendExportRequest()" type="button" class="'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Export
                        <svg x-show="isLoading" class="animate-spin  ml-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                    {!! Form::submit('Search', ['class' => 'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
                    <a href="{{route('agent.people.index')}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Clear
                    </a>
                    {!! Form::close() !!}
                </div>

            </div>
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                @if($people->count() > 0)
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Phone number
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Purchase Requirements
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Source
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Agent
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Joined on
                                            </th>
                                            <th scope="col" class="relative px-3 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($people as $person)
                                            <tr>
                                                <td class="px-6 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="text-xs font-medium text-gray-900">
                                                            {{$person->name}} <br>
                                                            <span class="text-xs font-light text-gray-400">{{\App\Enums\Designations\DesignationType::getDescription($person->designation)}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$person->email}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @if($person->formattedPhoneNumber())
                                                        {{$person->formattedPhoneNumber()}}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <a href="{{route('agent.purchase_requirements.index', ['person_id' => $person->id])}}" class="inline-flex font-bold items-center text-blue-800 transition-colors duration-150 rounded">
                                                        View all
                                                    </a>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{-- @if($person->status == true) --}}
                                                    @switch($person->status)
                                                        @case(\App\Enums\Person\AccountStatus::Unverified)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                            Unverified
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Person\AccountStatus::Verified)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Verified
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Person\AccountStatus::OnBoarding)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            On Boarding
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Person\AccountStatus::Suspended)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Suspended
                                                        </span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @switch($person->source)
                                                        @case(\App\Enums\Person\AccountSourceTypes::Api)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-500 text-white">
                                                            Api
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Person\AccountSourceTypes::Web)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500 text-white">
                                                            Web
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Person\AccountSourceTypes::Agent)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500 text-white">
                                                            Agent
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Person\AccountSourceTypes::Zoho)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-500 text-white">
                                                           Zoho
                                                        </span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @if($person->agent)
                                                        {{$person->agent->name}}
                                                        <br>
                                                        {{$person->agent->email}}
                                                    @else
                                                        No agent currently allocated
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                     <span class="capitalize">
                                                         {{$person->generalizedType()}}
                                                     </span>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{\Carbon\Carbon::parse($person->created_at)->format('d D M Y h:i A')}}
                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap text-right text-xs font-medium">
                                                    @if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent)
                                                        @if($person->status === \App\Enums\Person\AccountStatus::Unverified || $person->status === \App\Enums\Person\AccountStatus::OnBoarding)
                                                            <form action="{{route('agent.people.verify', $person->getRouteKey())}}" class="inline-flex" method="post">
                                                                @csrf
                                                                <button type="submit" class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 hover:text-green-100 transition-colors duration-150 bg-green-200 rounded focus:shadow-outline hover:bg-green-800">
                                                                    Verify
                                                                </button>
                                                            </form>
                                                        @endif
                                                        @if($person->status === \App\Enums\Person\AccountStatus::Suspended)
                                                            <form action="{{route('agent.people.unsuspend', $person->getRouteKey())}}" class="inline-flex" method="post">
                                                                @csrf
                                                                <button type="submit" class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 hover:text-green-100 transition-colors duration-150 bg-green-200 rounded focus:shadow-outline hover:bg-green-800">
                                                                    Unsuspend
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                    <a href="{{route('agent.people.schedule.show', $person->getRouteKey())}}"    class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 hover:text-blue-100 transition-colors duration-150 bg-blue-200 rounded focus:shadow-outline hover:bg-blue-800">
                                                        Set Availability
                                                    </a>
                                                    <a href="{{route('agent.people.show', $person->getRouteKey())}}"    class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 hover:text-blue-100 transition-colors duration-150 bg-blue-200 rounded focus:shadow-outline hover:bg-blue-800">
                                                        View
                                                    </a>
                                                    @if(($person->status !== \App\Enums\Person\AccountStatus::OnBoarding && auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent) || auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::agent)
                                                        <a href="{{route('agent.people.edit', $person->getRouteKey())}}"  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 hover:text-green-100 transition-colors duration-150 bg-green-200 rounded focus:shadow-outline hover:bg-green-800">
                                                            Edit
                                                        </a>
                                                    @endif
                                                    @if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::admin)
                                                        <form action="{{route('agent.people.destroy', $person->getRouteKey())}}" class="inline-flex" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-2 items-center p-1 ml-1 text-xs font-medium text-red-800 hover:text-red-100 transition-colors duration-150 bg-red-200 rounded focus:shadow-outline hover:bg-red-800">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                    </table>
                                @else
                                    <div class="h-16 p-10 flex justify-center items-center">
                                        <span class="text-md italic text-gray-500">No people to show</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                {{$people->links()}}
            </div>
        </div>
    </div>
@endsection

@section('custom-js')

    <script type="text/javascript">

        function exportToXL() {
            return {
                formData: {
                    name: '',
                    email: '',
                    looking_for: '',
                    country_id: '',
                    source: ''
                },
                isLoading: false,
                sendExportRequest() {
                    this.isLoading = true;
                    fetch('/api/v1/people/export', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(this.formData)
                    })
                        .then((response) => {
                            //if (!response.ok) alert(`Something went wrong: ${response.status} - ${response.statusText}`)
                            return response.blob()
                            //return response.json()
                        })
                        .then((blob) => {
                            var url = window.URL.createObjectURL(blob);
                            var a = document.createElement('a');
                            a.href = url;
                            a.download = "Person.xlsx";
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            this.isLoading = false;
                        })
                        .catch((error) => {
                            console.log(error);
                            this.isLoading = false;

                        })
                },
                init(){
                    this.isLoading = false;
                    this.formData.name = '{{request()->get('name')}}'
                    this.formData.email = '{{request()->get('email')}}'
                    this.formData.looking_for = '{{request()->get('looking_for')}}'
                    this.formData.country_id = '{{request()->get('country_id')}}'
                    this.formData.source = '{{request()->get('source')}}'
                }
            }
        }

    </script>

@endsection
