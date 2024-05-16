@extends('layouts.admin')
@section('content')

{!! Form::open(['url' => route('agent.packages.store'),'enctype' => 'multipart/form-data']) !!}

<div class="shadow overflow-hidden sm:rounded-md" x-data="_x_fn()" x-init="init()">
    <div class="px-4 py-5 bg-white sm:p-6">
        <h1 class="text-2xl m-0 mt-8 text-gray-500">
            {{ __('Create Package') }}
        </h1>

        <hr class="my-1 mb-5">

        <div class="grid grid-cols-12 gap-5">
            <div class="col-span-6">
                {!! Form::label('title', 'Package name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::text('title',  old('title'), ['placeholder' => 'Give your package a name','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('title') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>
            <div class="col-span-6">
                @component('components.peopleSearch', ['limitToAgent' => true])
                    @slot('nativeSelection')
                        true
                    @endslot
                    @slot('personID')
                        null
                    @endslot
                    @slot('labelClass')
                        block text-sm font-medium text-gray-700 required
                    @endslot
                    @slot('selectClass')
                        mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md
                        shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                        md:text-sm text-base
                    @endslot
                @endcomponent

                @error('person_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>
            <div class="col-span-6">
                {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::select('country_id', $countries, old('country_id'), ['placeholder' => 'Package country','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('country_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>
            <div class="col-span-6">
                {!! Form::label('allowed_meeting_count', 'Number of meetings included', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::number('allowed_meeting_count', old('allowed_meeting_count'), ['placeholder' => 'Meetings included in this package','class' => ' mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('allowed_meeting_count') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>
            <div class="col-span-6">
                {!! Form::label('discount_rate', 'Discounted rate', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                {!! Form::number('discount_rate', old('discount_rate') ?? 0, ['placeholder' => 'Discount applied for the package','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                @error('discount_rate') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
            </div>
            <div class="col-span-6">

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

@endsection
