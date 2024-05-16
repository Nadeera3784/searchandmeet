@extends('layouts.admin')
@section('content')
    @inject('orderService',  'App\Services\Order\OrderServiceInterface')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    <style>

        .modal-overlay {
            align-items: center;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            height: 100vh;
            justify-items: center;
            left: 0;
            position: fixed;
            top: 0;
            width: 100vw;
            z-index: 99;
        }
        .modal-container {
            background: white;
            height: 40vh;
            margin: auto;
            overflow: auto;
            width: 40vw;
        }
        .modal-container > .modal-head {
            background: #355c7d;
            color: white;
            display: flex;
            justify-content: space-between;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        .modal-container > .modal-head > .close {
            cursor: pointer;
            font-size: 15px;
            margin-right: -15px;
            text-align: center;
            width: 40px;
        }
        .modal-container > .modal-body {
            padding: 0 20px;
        }

    </style>
    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root mb-3">
                <div class="inline-flex float-left mb-3">
                	<h1 class="text-xl font-bold text-gray-500">
				    	{{ __('Orders') }}
				  	</h1>
                </div>
                <a href="{{route('agent.order.create')}}" class="mx-1 bg-blue-200 hover:bg-blue-800 flex items-center text-blue-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
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
                    {!! Form::open(['url' => route('agent.order.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

                    <div class="flex-col">
                        {!! Form::label('status', 'Status', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::select('status', \App\Enums\Order\OrderStatus::asSelectArray(), request()->get('status'), ['placeholder' => 'Search by status', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>
                    <div class="flex-col">
                        {!! Form::label('id', 'ID', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('id', request()->get('id'), ['placeholder' => 'Search by ID', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
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
                        <a href="{{route('agent.order.index')}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Clear
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm" x-data="orderStatusHandler()">

                    <div class="modal-overlay" x-show="modalVisible" x-cloak>
                        <div class="modal-container" x-show="modalVisible" @click.away="closeModal();" x-cloak>

                            <div class="modal-head">
                                <div class="article-attributes">
                                    <span>Update order status</span>
                                </div>
                                <div class="close" @click="closeModal();"><i class="fas fa-times">X</i></div>
                            </div>

                            <div class="modal-body">
                                {!! Form::open(['url' => route('agent.order.update_status')]) !!}
                                <div class="w-full flex flex-col gap-3 py-2">
                                    <div>
                                        <span x-text="'Updating status of order ' + current_order"></span>
                                    </div>
                                    <input type="hidden" x-model="current_order" name="order_id" />
                                    <div>
                                        {!! Form::label('status', 'New status', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                        {!! Form::select('status', [\App\Enums\Order\OrderStatus::Cancelled => 'Mark as cancelled',\App\Enums\Order\OrderStatus::Completed => 'Mark as paid'], old('status'), ['placeholder' => 'Select the new order status','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                    </div>

                                    <div class="flex justify-start">
                                        <button type="submit" class="bg-black-500 rounded py-1 px-3 text-white cursor-pointer w-20 h-10">Update</button>
                                    </div>

                                    <div class="flex gap-2 flex-col justify-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded" role="alert">
                                        <div class="flex">
                                            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
                                            <p>Package info</p>
                                        </div>
                                        <span class="font-semibold mr-2 text-left flex-auto">If you mark a package based order as paid, it will remove a meeting slot from the total meeting count of the package.
                                            If the package meeting quota has been fully booked you won't be able to complete this order.</span>
                                    </div>

                                </div>
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>

                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                @if($orders->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                ID
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Products
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Person
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Agents
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                               Total cost
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                                Package
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
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    {{ $order->getRouteKey()}}
                                                </td>
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
                                                    @if($order->items->count() > 0)
                                                        @switch($order->items[0]->type)
                                                            @case(\App\Enums\Order\OrderItemType::BookAndMeet)
                                                                Meeting only
                                                            @break
                                                            @case(\App\Enums\Order\OrderItemType::MeetingWithHost)
                                                                Meeting with host
                                                            @break
                                                            @case(\App\Enums\Order\OrderItemType::AccessInformation)
                                                                Contact information only
                                                            @break
                                                        @endswitch
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500 flex flex-col gap-2">
                                                    @if($order->items->count() > 0)
                                                    <div class="flex gap-2 items-center">
                                                        @if($order->items[0]->purchase_requirement->person->agent)
                                                            {{$order->items[0]->purchase_requirement->person->agent->name}}
                                                        @else
                                                            No agent assigned
                                                        @endif
                                                            <span class="bg-gray-500 px-3 py-1 rounded text-white">Buyer agent</span>
                                                    </div>
                                                    @endif
                                                    <div class="flex gap-2 items-center">
                                                        @if($order->person->agent)
                                                            {{$order->person->agent->name}}
                                                        @else
                                                            No agent assigned
                                                        @endif
                                                        <span class="bg-gray-500 px-3 py-1 rounded text-white">Supplier agent</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @if($order->items[0]->package)
                                                        Package based
                                                    @else
                                                        ${{ $orderService->getTotal($order)}}
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    @if($order->items[0]->package)
                                                        <a href="{{route('agent.packages.show', $order->items[0]->package->getRouteKey())}}" target="_blank" class="px-2 inline-flex items-center hover:bg-blue-800 hover:text-white p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline"> {{ $order->items[0]->package->title }}</a>
                                                    @else
                                                        No package attached
                                                    @endif
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
                                                        @case(\App\Enums\Order\OrderStatus::Cancelled)
                                                        <span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-red-800 transition-colors duration-150 bg-red-200 hover:text-red-200 rounded focus:shadow-outline hover:bg-red-800">
                                                            Cancelled
                                                        </span>
                                                        @break
                                                    @endswitch
                                                    @if($order->status !== \App\Enums\Order\OrderStatus::Completed && $order->status !== \App\Enums\Order\OrderStatus::Cancelled)
                                                        <span @click="openModal('{{$order->getRouteKey()}}')" class="mx-2 bg-gray-500 rounded text-white px-2 py-1 hover:bg-gray-600 cursor-pointer">Update status</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500">
                                                    <p class="text-sm my-2"><span>{{$timezoneService->localTime(auth('agent')->user(), $order->created_at, 'd M Y h:i A')}}</span> </p>

                                                </td>
                                                <td class="px-3 py-3 whitespace-nowrap text-right text-xs font-medium flex flex-row">
                                                    <a href="{{route('agent.order.show', $order->getRouteKey())}}" class="px-2 inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 bg-blue-200 hover:text-blue-200 rounded focus:shadow-outline hover:bg-blue-800">
                                                       View
                                                    </a>
                                                    <form action="{{route('agent.order.destroy', $order->getRouteKey())}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure want to delete this record?')" href="{{route('agent.order.destroy',  $order->getRouteKey())}}" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-red-800 transition-colors duration-150 bg-red-200 hover:text-red-200 rounded focus:shadow-outline hover:bg-red-800">
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
                                        <span class="text-md italic text-gray-500">No orders to show</span>
                                    </div>
                                @endif
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

    <script>

    </script>
@endsection
<script>
    function confirmDelete()
    {

        var conf = confirm('Are you sure want to delete this record?');
        if (conf){

        }
    }

    function orderStatusHandler()
    {
        return {
            current_order: null,
            modalVisible: false,
            order_status: null,
            openModal(orderId){
                this.current_order = orderId;
                this.modalVisible = true;
            },
            closeModal(){
                this.current_order = null;
                this.modalVisible = false;
            },

        }
    }
</script>
