{!! Form::open(['url' => route('person.business.update'),'autocomplete' =>'off']) !!}

<div class="bg relative">
    <div class="absolute bg-white bg-opacity-60 inset-0 pointer-events-none"></div>
    <img src="/img/Circle_line.png" class="absolute top-1/4 right-16 transform -translate-y-full w-56">
    <img src="/img/Circle_line.png" class="absolute bottom-1/4 left-16 transform translate-y-full w-56">
    <div class="overflow-hidden sm:rounded-md md:w-10/12 w-11/12 mx-auto py-20 relative">
        <div class="px-8 md:px-8 py-6  md:w-4/5 w-full mx-auto rounded-lg shadow-md bg-purple-800 bg-opacity-70 mt-10">
            <h1 class="text-2xl m-0 text-white mb-8 font-bold">
                {{ __('Update Your Business Details') }}
                <p class="font-normal text-base text-gray-200 mt-1">Make your listing stand out in the crowd, attract quality contacts.</p>
            </h1>
            <div class="grid grid-cols-6 gap-5">
                <div class="col-start-1 col-span-6 md:col-span-3">
                    {!! Form::label('name', 'Business name', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::text('name', $business->name ?? old('name'), ['class' => 'mt-1 focus:ring-indigo-500 border-0 focus:border-indigo-500 block w-full shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}
                    @error('name')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('type_id', 'Business Type', ['class' => 'block text-sm font-medium text-white required mb-1']); !!}
                    {!! Form::select('type_id', $business_types ?? [],  $business->type_id ?? old('type_id'), ['placeholder' => 'Pick a Business Type','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('type_id')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('company_type_id', 'Company Type', ['class' => 'block text-sm font-medium text-white required mb-1']); !!}
                    {!! Form::select('company_type_id', $company_types ?? [],  $business->company_type_id ?? old('company_type_id'), ['placeholder' => 'Pick a Company Type','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('company_type_id')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-2">
                    {!! Form::label('current_importer', 'Current Importer', ['class' => 'block text-sm font-medium text-white required mb-1']); !!}
                    {!! Form::select('current_importer', ['yes' => 'Yes','no' => 'No'], $business->current_importer ?? old('current_importer'), ['class' => 'select2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('current_importer')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('phone', 'Company phone', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::text('phone',$business->phone ?? old('phone'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('phone')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-start-1 col-end-7 col-span-6"></div>
                <div class="col-span-6">
                    {!! Form::label('address', 'Address', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::search('address',  $business->address ??  old('address'), ['autocomplete'=> 'false','id'=> 'address_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @include('components.address_autocomplete')
                    @error('address')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-2">
                    {!! Form::label('city', 'City', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::text('city', $business->city ?? old('city'), ['id'=> 'city_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 border-0 focus:border-indigo-500 block w-full shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('city')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-2">
                    {!! Form::label('state', 'State', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::text('state', $business->state ??  old('state'), ['id'=> 'state_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 border-0 focus:border-indigo-500 block w-full shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('state')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-2">
                    {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-white required mb-1']); !!}
                    {!! Form::select('country_id', $countries, $business->country_id ?? old('country_id'), ['id'=> 'country_autocomplete_input','class' => 'select2 mt-1 focus:ring-indigo-500 border-0 focus:border-indigo-500 block w-full shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('country_id')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6"><hr></div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('founded_year', 'Founded year', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::number('founded_year',  $business->founded_year ??  old('founded_year'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('founded_year')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('HQ', 'Head quarters', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::text('HQ',  $business->HQ ??  old('HQ'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('HQ')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('employee_count', 'Employee count', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::select('employee_count', $employeeCountBrackets,   $business->employee_count ??  old('employee_count'), ['placeholder' => 'Pick an employee count bracket','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                    @error('employee_count')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('annual_revenue', 'Annual revenue', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::select('annual_revenue', $annualRevenueBrackets,   $business->annual_revenue ??  old('annual_revenue'), ['placeholder' => 'Pick an annual revenue bracket','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                    @error('annual_revenue')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>


                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('sic_code', 'SIC code', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::select('sic_code',  $saic_codes, old('sic_code') ?? $business->sic_code  ?? null , ['placeholder' => 'Select SIC Code ...', 'class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('sic_code')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('naics_code', 'NAICS code', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::select('naics_code', $naic_codes, old('naics_code') ??  $business->naics_code  ?? null, ['placeholder' => 'Select NAICS Code ...', 'class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('naics_code')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6"><hr></div>
                <div class="col-span-6">
                    {!! Form::label('website', 'Website', ['class' => 'block text-sm font-medium text-white']); !!}
                    <div class="mt-1 flex rounded-md shadow-md">
                        {!! Form::url('website', $business->website ?? old('website'), ['class' => 'ocus:ring-indigo-500 focus:border-indigo-500 border-0 flex-1 block w-full rounded-md md:text-sm text-base border-gray-300']); !!}
                    </div>

                    @error('website') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('linkedin', 'LinkedIn', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::url('linkedin',  $business->linkedin ?? old('linkedin'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('linkedin')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('facebook', 'Facebook', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::url('facebook', $business->facebook ?? old('facebook'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('facebook')
                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>


                <div class="col-span-6 sm:col-span-3">
                    {!! Form::label('instagram', 'Instagram', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::url('instagram', $business->instagram ?? old('instagram'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('instagram') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 sm:col-span-3">
                    {!! Form::label('twitter', 'Twitter', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::url('twitter', $business->twitter ?? old('twitter'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('twitter') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>

                <div class="col-start-1 col-span-6 text-white">
                    Required fields are marked with an asterisk [*]
                </div>
            </div>
            <div class="pt-4 text-left">
                <a href="{{route('person.purchase_requirements.index')}}" class="inline-flex ml-2 justify-center py-2 px-6 shadow-md text-sm font-medium rounded-md text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-0 cursor-pointer">
                    Back
                </a>
                {!! Form::submit('Save', ['class' => 'inline-flex ml-2 justify-center py-2 px-6 shadow-md text-sm font-medium rounded-md text-white bg-purple-500 hover:bg-purple-600 focus:outline-none focus:ring-0 cursor-pointer']); !!}
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
