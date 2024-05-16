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
				{!! Form::open(['url' => route('agent.people.store')]) !!}
				<div class="shadow overflow-hidden sm:rounded-md">
					<div class="px-4 py-5 bg-white sm:p-6">
						<h1 class="text-2xl m-0  text-gray-500 col-span-6 sm:col-span-6">
							{{ __('Contact Details') }}
						</h1>

						<hr class="my-1 mb-5">

						<div class="grid grid-cols-6 gap-5">
							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::text('name', old('name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('designation', 'Title', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('designation', $designations, old('designation'), ['placeholder' => 'Pick a job title...','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('designation') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::email('email', old('email'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('email') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('phone_number', 'Phone number', ['class' => 'block text-sm font-medium text-gray-700']); !!}

								<div class="flex gap-2">
								 <div class="w-1/3 mt-2">
								  	{!! Form::select('phone_code_id', $phoneCodes, null, ['class' => 'mt-1 select2 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base' , 'placeholder' => '--']); !!}
                                   </div>
									{!! Form::text('phone_number', old('phone_number'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
								</div>
								@error('phone_number') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
								@error('phone_code_id') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('looking_for', 'Looking to meet', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('looking_for', \App\Enums\ProspectType::asSelectArray(), old('looking_for'), ['placeholder' => 'Who are you looking to meet','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('looking_for') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('timezone_id', 'Timezone', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('timezone_id', $timezones, old('timezone_id'), ['required' => 'required', 'placeholder' => 'Your timezone','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('timezone_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('languages', 'Preferred languages', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('languages[]', $languages, old('languages[]'), ['required' => 'required', 'multiple'=> 'multiple','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
								@error('languages') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 md:col-span-3">
								{!! Form::label('preferred_times', 'Preferred times', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('preferred_times[]', $preferredTimes, old('preferred_times[]'), ['required' => 'required', 'multiple'=> 'multiple','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
								@error('preferred_times') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

						<h1 class="text-2xl m-0 mt-8 text-gray-500 col-span-6 sm:col-span-6">
							{{ __('Business Details') }}
						</h1>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('business_name', 'Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::text('business_name', old('business_name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('business_name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('type_id', 'Business Type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::select('type_id', $business_types, old('type_id'), ['placeholder' => 'Pick a Business Type...','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

							@error('type_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('company_type_id', 'Company Type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::select('company_type_id', $company_types ?? [], old('company_type_id'), ['placeholder' => 'Pick a Company Type','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

							@error('company_type_id')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('current_importer', 'Current Importer', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::select('current_importer', ['yes' => 'Yes','no' => 'No'], old('current_importer'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('current_importer')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('phone', 'Company Phone', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::text('phone', old('phone'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('phone')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('founded_year', 'Founded year', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::number('founded_year', old('founded_year'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('founded_year')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>
						<div class="col-span-6 md:col-span-2">
							{!! Form::label('HQ', 'Headquarters', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::text('HQ', old('HQ'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('HQ')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('employee_count', 'Employee count', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::select('employee_count', $employeeCountBrackets,  old('employee_count'), ['placeholder' => 'Pick an employee count bracket','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

							@error('employee_count')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('annual_revenue', 'Annual revenue', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::select('annual_revenue', $annualRevenueBrackets, old('annual_revenue'), ['placeholder' => 'Pick an annual revenue bracket','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

							@error('annual_revenue')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('sic_code', 'SIC code', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::select('sic_code',  $saic_codes, old('sic_code'), ['placeholder' => 'Select SIC Code ...', 'class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('sic_code')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 md:col-span-2">
							{!! Form::label('naics_code', 'NAICS code', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::select('naics_code', $naic_codes, old('naics_code'), ['placeholder' => 'Select NAICS Code ...', 'class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('naics_code')
							<div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>
						
						<div class="col-start-1 col-end-7 col-span-6"></div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('website', 'Website', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							<div class="mt-1 flex rounded-md shadow-sm">
								{!! Form::url('website', old('website'), ['class' => 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md md:text-sm text-base border-gray-300']); !!}
							</div>

							@error('website') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('linkedin', 'LinkedIn', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::url('linkedin', old('linkedin'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('linkedin') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('facebook', 'Facebook', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::url('facebook', old('facebook'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('facebook') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('instagram', 'Instagram', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::url('instagram', old('instagram'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('instagram') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('twitter', 'Twitter', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::url('twitter', old('twitter'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('twitter') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-start-1 col-end-7 col-span-6"></div>

						<div class="col-start-1 col-end-7 sm:col-end-3">
							{!! Form::label('address', 'Address', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::search('address', old('address'), ['id'=> 'address_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@include('components.address_autocomplete')
							@error('address') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('city', 'City', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::text('city', old('city'), ['id'=> 'city_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('city') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('state', 'State', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::text('state', old('state'), ['id'=> 'state_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('state') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
						</div>

						<div class="col-span-6 sm:col-span-2">
							{!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::select('country_id',$countries, old('country_id'), ['id'=> 'country_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

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
