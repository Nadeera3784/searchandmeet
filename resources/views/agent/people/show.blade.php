@extends('layouts.admin')
@section('content')

<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="flow-root mb-3">
			<div class="mb-3">
				<h1 class="text-2xl font-bold text-gray-500">
					{{ __('Person') }}
				</h1>
			</div>
		</div>
		<div class="bg-white">
			<div class="flex flex-col">
				<table class="w-full table-fixed md:table-auto my-2">
					<tr>
						<td class="px-4 py-3 bg-gray-100 uppercase font-semibold" colspan="2">
							Person details
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Name
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->name}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Title
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->title}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Email
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->email}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Phone number
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							@if($person->country)
							{{$person->country->phonecode}} {{$person->phone_number}}
							@endif
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Preferred languages
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{implode( ', ', $person->preferredLanguages->pluck('name')->toArray())}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Preferred times
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{implode( ', ', $person->preferredTimes->pluck('time')->toArray())}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Looking to meet
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{\App\Enums\ProspectType::getKey($person->looking_for)}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Timezone
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->timezone->name}}
						</td>
					</tr>

					<tr>
						<td class="px-4 py-3 bg-gray-100 uppercase font-semibold" colspan="2">
							Business details
						</td>
					</tr>
					@if($person->business)
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Business name
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->name}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Business type
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{\App\Enums\Business\BusinessType::getKey($person->business->type_id)}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Business type
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{\App\Enums\Business\CompanyType::getKey($person->business->company_type_id)}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Current importer
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->current_importer}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Founded year
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->founded_year}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Head quarters
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->HQ}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Employee count
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->employee_count}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Annual revenue
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->annual_revenue}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							SIC code
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
					    	@if($person->business->saic_code)
							   {{$person->business->saic_code->name}}
							@endif
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							NAICS code
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
						    @if($person->business->naic_code)
						    	{{$person->business->naic_code->name}}
							@endif
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Business phone
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->phone}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Website
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->website}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Linkedin
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->linkedin}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Facebook
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->facebook}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
					    	Instagram
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->instagram}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
						    Twitter
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->twitter}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Address
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->address}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							City
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->city}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							State
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->state}}
						</td>
					</tr>
					<tr class="border-b border-gray-100">
						<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
							Country
						</td>
						<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
							{{$person->business->country->name}}
						</td>
					</tr>
					@else
						<tr>
							<td class="text-gray-500 md:text-sm px-3 py-3 flex flex-col gap-4" colspan="2">
								Person has no business details attached
								<a href="{{route('agent.people.edit', $person->getRouteKey())}}" class="text-center w-24 p-2 bg-indigo-500 text-white shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">Update</a>
							</td>
						</tr>
					@endif
				</table>
			</div>
		</div>
		<div class="py-3 bg-white text-left mb-3">
			<a href="{{route('agent.purchase_requirements.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
				Back
			</a>
		</div>
	</div>
</div>
@endsection