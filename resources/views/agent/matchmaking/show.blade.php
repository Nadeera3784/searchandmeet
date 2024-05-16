@extends('layouts.admin')
@section('content')
	@inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="bg-white"> 
			<div class="flex flex-col">
				<div class="shadow overflow-hidden sm:rounded-md text-gray-500">
					<div class="px-4 py-5 bg-white sm:p-6">
						<h1 class="text-2xl m-0 ">
							{{ __('Match Details') }}
						</h1>
						<hr class="my-1 mb-5">
						<div class="grid grid-cols-6 gap-5">
							<div class="col-span-6 md:col-start-1 md:col-end-4 md:row-start-1 text-gray-600">
								<p class="text-sm my-2 flex content-start gap-2"><span class="font-medium ">Item Count</span> : <span>{{$match->items->count()}}</span></p>
								<p class="text-sm my-2 flex content-start gap-2"><span class="font-medium ">Notification status</span> : <span>{{$match->notification_status === 0 ? 'Not sent' : 'sent'}}</span></p>
							</div>

							<div class="col-span-6 md:col-start-4 md:col-end-7 md:row-start-1 md:row-end-2 rounded shadow-md bg-gray-50 p-5 px-6 text-gray-600">
								<h1 class="text-1xl m-0 font-bold ">
									{{ __('Person Details') }}
								</h1>
								<p class="text-sm my-2"><span class="font-medium ">Name : </span><a href="{{route('agent.people.show', $match->person->getRouteKey())}}" class="text-blue-500 cursor-pointer hover:font-bold">{{$match->person->name}}</a></p>
								<p class="text-sm my-2"><span class="font-medium ">Email : </span><a href="mailto://{{$match->person->email}}" class="text-blue-500 hover:font-bold">{{$match->person->email}}</a></p>
							</div>
							<div class="col-span-6 overflow-x-auto">
								<h1 class="text-1xl m-0 mb-3 font-bold ">
									{{$match->type === \App\Enums\Matchmaking\MatchTypes::Supplier ? 'Matched requirements' : 'Matched suppliers'}}
								</h1>
								<div class="w-full overflow-x-auto overflow-y-hidden">
									<table class="min-w-full divide-y divide-gray-200">
										<thead class="bg-gray-100">
											<tr>
												<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													Item
												</th>
												<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													Item type
												</th>
											</tr>
										</thead>
										<tbody class="bg-white divide-y divide-gray-200">
										@foreach($match->items as $item)
											<tr>
												<td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													@if($item->item_type === \App\Enums\Matchmaking\ItemTypes::PurchaseRequirement)
														<a href="{{route('agent.purchase_requirements.show', $item->toObject()->getRouteKey())}}" class="truncate w-20 px-2 hover:bg-blue-800 hover:text-white inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
															{{$item->toObject()->product}}
														</a>
													@endif
													@if($item->item_type === \App\Enums\Matchmaking\ItemTypes::Person)
														<a href="{{route('agent.people.show', $item->toObject()->getRouteKey())}}" class="truncate w-20 px-2 hover:bg-blue-800 hover:text-white inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
															{{$item->toObject()->name}}
														</a>
													@endif
												</td>
												<td class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
													{{\App\Enums\Matchmaking\ItemTypes::getDescription($item->item_type)}}
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
					<div class="px-4 py-3 text-left mb-3 sm:px-6">
						<a href="{{route('agent.matchmaking.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
							Back
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
