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
								{{ __('Purchase Requirement Details') }}
							</h1>
							<div class="flex gap-2 justify-between">
								<a href="{{route('agent.people.show', $purchase_requirement->person->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs text-yellow-800 hover:text-yellow-100 transition-colors duration-150 bg-yellow-200 rounded focus:shadow-outline hover:bg-yellow-500">
									Person
								</a>
							</div>
						</div>
						<hr class="my-1 mb-5">
						<div class="container">
							<table class="w-full table-fixed md:table-auto my-2">
								<tr>
									<td class="px-4 py-3 bg-gray-100 uppercase font-semibold" colspan="2">
										Purchasing Requirement
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Product
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->product}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Category
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->category->name}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Description
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->description}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Quantity
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->quantity." ".$purchase_requirement->metric->name}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Price
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										$ {{number_format($purchase_requirement->price,2)}}
									</td>
								</tr>
								@if($purchase_requirement->target_purchase_date)
								<tr>
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Target purchasing date
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $purchase_requirement->target_purchase_date)->format('D M Y')}}
									</td>
								</tr>
								@endif
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Pre meeting sample
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->pre_meeting_sample}}
									</td>
								</tr>
								@if($purchase_requirement->images->count() > 0)
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Images
									</td>
									<td class="px-3 py-3 flex col-span-1 w-full text-gray-500 md:text-sm ">
										<div class="thumb mt-1 w-72 overflow-x-auto overflow-y-hidden flex flex-row space-x-2 pb-2">
											@foreach($purchase_requirement->images as $image)
												<img src="{{$image->public_path}}" class="w-10 h-10" />
											@endforeach
										</div>
									</td>
								</tr>
								@endif
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Certification
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->certification_requirement}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Url
									</td>
									<td class="px-3 py-3 text-left text-blue-500 md:text-sm">
										{{$purchase_requirement->url}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Trade term
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->trade_term}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Payment term
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->payment_term}}
									</td>
								</tr>
								@if(!empty($purchase_requirement->hs_codes) && count($purchase_requirement->hs_codes) > 0)
								<tr>
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										HS Code
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										@foreach($purchase_requirement->hs_codes as $hs)
										{!! $hs->code->name  . "</br>" !!}
										@endforeach
									</td>
								</tr>
								@endif
								@if($purchase_requirement->purchase_frequency)
								<tr>
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Purchase frequency
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{\App\Enums\PurchaseFrequency::getDescription(intval($purchase_requirement->purchase_frequency))}}
									</td>
								</tr>
								@endif
								@if($purchase_requirement->purchase_policy)
								<tr>
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Purchase policy
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{\App\Enums\PurchasePolicy::getDescription(intval($purchase_requirement->purchase_policy))}}
									</td>
								</tr>
								@endif
								<tr>
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Warranties requirement
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->warranties_requirement}}
									</td>
								</tr>
								<tr>
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Safety standard
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->safety_standard}}
									</td>
								</tr>
							</table>
							<table class="my-2 w-full table-fixed md:table-auto">
								<tr>
									<td class="px-4 py-3 bg-gray-100 uppercase font-semibold" colspan="2">
										Contact details
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Name
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->name ?? ''}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Email
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->email ?? ''}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Mobile
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->msisdn ?? ''}}
									</td>
								</tr>
							</table>
							<table class="w-full table-fixed md:table-auto my-2">
								<tr>
									<td class="px-4 py-3 bg-gray-100 uppercase font-semibold" colspan="2">
										Business details
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Name
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->name}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Business type
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{ \App\Enums\Business\BusinessType::getDescription($purchase_requirement->person->business->type_id)}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Company type
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{ \App\Enums\Business\CompanyType::getDescription($purchase_requirement->person->business->company_type_id)}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Current importer
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->current_importer}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Phone
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->phone}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Website
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->website}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Linkedin
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->linkedin}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Facebook
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->facebook}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Address
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->address}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										City
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->city}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										State
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->state}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Country
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->country->name}}
									</td>
								</tr>

								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Founded year
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->founded_year}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Head quarters
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->HQ}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Employee count
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->employee_count}}
									</td>
								</tr>
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										Annual revenue
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
										{{$purchase_requirement->person->business->annual_revenue}}
									</td>
								</tr>
								@if($purchase_requirement->person->business->saic_code)
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										SIC code
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
								    	@if($purchase_requirement->person->business->saic_code)
									    	 {{$purchase_requirement->person->business->saic_code->name}}
										@endif
									</td>
								</tr>
								@endif
								@if($purchase_requirement->person->business->naic_code)
								<tr class="border-b border-gray-100">
									<td class="px-4 py-3 text-left bg-gray-50 border-r border-gray-100 font-semibold text-sm text-gray-600">
										NAICS code
									</td>
									<td class="px-3 py-3 text-left text-gray-500 md:text-sm">
								    	@if($purchase_requirement->person->business->naic_code)
									    	{{$purchase_requirement->person->business->naic_code->name}}
										@endif
									</td>
								</tr>
								@endif
							</table>
						</div>
					</div>
					<div class="px-4 py-3 bg-white text-left sm:px-6 mb-3">
						<a href="{{route('agent.purchase_requirements.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
							Back
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection