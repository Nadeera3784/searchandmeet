@extends('layouts.admin')
@section('content')

    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                	<h1 class="text-xl font-bold text-gray-500">
				    	{{ __('Leads') }}
				  	</h1>
                </div>
            </div>
            <div class="flow-root my-3">
                <div class="flex-col">
                    <div class="flex">
                        <span>Search by</span>
                    </div>
                    {!! Form::open(['url' => route('agent.leads.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

                    <div class="flex-col">
                        {!! Form::label('keyword', 'Keyword', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('keyword', request()->get('keyword'), ['placeholder' => 'Search by keyword', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>
                    <div class="flex-col">
                        {!! Form::label('date', 'Date Filter', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::date('date', request()->get('date'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>

                    {!! Form::submit('Search', ['class' => 'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
                    <a href="{{route('agent.leads.index')}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Person name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Country
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Category
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Business name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Created Date
                                            </th>
                                            <th scope="col" class="relative px-3 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($leads as $lead)
                                            <tr>
                                                <td class="px-6 py-3 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="text-xs font-medium text-gray-900">
                                                            {{$lead->person_name}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$lead->email}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$lead->country->name}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$lead->category->name}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$lead->business_name}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @switch($lead->status)
                                                        @case(1)
                                                            <span class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 hover:text-green-100 transition-colors duration-150 bg-green-200 rounded focus:shadow-outline hover:bg-green-800">
                                                                Active
                                                            </span>
                                                        @break
                                                        @case(2)
                                                        <span class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 hover:text-green-100 transition-colors duration-150 bg-green-200 rounded focus:shadow-outline hover:bg-green-800">
                                                              Claimed
                                                        </span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$lead->created_at->toDateString()}}
                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap text-right text-xs font-medium">
                                                    <a href="{{route('agent.leads.show', $lead->getRouteKey())}}" class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 hover:text-blue-100 transition-colors duration-150 bg-blue-200 rounded focus:shadow-outline hover:bg-blue-800">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">

            </div>
        </div>
    </div>
@endsection
