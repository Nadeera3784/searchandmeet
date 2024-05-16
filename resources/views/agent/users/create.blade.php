@extends('layouts.admin')
@section('content')

<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="flow-root mb-3">
			<div class="mb-3">
				<h1 class="text-2xl font-bold text-gray-500">
					{{ __('Create a agent') }}
				</h1>
			</div>
		</div>
		<div class="bg-white">
			<div class="flex flex-col">
				{!! Form::open(['url' => route('agent.users.store')]) !!}
				<div class="shadow overflow-hidden sm:rounded-md">
					<div class="px-4 py-5 bg-white sm:p-6">

						<div class="grid grid-cols-6 gap-5">
							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::text('name', old('name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::text('email', old('email'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('email') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('timezone_id', 'Timezone', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('timezone_id', $timezones, old('timezone_id'), ['class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('timezone_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('country_id', $countries, old('country_id'), ['class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('country_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('role', 'Role', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('role', $roles, old('role') ?? $role, ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('role') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>

							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('status', 'Status', ['class' => 'block text-sm font-medium text-gray-700']); !!}
								{!! Form::select('status', [1 => 'Available', 0 => 'Unavailable'], old('status'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('status') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>
						</div>
					</div>
					<div class="px-4 py-3 bg-gray-200 text-left sm:px-6">
						<a href="{{route('agent.users.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
