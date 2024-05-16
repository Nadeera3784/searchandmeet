<div
x-show="showInquiryForm"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 transform scale-90"
x-transition:enter-end="opacity-100 transform scale-100"
x-transition:leave="transition ease-in duration-300"
x-transition:leave-start="opacity-100 transform scale-100"
x-transition:leave-end="opacity-0 transform scale-90"
class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-50 ">
    <div class="modal-overlay absolute z-50"></div>

    <div  class="modal-container bg-white w-5/12 md:w-5/12 md:mx-auto rounded-lg shadow-lg z-50 overflow-y-auto mx-3">

        <div @click.away="showInquiryForm=false" class="modal-content text-left w-full mx-auto relative flex">

            <div class="py-8 px-9 w-full md:w-full ">
                <div class="flex justify-between items-center ">
                <p class="text-2xl font-bold mr-8 text-primary">Contact Us</p>
                <div class="modal-close cursor-pointer z-50 ml-auto" @click="showInquiryForm=false">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
                </div>

                <div class="h-3/6">
                    {!! Form::open(['url' => route('support.contact'), 'class' => 'modal_form']) !!}
                    <div class="grid grid-cols-1 md:grid-cols-2  justify-end py-4 gap-3">
                        <div class="w-full md:col-span-2">
                            {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                            {!! Form::text('name', old('name'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md', 'placeholder' => "Your Name"]); !!}

                            {{-- <div x-show="errors.name" x-text="errors.name ? errors.name[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>

                        <div class="w-full md:col-span-2">
                            {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                            {!! Form::text('email', old('email'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md', 'placeholder' => "Your Email"]); !!}

                            {{-- <div x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>

                        <div class="w-full md:col-span-2">
                            {!! Form::label('phone_number', 'Phone number', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                            <div class="flex gap-2">
                                {!! Form::select('phone_code_id', \App\Models\Country::pluck('phonecode', 'id'), null, ['class' => 'mt-1 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base', 'placeholder' => '--']); !!}
                                {!! Form::text('phone_number', old('phone_number'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md', 'placeholder' => "Your number"]); !!}
                            </div>
                            @error('phone_number') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                            @error('phone_code_id') <div class="text-xs text-red-700 text-left mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div class="w-full md:col-span-2">
                           {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
							{!! Form::select('country_id', \App\Models\Country::pluck('name', 'id'), old('country_id'), ['id'=> 'country_autocomplete_input','class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

							@error('country_id') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                         </div>

                         <div class="w-full md:col-span-2">
                         @component('components.categorySearch')
                            @slot('nativeSelection')
                              true
                            @endslot
                            @slot('categoryID')
                              null
                            @endslot
                            @slot('labelClass')
                            block text-sm font-medium text-gray-700 required
                            @endslot
                            @slot('selectClass')
                               mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md
                            @endslot
                           @endcomponent
                          @error('category_id') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                         </div>

                         <div class="w-full md:col-span-2">
                            {!! Form::label('website', 'Website', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('website', old('website'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.website" x-text="errors.website ? errors.website[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>
                        <div class="w-full md:col-span-2">
                                {!! Form::label('looking_for', 'Looking to meet', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
								{!! Form::select('looking_for', \App\Enums\ProspectType::asSelectArray(), old('looking_for'), ['placeholder' => 'Who are you looking to meet','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

								@error('looking_for') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                        </div>
                        <div class="w-full md:col-span-2">
                            {!! Form::label('business_name', 'Business Name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                            {!! Form::text('business_name', old('business_name'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.b_name" x-text="errors.b_name ? errors.b_name[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>

                        <div class="w-full md:col-span-2">
                            {!! Form::label('message', 'Message', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::textarea('message', old('message'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>

                        <div class="w-full md:col-span-2">
                            {!! Form::submit('Send', ['class' => 'cursor-pointer text-sm mt-2 font-semibold w-full inline-block text-center py-2 px-6 border-r  bg-primary hover:bg-primary_hover text-white rounded-sm ']); !!}
                            {{-- <div x-show="success==true" class="text-sm inline-block text-green-700 mt-4 px-4">Enquiry submitted.</div> --}}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

