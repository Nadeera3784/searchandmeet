@extends('layouts.admin')
@section('content')

<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="flow-root mb-3">
			<div class="mb-3">
				<h1 class="text-2xl font-bold text-gray-500">
					{{ __('System settings') }}
				</h1>
			</div>

		</div>
		<div class="bg-white">
			<div class="overflow-hidden sm:rounded-md md:w-10/12 w-11/12 mx-auto py-10 relative">
				{!! Form::open(['url' => route('admin.settings.product_pricing')]) !!}
				<h1 class="text-2xl m-0 mb-5 font-bold flex items-center">
					{{ __('Update product pricing') }}
				</h1>
				<div class="grid grid-cols-6 md:gap-4 md:gap-x-6 gap-y-4 auto-cols-frw-full">
					<div class="col-span-3 md:col-span-3">
						{!! Form::label('product_type', 'Product type', ['class' => 'block text-sm font-medium required mb-1']); !!}
						<select name="product_type" class='select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base'>
							<option value>Pick a product type</option>
							@foreach($prices as $price)
								<option value="{{$price->product_type}}">{{\App\Enums\Order\OrderItemType::getKey($price->product_type)}} ${{$price->price}}</option>
							@endforeach
						</select>

						@error('product_type') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
					</div>
					<div class="col-span-3 md:col-span-3">
						{!! Form::label('price', 'Base price', ['class' => 'block text-sm font-medium required']); !!}
						{!! Form::number('price', null, ['placeholder' => 'Set a price','min' => 1, 'class' => 'mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

						@error('percentage') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
					</div>
				</div>
				{!! Form::submit('Save', ['class' => 'mt-5 inline-flex ml-2 justify-center py-2 px-6 shadow-md text-sm font-medium rounded-md text-white bg-purple-500 hover:bg-purple-600 focus:outline-none focus:ring-0 cursor-pointer']); !!}
				{!! Form::close() !!}
			</div>
			<div class="overflow-hidden sm:rounded-md md:w-10/12 w-11/12 mx-auto py-10 relative">
				{!! Form::open(['url' => route('admin.settings.country_pricing')]) !!}
				<h1 class="text-2xl m-0 mb-5 font-bold flex items-center">
					{{ __('Update origin based pricing') }}
				</h1>
				<div class="grid grid-cols-6 md:gap-4 md:gap-x-6 gap-y-4 auto-cols-frw-full">
					<input type="hidden" name="type" value="origin"/>
					<div class="col-span-3 md:col-span-3">
						{!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium required mb-1']); !!}
						<select name="country_id" class='select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base'>
							<option value>Pick a country</option>
							@foreach($percentages as $percentage)
								<option value="{{$percentage->country->id}}">{{$percentage->country->name}} {{$percentage->percentage}}%</option>
							@endforeach
						</select>

						@error('country_id') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
					</div>
					<div class="col-span-3 md:col-span-3">
						{!! Form::label('percentage', 'Percentage', ['class' => 'block text-sm font-medium required']); !!}
						{!! Form::number('percentage', null, ['placeholder' => 'Set a percentage','min' => 1, 'class' => 'mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

						@error('percentage') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
					</div>
				</div>
				{!! Form::submit('Save', ['class' => 'mt-5 inline-flex ml-2 justify-center py-2 px-6 shadow-md text-sm font-medium rounded-md text-white bg-purple-500 hover:bg-purple-600 focus:outline-none focus:ring-0 cursor-pointer']); !!}
				{!! Form::close() !!}
			</div>
			<div class="overflow-hidden sm:rounded-md md:w-10/12 w-11/12 mx-auto py-10 relative">
				{!! Form::open(['url' => route('admin.settings.country_pricing')]) !!}
				<h1 class="text-2xl m-0 mb-5 font-bold flex items-center">
					{{ __('Update viewer based pricing') }}
				</h1>
				<div class="grid grid-cols-6 md:gap-4 md:gap-x-6 gap-y-4 auto-cols-frw-full">
					<input type="hidden" name="type" value="viewer"/>
					<div class="col-span-3 md:col-span-3">
						{!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium required mb-1']); !!}
						<select name="country_id" class='select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base'>
							<option value>Pick a country</option>
							@foreach($percentages as $percentage)
								<option value="{{$percentage->country->id}}">{{$percentage->country->name}} {{$percentage->viewer_percentage}}%</option>
							@endforeach
						</select>

						@error('country_id') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
					</div>
					<div class="col-span-3 md:col-span-3">
						{!! Form::label('percentage', 'Percentage', ['class' => 'block text-sm font-medium required']); !!}
						{!! Form::number('percentage', null, ['placeholder' => 'Set a percentage','min' => 1, 'class' => 'mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

						@error('percentage') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
					</div>
				</div>
				{!! Form::submit('Save', ['class' => 'mt-5 inline-flex ml-2 justify-center py-2 px-6 shadow-md text-sm font-medium rounded-md text-white bg-purple-500 hover:bg-purple-600 focus:outline-none focus:ring-0 cursor-pointer']); !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
