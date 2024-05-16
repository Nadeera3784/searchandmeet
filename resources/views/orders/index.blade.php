@extends('layouts.app')

@section('content')
	@inject('orderService',  'App\Services\Order\OrderServiceInterface')
	<div class="flex bg px-4 h-full pt-20 min-h-screen relative">
        <div class="absolute bg-white bg-opacity-60 inset-0 pointer-events-none"></div>
		<div class='overflow-x-auto w-full h-full my-10 bg-purple-800 bg-opacity-70 rounded-md px-4 md:w-10/12 mx-auto relative'>
			<div class="container grid grid-cols-1 overflow-hidden gap-4 py-5 px-2">
				<h1 class="text-xl font-bold text-white">Contacts List</h1>
                @if(count($orders) == 0 )
					<div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
						<div class="text-xl font-semibold">
							No Contacts Found
						</div>
					</div>
                @endif
                @foreach($orders as $order)
                <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 hover:bg-gray-100 shadow-md rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div>
                        <h2 class="text-md font-bold mb-1">
							<div class="flex items-center space-x-3 text-primary">
								<div>
									@foreach($order->items as $item)
									<p class="">
										{{$item->purchase_requirement->product}}
									</p>
									@endforeach
								</div>
							</div>
                        </h2>
						<div class="text-lg font-bold mr-3 flex items-center mb-2">
							<p class="text-sm text-gray-600 font-bold mr-3 flex gap-2">
								<span class="text-gray-800 bg-purple-200 font-normal text-xs px-2 py-1 rounded-md">
									{{\App\Enums\Order\OrderStatus::getKey($order->status)}}
								 </span>
								@if($order->recieved)
									<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-primary rounded-md" >Received</span>
								@else
									@if($order->status !== \App\Enums\Order\OrderStatus::Completed)
										<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-primary rounded-md" >Reserved</span>
									@else
										<span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-primary rounded-md" >Purchased</span>
									@endif
								@endif
							</p>
						</div>
                    </div>
                    <div class="ml-auto flex items-center">
						<div class="text-lg font-bold mr-3 flex items-center">
							$ {{number_format($orderService->getTotal($order),2)}}
						</div>
                        <a href="{{route('person.orders.show', $order->getRouteKey())}}" class="text-purple-100 transform hover:bg-purple-700 hover:text-purple-100 bg-purple-500 px-3 py-2 mt-1 rounded flex items-center text-sm"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg> View</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="my-3 px-2">
                {{$orders->links()}}
            </div>
		</div>
	</div>
@endsection
