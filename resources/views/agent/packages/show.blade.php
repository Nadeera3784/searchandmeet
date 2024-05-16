@extends('layouts.admin')
@section('content')

<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="bg-white"> 
			<div class="flex flex-col">
				<div class="shadow overflow-hidden sm:rounded-md">
					<div class="px-4 py-5 bg-white sm:p-6">
						<div class="flex gap-2 justify-between">
							<h1 class="text-2xl m-0 text-gray-500">
								{{ __('Package Details') }}
							</h1>
							<div class="flex gap-2 justify-between">
								<a href="{{route('agent.people.show', $package->person->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-yellow-800 hover:text-yellow-100 transition-colors duration-150 bg-yellow-200 rounded focus:shadow-outline hover:bg-yellow-500">
									Person
								</a>
							</div>
						</div>
						<hr class="my-1 mb-5">
						<div class="container">
							<table class="w-full table-fixed md:table-auto my-2">
								<tr>
									<td class="px-4 py-3 bg-gray-100 uppercase font-semibold" colspan="2">
										Package
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Product
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$package->title}}
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="px-4 py-3 bg-white text-left sm:px-6 mb-3">
						<a href="{{route('agent.packages.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
							Back
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection