@extends('layouts.admin')
@section('content')

{!! Form::open(['url' => route('agent.purchase_requirements.store'),'enctype' => 'multipart/form-data']) !!}

<div class="shadow overflow-hidden sm:rounded-md" x-data="_x_fn()" x-init="init()">
    <div class="px-4 py-5 bg-white sm:p-6">
        <h1 class="text-2xl m-0 mt-8 text-gray-500">
            {{ __('Purchase Requirement') }}
        </h1>

        <hr class="my-1 mb-5">

        <div class="grid grid-cols-6 gap-5">
            <template x-if="newContact===false">
                <div class="col-start-1 col-span-12 col-end-12 sm:col-end-4">
                    {!! Form::label('person_id', 'Contact', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                    {!! Form::select('person_id', $people, old('person_id'), ['placeholder' => 'Pick a Contact','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('person_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>
            </template>

            <template x-if="newContact===true">
                <div class="col-start-1 col-span-6 col-end-7 sm:col-end-6 mt-6">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <h1 class="text-lg text-gray-500">
                                {{ __('Contact Details') }}
                            </h1>

                            <div class="grid grid-cols-6 gap-5">
                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::text('name', old('name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('designation', 'Title', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('designation', $designations, old('designation'), ['placeholder' => 'Pick a Job Title','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                    @error('designation') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::text('email', old('email'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('email') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('phone_number', 'Phone number', ['class' => 'block text-sm font-medium text-gray-700']); !!}

                                    <div class="flex gap-2">
                                        <div class="w-1/3 mt-2">
                                          {!! Form::select('phone_code_id', $phoneCodes, null, ['class' => 'select2 mt-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'placeholder' => '--']); !!}
                                        </div>
                                        {!! Form::text('phone_number', old('phone_number'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                                    </div>
                                    @error('phone_number') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                    @error('phone_code_id') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-3">
                                    {!! Form::label('looking_for', 'Looking to meet', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    {!! Form::select('looking_for', \App\Enums\ProspectType::asSelectArray(), old('looking_for'), ['placeholder' => 'Who are you looking to meet','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                    @error('looking_for') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-3">
                                    {!! Form::label('timezone_id', 'Timezone', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('timezone_id', $timezones, old('timezone_id'), ['required' => 'required', 'placeholder' => 'Your timezone','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                    @error('timezone_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-3">
                                    {!! Form::label('languages', 'Preferred languages', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('languages[]', $languages, old('languages[]'), [ 'multiple'=> 'multiple','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                    @error('languages') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>
                                <script>
                                    $('.select2').select2();
                                </script>
                            </div>

                            <h1 class="text-lg  text-gray-500">
                                {{ __('Business Details') }}
                            </h1>

                            <div class="grid grid-cols-6 gap-5">
                                <div class="col-span-6 md:col-span-2">
                                    {!! Form::label('business_name', 'Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::text('business_name', old('business_name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('business_name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    {!! Form::label('type_id', 'Business type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('type_id', $business_types, old('type_id'), ['placeholder' => 'Pick a Business Type...','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                    @error('type_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    {!! Form::label('company_type_id', 'Company type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('company_type_id', $company_types ?? [],  old('company_type_id'), ['placeholder' => 'Pick a Company Type','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                                    @error('company_type_id')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    {!! Form::label('current_importer', 'Current importer', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('current_importer', ['yes' => 'Yes','no' => 'No'], $business->current_importer ?? old('current_importer'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('current_importer')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    {!! Form::label('phone', 'Company phone', ['class' => 'block text-sm font-medium text-gray-700']); !!}
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
                                    {!! Form::label('HQ', 'Head quarters', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    {!! Form::text('HQ', old('HQ'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('HQ')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    {!! Form::label('employee_count', 'Employee count', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    {!! Form::number('employee_count', old('employee_count'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('employee_count')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 md:col-span-2">
                                    {!! Form::label('annual_revenue', 'Annual revenue', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    {!! Form::number('annual_revenue', old('annual_revenue'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

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
                                        {!! Form::text('website', old('website'), ['class' => 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md md:text-sm text-base border-gray-300']); !!}
                                    </div>

                                    @error('website') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    {!! Form::label('linkedin', 'LinkedIn', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    {!! Form::text('linkedin', old('linkedin'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('linkedin') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    {!! Form::label('facebook', 'Facebook', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    {!! Form::text('facebook', old('facebook'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

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
                                    {!! Form::text('address', old('address'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('address') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    {!! Form::label('city', 'City', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::text('city', old('city'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('city') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    {!! Form::label('state', 'State', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::text('state', old('state'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('state') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('country_id',$countries, old('country_id'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                                    @error('country_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <div class="col-end-7 col-span-1 sm:col-span-1 sm:col-end-7">
                {!! Form::label('new-contact', '&nbsp;', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                <template x-if="newContact===false">
                    {!! Form::button('+ New contact', ['class' => 'mt-1 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500', '@click' => 'toggleContactForm(true)']); !!}
                </template>

                <template x-if="newContact===true">
                    {!! Form::button('Search contact', ['class' => 'mt-1 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500', '@click' => 'toggleContactForm(false)']); !!}
                </template>
            </div>

            <div class="col-start-1 col-span-6 col-end-7 sm:col-end-6 mt-2"></div>

            <div class="col-start-1 col-span-2 sm:col-span-2">
                @component('components.categorySearch')
                    @slot('categoryID')
                        null
                    @endslot
                    @slot('labelClass')
                        block text-sm font-medium text-gray-700 required
                    @endslot
                    @slot('selectClass')
                        mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base
                    @endslot
                @endcomponent

                @error('category_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-2 sm:col-span-2">
                {!! Form::label('product', 'Product', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                {!! Form::text('product', old('product'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('product') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-2 sm:col-span-2">
                {!! Form::label('description', 'Description', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                {!! Form::text('description', old('description'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('description') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-start-1 col-span-2 sm:col-span-2">
                {!! Form::label('quantity', 'Quantity', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                {!! Form::number('quantity', old('quantity'), ['step' => '0.01', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('quantity') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-2 sm:col-span-2">
                {!! Form::label('metric_id', 'Metric', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                {!! Form::select('metric_id', $metrics, old('metric_id'), ['placeholder' => 'Pick a metric','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('metric_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-2 sm:col-span-2">
                {!! Form::label('price', 'Price', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                {!! Form::number('price', old('price'), ['step' => '0.01', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('price') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('url', 'Url', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                <div class="mt-1 flex rounded-md shadow-sm">
                    {!! Form::url('url', old('url'), ['class' => 'focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md md:text-sm text-base border-gray-300']); !!}
                </div>

                @error('url') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('pre_meeting_sample', 'Pre-meeting sample', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::text('pre_meeting_sample', old('pre_meeting_sample'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('pre_meeting_sample') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('certification_requirement', 'Certification requirement', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::text('certification_requirement', old('certification_requirement'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('certification_requirement') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('looking_to_meet', 'Looking to meet', ['class' => 'block text-sm font-medium  text-gray-700 mb-1']); !!}
                {!! Form::select('looking_to_meet', $prospectTypes, old('looking_to_meet'), ['placeholder' => 'Who are you looking to meet','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('looking_to_meet') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('looking_from', 'Prospects from', ['class' => 'block text-sm font-medium  text-gray-700 mb-1']); !!}
                {!! Form::select('looking_from', $prospectLocations, old('looking_from'), ['placeholder' => 'Anywhere','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('looking_from') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('trade_term', 'Trade terms', ['class' => 'block text-sm font-medium  text-gray-700 mb-1']); !!}
                {!! Form::select('trade_term', $tradeTerms, old('trade_term'), ['placeholder' => 'Pick a trade term','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('trade_term') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('payment_term', 'Payment terms', ['class' => 'block text-sm font-medium  text-gray-700 mb-1']); !!}
                {!! Form::select('payment_term', $paymentTerms, old('payment_term'), ['placeholder' => 'Pick a payment term','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('payment_term') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('target_purchase_date', 'Target purchase date', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::date('target_purchase_date', old('target_purchase_date'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('target_purchase_date') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('purchase_frequency', 'Purchasing frequency', ['class' => 'block text-sm font-medium text-gray-700 mb-1']); !!}
                {!! Form::select('purchase_frequency', $purchaseFrequencies, old('purchase_frequency'), ['placeholder' => 'Pick a Frequency','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('purchase_frequency') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('purchase_policy', 'Purchasing policy', ['class' => 'block text-sm font-medium text-gray-700 mb-1']); !!}
                {!! Form::select('purchase_policy', $purchasePolicies, old('purchase_policy'), ['placeholder' => 'Pick a Policy','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('purchase_policy') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('warranties_requirement', 'Warranties requirements', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::text('warranties_requirement', old('warranties_requirement'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('warranties_requirement') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('safety_standard', 'Safety standard', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::text('safety_standard', old('safety_standard'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                @error('safety_standard') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('hs_code', 'HS Code', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::select('hs_code[]', $hs_codes, old('hs_code[]'), ['multiple'=> 'multiple', 'class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                @error('hs_code')
                <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>

            <div class="col-start-2 col-end-7 sm:col-end-6"></div>

            <div class="col-span-6 md:col-span-2">
                {!! Form::label('images[]', 'Images', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                <div class="flex flex-col flex-grow mb-3">
                    <div x-data="{ files: null }" id="FileUpload" class="block w-full py-2 px-3 relative bg-white appearance-none border-2 border-gray-300 border-solid rounded-md hover:shadow-outline-gray">
                        <input type="file" multiple name="images[]" accept="image/*"
                               class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                               x-on:change="files = $event.target.files; console.log($event.target.files);"
                               x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                        >
                        <template x-if="files !== null">
                            <div class="flex flex-col space-y-1">
                                <template x-for="(_,index) in Array.from({ length: files.length })">
                                    <div class="flex flex-row items-center space-x-2">
                                        <template x-if="files[index].type.includes('audio/')"><i class="far fa-file-audio fa-fw"></i></template>
                                        <template x-if="files[index].type.includes('application/')"><i class="far fa-file-alt fa-fw"></i></template>
                                        <template x-if="files[index].type.includes('image/')"><i class="far fa-file-image fa-fw"></i></template>
                                        <template x-if="files[index].type.includes('video/')"><i class="far fa-file-video fa-fw"></i></template>
                                        <span class="font-medium text-gray-900" x-text="files[index].name"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template x-if="files === null">
                            <div class="flex flex-col space-y-2 items-center justify-center">
                                <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                                <p class="text-gray-700">Drag your files here or click in this area.</p>
                                <a href="javascript:void(0)" class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700">Select a file</a>
                            </div>
                        </template>
                    </div>
                </div>
                @error('images') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                @error('images.*') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>


            <div class="col-span-6 md:col-span-2">
                {!! Form::label('requirement_specification', 'Requirement specification document', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                <div class="flex flex-col flex-grow mb-3">
                    <div x-data="{ files: null }" class="block w-full py-2 px-3 relative bg-white appearance-none border-2 border-gray-300 border-solid rounded-md hover:shadow-outline-gray">
                        <input type="file" accept="application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword," name="requirement_specification"
                               class="absolute inset-0 z-50 m-0 p-0 w-full h-full outline-none opacity-0"
                               x-on:change="files = $event.target.files; console.log($event.target.files);"
                               x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                        >
                        <template x-if="files !== null">
                            <div class="flex flex-col space-y-1">
                                <template x-for="(_,index) in Array.from({ length: files.length })">
                                    <div class="flex flex-row items-center space-x-2">
                                        <template x-if="files[index].type.includes('application/')"><i class="far fa-file-alt fa-fw"></i></template>
                                        <span class="font-medium text-gray-900" x-text="files[index].name"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template x-if="files === null">
                            <div class="flex flex-col space-y-2 items-center justify-center">
                                <i class="fas fa-cloud-upload-alt fa-3x text-currentColor"></i>
                                <p class="text-gray-700">Drag your files here or click in this area.</p>
                                <a href="javascript:void(0)" class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700">Select a file</a>
                            </div>
                        </template>
                    </div>
                </div>
                @error('requirement_specification') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>
        </div>
        <div @tags-update="console.log('tags updated', $event.detail.tags)" data-tags='[]' class="my-4">
            {!! Form::label('tags', 'Tags', ['class' => 'block text-sm font-medium text-gray-700']); !!}
            <div x-data="tagSelect()" x-init="init('parentEl')" @click.away="clearSearch()" @keydown.escape="clearSearch()">
                <div class="relative" @keydown.enter.prevent="addTag(textInput)">
                    <input x-model="textInput" type="text" x-ref="textInput" @input="search($event.target.value)" class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter some tags">
                    <input x-model="textField" name="tags" type="hidden" x-ref="textInput" >
                    <div :class="[open ? 'block' : 'hidden']">
                        <div class="absolute z-40 left-0 mt-2 w-full">
                            <div class="py-1 text-sm bg-white rounded shadow-lg border border-gray-300">
                                <a @click.prevent="addTag(textInput)" class="block py-1 px-5 cursor-pointer hover:bg-indigo-600 hover:text-white">Add tag "<span class="font-semibold" x-text="textInput"></span>"</a>
                            </div>
                        </div>
                    </div>
                    <!-- selections -->
                    <template x-for="(tag, index) in tags">
                        <div class="bg-indigo-100 inline-flex items-center text-sm rounded mt-2 mr-1">
                            <span class="ml-2 mr-1 leading-relaxed truncate max-w-xs" x-text="tag"></span>
                            <button @click.prevent="removeTag(index)" class="w-6 h-8 inline-block align-middle text-gray-500 hover:text-gray-600 focus:outline-none">
                                <svg class="w-6 h-6 fill-current mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M15.78 14.36a1 1 0 0 1-1.42 1.42l-2.82-2.83-2.83 2.83a1 1 0 1 1-1.42-1.42l2.83-2.82L7.3 8.7a1 1 0 0 1 1.42-1.42l2.83 2.83 2.82-2.83a1 1 0 0 1 1.42 1.42l-2.83 2.83 2.83 2.82z"/></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    <div class="px-4 py-3 bg-gray-200 text-left sm:px-6">
        <a href="{{route('agent.purchase_requirements.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Back
        </a>
        {!! Form::submit('Save', ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
    </div>
</div>

{!! Form::close() !!}

<script type="text/javascript">
    function _x_fn() {
        return {
            newContact: false,
            toggleContactForm(visibility)
            {
                this.newContact = visibility;

            },
            init() {
                this.newContact = false;
            },
        }
    }

    function tagSelect() {
        return {
            open: false,
            textInput: '',
            textField: '',
            tags: [],
            init() {
                this.tags = JSON.parse(this.$el.parentNode.getAttribute('data-tags'));
            },
            addTag(tag) {
                tag = tag.trim()
                if (tag != "" && !this.hasTag(tag)) {
                    this.tags.push( tag );
                }

                this.clearSearch()
                this.$refs.textInput.focus();
                this.fireTagsUpdateEvent()
            },
            fireTagsUpdateEvent() {
                this.textField = this.tags.join(',');
                this.$el.dispatchEvent(new CustomEvent('tags-update', {
                    detail: { tags: this.tags },
                    bubbles: true,
                }));
            },
            hasTag(tag) {
                var tag = this.tags.find(e => {
                    return e.toLowerCase() === tag.toLowerCase()
                });
                return tag != undefined
            },
            removeTag(index) {
                this.tags.splice(index, 1);
                this.fireTagsUpdateEvent();
            },
            search(q) {
                if ( q.includes(",") ) {
                    q.split(",").forEach(function(val) {
                        this.addTag(val)
                    }, this)
                }
                this.toggleSearch()
            },
            clearSearch() {
                this.textInput = ''
                this.toggleSearch()
            },
            toggleSearch() {
                this.open = this.textInput != ''
            }
        }
    }
</script>

@endsection
