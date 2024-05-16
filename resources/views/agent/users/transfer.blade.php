@extends('layouts.admin')
@section('content')

<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="flow-root mb-3">
			<div class="mb-3">
				<h1 class="text-2xl font-bold text-gray-500">
					{{ __('Transfer agent account') }}
				</h1>
				<span class="text-sm text-gray-500">This action will transfer all data from source account to the new email. The new user will receive an email regarding the transfer</span>
			</div>
		</div>
		<div class="bg-white">
			<div class="flex flex-col">
				{!! Form::open(['url' => route('agent.users.transfer', $user->getRouteKey())]) !!}
					@csrf

					<div class="shadow overflow-hidden sm:rounded-md">
						<div class="px-4 py-5 bg-white sm:p-6">
							<div class="grid grid-cols-6 gap-5">
								<div class="col-span-6 sm:col-span-6">
									{!! Form::label('agent_id', 'Select existing agent', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
									{!! Form::select('agent_id', $agents, old('agent_id') ?? null, ['placeholder'=>'Select an agent','class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

									@error('agent_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
								</div>
								<div class="col-span-6 sm:col-span-6">
									<label class="flex items-center">
										<input type="checkbox" name="delete_account" class="form-checkbox text-pink-600">
										<span class="ml-2">Delete this account?</span>
									</label>
								</div>

								<div class="col-span-6 flex justify-center items-center border-b dashed my-4">
								</div>
								<div class="col-span-6">
									<span class="block text-sm font-medium text-gray-700">Transfer to new account</span>
								</div>
								<div class="col-span-6 sm:col-span-3">
									{!! Form::label('email', 'Target Email', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
									{!! Form::text('email', old('email'), ['onCopy'=> 'return false;', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

									@error('email') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
								</div>

								<div class="col-span-6 sm:col-span-3">
									{!! Form::label('email_confirmation', 'Confirm Email', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
									{!! Form::text('email_confirmation', old('email_confirmation'), ['onpaste'=> 'return false;', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
								</div>

								<div class="col-span-6 sm:col-span-3">
									{!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
									{!! Form::text('name', old('name'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

									@error('name') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
								</div>
								<div class="col-span-6 sm:col-span-3">
									{!! Form::label('timezone_id', 'Timezone', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
									{!! Form::select('timezone_id', $timezones, old('timezone_id'), ['class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

									@error('timezone_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
								</div>

								<div class="col-span-6 sm:col-span-3">
									{!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
									{!! Form::select('country_id', $countries, old('country_id'), ['class' => 'mt-1 select2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

									@error('country_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
								</div>
							</div>
						</div>

						<div class="px-4 py-3 bg-gray-200 text-left sm:px-6">
							<a href="{{route('agent.users.edit', $user)}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
								Back
							</a>

							{!! Form::submit('Transfer', ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
						</div>
					  </div>
				  {!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
