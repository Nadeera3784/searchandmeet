@extends('layouts.admin')
@section('content')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                    <h1 class="text-xl font-bold text-gray-500">
                        {{ __('Purchase Requirements') }}
                    </h1>
                </div>
                <a href="{{route('agent.purchase_requirements.create')}}" class="bg-blue-200 hover:bg-blue-800 flex items-center text-blue-800 hover:text-blue-100 text-sm font-medium px-2 py-1  rounded float-right">
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
                    {!! Form::open(['url' => route('agent.purchase_requirements.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

                        <div class="flex-col">
                            {!! Form::label('keyword', 'Keyword', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('keyword', request()->get('keyword'), ['placeholder' => 'Search keyword', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
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
                        <div class="flex-col w-96">
                         @component('components.categorySearch')
                          @slot('nativeSelection')
                            true
                          @endslot
                          @slot('categoryID')
                            null
                          @endslot
                          @slot('labelClass')
                            block text-sm font-medium text-gray-700 required
                          @endslot
                          @slot('selectClass')
                            mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base
                          @endslot
                          @endcomponent
                        </div>
                        <div>
                            <div class="flex-col">
                                {!! Form::label('date', 'Date Filter', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                {!! Form::date('date', request()->get('date'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                            </div>
                         </div>
                </div>
                <div class="flex">
                    <div class="flex-col pr-2.5 py-1.5 ">
                        {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('country_id',$countries, request()->get('country_id'), ['placeholder' => 'Search by country', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>

                    <div class="flex-col pr-2.5 py-1.5 ">
                        {!! Form::label('time_slot', 'Time slots available', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('time_slot',['only_available' => 'Only available', 'all'=>'All'], request()->get('time_slot'), ['placeholder'=>'Search by time slot', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>

                    <div class="flex-col py-2.5 px-1.5" >
                        {!! Form::submit('Search', ['class' => 'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
                        <a href="{{route('agent.purchase_requirements.index')}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                @if($purchase_requirements->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200 table-fixed w-100">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Category
                                            </th>
                                            <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Product
                                            </th>
                                            <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Quantity
                                            </th>
                                            <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Price
                                            </th>
                                            <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Added by
                                            </th>
                                            <th scope="col" class="w-1/6 px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Added on
                                            </th>
                                            <th scope="col" class="w-1/6 relative px-3 py-3">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($purchase_requirements as $purchase_requirement)
                                            <tr>
                                                <td class="px-6 py-3 text-xs font-medium text-gray-700">
                                                    {{ $purchase_requirement->category->name }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{ $purchase_requirement->product }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{ $purchase_requirement->quantity }} {{ $purchase_requirement->metric->name }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{ number_format($purchase_requirement->price, 2) }}
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    @if($purchase_requirement->addedByAgent)
                                                        {{$purchase_requirement->addedByAgent->name}}  {{$purchase_requirement->addedByAgent->email}}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3 text-xs text-gray-500">
                                                    {{$timezoneService->localTime(auth('agent')->user(), $purchase_requirement->created_at, 'd M Y h:i A')}}
                                                </td>
                                                <td class="px-3 py-3 text-right text-xs font-medium">
                                                    <a href="{{route('agent.people.show', $purchase_requirement->person->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-yellow-800 hover:text-yellow-100 transition-colors duration-150 bg-yellow-200 rounded focus:shadow-outline hover:bg-yellow-500">
                                                        Person
                                                    </a>
                                                    <a href="{{route('agent.purchase_requirements.show', $purchase_requirement->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-blue-800 hover:text-blue-100 transition-colors duration-150 bg-blue-200 rounded focus:shadow-outline hover:bg-blue-500">
                                                        View
                                                    </a>
                                                    <a href="{{route('agent.purchase_requirements.edit', $purchase_requirement->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-green-800 hover:text-green-100 transition-colors duration-150 bg-green-200 rounded focus:shadow-outline hover:bg-green-500">
                                                        Edit
                                                    </a>
                                                    <form action="{{route('agent.purchase_requirements.destroy', $purchase_requirement->getRouteKey())}}" class="inline-flex " method="post">
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
                                        <span class="text-md italic text-gray-500">No purchase requirements to show</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                {{$purchase_requirements->links()}}
            </div>
        </div>
    </div>
@endsection
