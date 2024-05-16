@extends('layouts.admin')
@section('content')

    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                	<h1 class="text-xl font-bold text-gray-500">
				    	{{ request()->get('type') === 'translators' ?  __('Translators') : __('Agents') }}
				  	</h1>
                </div>
                <a href="{{route('agent.users.create', ['type' => request()->get('type')])}}" class="bg-blue-200 hover:bg-blue-800 flex items-center text-blue-800 hover:text-blue-100 font-medium px-2 py-1 text-sm rounded float-right">
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
                    {!! Form::open(['url' => route('agent.users.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}
                    @if(request()->has('type'))
                        <input type="hidden" name="type" value="{{request()->get('type')}}" />
                    @endif
                    <div class="flex-col">
                        {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('name', request()->get('name'), ['placeholder' => 'Search by name', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>
                    <div class="flex-col">
                        {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('email', request()->get('email'), ['placeholder' => 'Search by email', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>
                    <div>
                        {!! Form::submit('Search', ['class' => 'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
                        <a href="{{route('agent.users.index', ['type' => request()->get('type')])}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                @if($users->count() > 0)
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
                                                Role
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="relative px-3 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs font-medium text-gray-900">
                                                    {{$user->name}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$user->email}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{$user->role->description}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @if($user->status == 1)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Available
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Unavailable
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap text-right text-xs font-medium">
                                                    <a href="{{route('agent.users.edit', $user->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-green-800 hover:text-green-100 transition-colors duration-150 bg-green-200 rounded focus:shadow-outline hover:bg-green-800">
                                                        Edit
                                                    </a>
                                                    <form action="{{route('agent.users.destroy', $user->getRouteKey())}}" class="inline-flex" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure want to delete this record?')" href="{{route('agent.users.destroy', $user->getRouteKey())}}" class="items-center px-2 py-1 ml-1 text-xs text-red-800 hover:text-red-100 transition-colors duration-150 bg-red-200 rounded focus:shadow-outline hover:bg-red-800">
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
                                        <span class="text-md italic text-gray-500">No users to show</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
