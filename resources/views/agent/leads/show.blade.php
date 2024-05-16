@extends('layouts.admin')
@section('content')

<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="bg-white"> 
			<div class="flex flex-col">
				<div class="shadow overflow-hidden sm:rounded-md text-gray-500">
					<div class="px-4 py-5 bg-white sm:p-6">
						<h1 class="text-2xl m-0 ">
							{{ __('Lead Details') }}
						</h1>
						<hr class="my-1 mb-5">
						<div class="grid grid-cols-6 gap-5">
							<div class="col-span-12 rounded shadow-md bg-gray-50 p-5 px-6 text-gray-600">
								<h1 class="text-1xl m-0 font-bold ">
									{{ __('Person Details') }}
								</h1>
								<p class="text-sm my-2"><span class="font-medium ">Name : </span><span>{{$lead->person_name}}</span></p>
								<p class="text-sm my-2"><span class="font-medium ">Email : </span><a class="text-blue-500" target="_blank" href="mailto://{{$lead->email}}">{{$lead->email}}</a></p>
								<p class="text-sm my-2"><span class="font-medium ">Phone : </span><span>{{$lead->phone}}</span></p>
								<p class="text-sm my-2"><span class="font-medium ">Website : </span><a class="text-blue-500" target="_blank" href="{{$lead->website}}">{{$lead->website}}</a></p>
								<p class="text-sm my-2"><span class="font-medium ">Country : </span><span>{{$lead->country->name}}</span></p>
								<p class="text-sm my-2"><span class="font-medium ">Business name : </span><span>{{$lead->business_name}}</span></p>
								<p class="text-sm my-2"><span class="font-medium ">Message : </span><span>{{$lead->inquiry_message}}</span></p>
								@if($lead->agent_id)
								<p class="text-sm my-4"><span class="font-medium ">Claimed agent : </span><span>{{$lead->agent->name}}</span></p>
								@endif
							</div>
						</div>
					</div>
					<div class="px-4 py-3 text-left mb-3 sm:px-6">
						<a href="{{route('agent.leads.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
							Back
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
