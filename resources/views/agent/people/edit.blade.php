@extends('layouts.admin')
@section('content')
<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="flow-root mb-3">
			<div class="mb-3">
				<h1 class="text-2xl font-bold text-gray-500">
					{{ __('Update person details') }}
				</h1>
			</div>
		</div>
		<div class="bg-white"> 
			<div class="flex flex-col">
				{!! Form::open(['url' => route('agent.people.update', $person->getRouteKey())]) !!}
				{!! method_field('PATCH') !!}
				<div class="shadow overflow-hidden sm:rounded-md">
					<div class="px-4 py-5 bg-white sm:p-6">
						<div class="grid grid-cols-6 gap-5">
							@if(auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::agent && auth('agent')->user()->role->value !== \App\Enums\Agent\AgentRoles::translator)
							<h1 class="text-2xl m-0 mt-8 text-gray-500 col-span-6 sm:col-span-6 border-b pb-2">
								{{ __('Agent Details') }}
							</h1>
							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('agent_id', 'Update agent', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('agent_id', $agents, old('agent_id') ?? $person->agent_id ?? null, ['placeholder' => 'Update the agent for this person...','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('agent_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>
							@endif
							<h1 class="text-2xl m-0  text-gray-500 col-span-6 sm:col-span-6 border-b pb-2">
								{{ __('Contact Details') }}
							</h1>
							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::text('name', old('name') ?? $person->name, ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>
							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('designation', 'Title', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('designation', $designations, old('designation') ?? $person->designation, ['placeholder' => 'Pick a job title...','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('designation') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::text('email', old('email') ?? $person->email, ['disabled' => true, 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('email') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('phone_number', 'Phone number', ['class' => 'block text-sm font-medium text-gray-700']); !!}

								<div class="flex gap-2">
								    <div class="w-1/3 mt-2">
									  {!! Form::select('phone_code_id', $phoneCodes, old('phone_code_id') ?? $person->country_id ?? null, ['class' => 'select2 mt-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'placeholder' => '--']); !!}
									</div>
									{!! Form::text('phone_number', old('phone_number' ) ?? $person->phone_number, ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
								</div>
								@error('phone_number') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
								@error('phone_code_id') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('looking_for', 'Looking to meet', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('looking_for', \App\Enums\ProspectType::asSelectArray(), old('looking_for') ??  $person->looking_for, ['placeholder' => 'Who are you looking to meet','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('looking_for') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('timezone_id', 'Timezone', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('timezone_id', $timezones, old('timezone_id') ?? $person->timezone_id, ['required' => 'required', 'placeholder' => 'Your timezone','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('timezone_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('languages', 'Preferred languages', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('languages[]', $languages, old('languages[]') ?? $person->preferredLanguages, ['multiple'=> 'multiple','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
								@error('languages') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('preferred_times', 'Preferred times', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('preferred_times[]', $preferredTimes, old('preferred_times[]') ?? $person->preferredTimes, ['required' => 'required', 'multiple'=> 'multiple','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
								@error('preferred_times') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<h1 class="text-2xl m-0 mt-8 text-gray-500 col-span-6 sm:col-span-6 border-b pb-2">
								{{ __('Business Details') }}
							</h1>

							<div class="col-start-1 col-span-2 sm:col-span-2">
								{!! Form::label('business_name', 'Business name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::text('business_name', old('business_name',  $person->business ? $person->business->name : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('business_name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-2 sm:col-span-2">
								{!! Form::label('type_id', 'Business Type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('type_id', $business_types, old('type_id', $person->business ? $person->business->type_id : null), ['placeholder' => 'Pick a Business Type','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('type_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-2">
								{!! Form::label('company_type_id', 'Company Type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('company_type_id', $company_types ?? [], old('company_type_id', $person->business ? $person->business->company_type_id : null), ['placeholder' => 'Pick a Company Type','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('company_type_id')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-2">
								{!! Form::label('current_importer', 'Current Importer', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('current_importer', ['yes' => 'Yes','no' => 'No'],  old('current_importer', $person->business !== null ? $person->business->current_importer : null), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('current_importer')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-2 sm:col-span-2">
								{!! Form::label('phone', 'Company Phone', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::text('phone', old('phone', $person->business ? $person->business->phone : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('phone') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-2">
								{!! Form::label('founded_year', 'Founded year', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::number('founded_year', old('founded_year', $person->business ? $person->business->founded_year : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('founded_year')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>
							<div class="col-span-6 md:col-span-2">
								{!! Form::label('HQ', 'Headquarters', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::text('HQ', old('HQ', $person->business ? $person->business->HQ : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('HQ')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-2">
								{!! Form::label('employee_count', 'Employee count', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('employee_count', $employeeCountBrackets, old('employee_count',$person->business ?  $person->business->employee_count : null), ['placeholder' => 'Pick an employee count bracket','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('employee_count')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-2">
								{!! Form::label('annual_revenue', 'Annual revenue', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('annual_revenue', $annualRevenueBrackets,  old('annual_revenue', $person->business ?  $person->business->annual_revenue : null), ['placeholder' => 'Pick an annual revenue bracket','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('annual_revenue')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-2">
								{!! Form::label('sic_code', 'SIC code', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('sic_code',  $saic_codes, old('sic_code', ($person->business && $person->business->saic_code) ? $person->business->saic_code->id : null) , ['placeholder' => 'Select SIC Code ...', 'class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('sic_code')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
					     	</div>

							<div class="col-span-6 md:col-span-2">
								{!! Form::label('naics_code', 'NAICS code', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('naics_code', $naic_codes, old('naics_code', ($person->business && $person->business->naic_code) ? $person->business->naic_code->id : null), ['placeholder' => 'Select NAICS Code ...', 'class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('naics_code')
								<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-start-1 col-end-7 col-span-6"></div>

							<div class="col-start-1 col-span-2 sm:col-span-2">
								{!! Form::label('website', 'Website', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								<div class="mt-1 flex rounded-md shadow-sm">
									{!! Form::url('website', old('website',  $person->business ? $person->business->website : ''), ['class' => 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md md:text-sm text-base border-gray-300']); !!}
								</div>

								@error('website') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-2 sm:col-span-2">
								{!! Form::label('linkedin', 'LinkedIn', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::url('linkedin', old('linkedin', $person->business ? $person->business->linkedin : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('linkedin') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-2 sm:col-span-2">
								{!! Form::label('facebook', 'Facebook', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::url('facebook', old('facebook', $person->business ? $person->business->facebook : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('facebook') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-2 sm:col-span-2">
								{!! Form::label('instagram', 'Instagram', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::url('instagram', old('instagram', $person->business ? $person->business->instagram : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('instagram') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-2 sm:col-span-2">
								{!! Form::label('twitter', 'Twitter', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::url('twitter', old('twitter', $person->business ? $person->business->twitter : ''), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('twitter') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-start-1 col-end-7 sm:col-end-3">
								{!! Form::label('address', 'Address', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::search('address', old('address', $person->business ? $person->business->address : ''), ['id'=> 'address_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@include('components.address_autocomplete')
								@error('address') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-2">
								{!! Form::label('city', 'City', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::text('city', old('city', $person->business ? $person->business->city : ''), ['id'=> 'city_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('city') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-2">
								{!! Form::label('state', 'State', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::text('state', old('state', $person->business ? $person->business->state : ''), ['id'=> 'state_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('state') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-start-1 col-span-2 sm:col-span-2">
								{!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('country_id',$countries, old('country_id', $person->business ? $person->business->country_id : ''), ['id'=> 'country_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('country_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>
						</div>
					</div>
					<div class="px-4 py-3 bg-gray-200 text-left sm:px-6">
						<a href="{{route('agent.people.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
							Back
						</a>
						{!! Form::submit('Save', ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
					</div>
				  </div>
				  {!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
