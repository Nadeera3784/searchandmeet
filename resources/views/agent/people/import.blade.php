@extends('layouts.admin')
@section('content')

<div class="pb-12 pt-7">
	<div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
		<div class="flow-root mb-3">
			<div class="mb-3">
				<h1 class="text-2xl font-bold text-gray-500">
					Import People
				</h1>
			</div>
		</div>
		<div class="bg-white">
			<div class="flex flex-col">
                {!! Form::open(['url' => route('agent.people.import_store'), 'enctype' => 'multipart/form-data']) !!}
				<div class="shadow overflow-hidden sm:rounded-md">
					<div class="px-4 py-5 bg-white sm:p-6">
						<hr class="my-1 mb-5">
						<div class="grid grid-cols-6 gap-5">
							<div class="col-span-6 sm:col-span-3">
								{!! Form::label('file', 'FIle', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::file('file', old('file'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

								@error('file') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
							</div>
						</div>
					</div>

					<div class="px-4 py-3 200 text-left sm:px-6">
						<a href="{{route('agent.people.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
							Back
						</a>

						{!! Form::submit('Import', ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
					</div>
				  </div>
				  {!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection