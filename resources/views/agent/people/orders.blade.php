@extends('layouts.admin')
@section('content')

    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                	<h1 class="text-xl font-bold text-gray-500">
				    	{{ __('Orders') }}
				  	</h1>
                </div>
                <a href="{{route('agent.order.create')}}" class="bg-blue-200 hover:bg-blue-800 flex items-center text-blue-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg> Add New
                </a>
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
                                                Products
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Person
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                               Total cost
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Order date
                                            </th>
                                            <th scope="col" class="relative px-3 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="px-6 py-3 whitespace-nowrap">
                                                    <div class="flex items-center flex-col">
                                                        @foreach($order->items as $order_item)
                                                            <a href="{{route('agent.purchase_requirements.show', $order_item->purchase_requirement->getRouteKey())}}" class="truncate w-20 px-2 hover:bg-blue-800 hover:text-white inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
                                                                {{$order_item->purchase_requirement->product}}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <a href="{{route('agent.people.show', $order->person->getRouteKey())}}" class="px-2 inline-flex items-center hover:bg-blue-800 hover:text-white p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
                                                        {{ $order->person->name}}
                                                    </a>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    ${{ $order->total()}}
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @switch($order->status)
                                                        @case(\App\Enums\Order\OrderStatus::Draft)
                                                        <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-green-800">
                                                            Draft
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Order\OrderStatus::Pending)
                                                        <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 transition-colors duration-150 bg-yellow-200 hover:text-yellow-200 rounded focus:shadow-outline hover:bg-green-800">
                                                            Pending
                                                        </span>
                                                        @break
                                                        @case(\App\Enums\Order\OrderStatus::Completed)
                                                        <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-green-800 transition-colors duration-150 bg-green-200 hover:text-green-200 rounded focus:shadow-outline hover:bg-green-800">
                                                            Completed
                                                        </span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <p class="text-sm my-2"><span>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d M Y h:i:s A')}}</span> </p>

                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap text-right text-xs font-medium">
                                                    <a href="{{route('agent.order.show', $order->getRouteKey())}}"    class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-blue-800">
                                                       View
                                                    </a>
                                                    <a href="{{route('agent.order.destroy', $order->getRouteKey())}}" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-red-800 transition-colors duration-150 bg-red-200 hover:text-red-200 rounded focus:shadow-outline hover:bg-red-800">
                                                        Delete
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
                {{$orders->links()}}
            </div>
        </div>
    </div>
@endsection