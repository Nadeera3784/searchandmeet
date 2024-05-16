@extends('layouts.app')

@section('content')
    @inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
    {!! Form::open(['url' => route('person.purchase_requirements.update', $purchase_requirement->getRouteKey()),'enctype' => 'multipart/form-data']) !!}
    @method('put')
    @csrf
    <div class="bg relative">
    <div class="absolute bg-white bg-opacity-60 inset-0 pointer-events-none"></div>
    <img src="/img/Circle_line.png" class="absolute top-1/4 right-16 transform -translate-y-full w-56">
    <img src="/img/Circle_line.png" class="absolute bottom-1/4 left-16 transform translate-y-full w-56">
    <div class="overflow-hidden sm:rounded-md md:w-10/12 w-11/12 mx-auto py-20 relative">
        <div class="px-8 md:px-8 py-6  md:w-4/5 w-full mx-auto rounded-lg shadow-md bg-purple-800 bg-opacity-70 mt-10">
            <h1 class="text-2xl m-0 text-white mb-8 font-bold flex items-center">
                {{ __('Create Requirement') }}
            </h1>
            <div class="grid grid-cols-6 md:gap-4 md:gap-x-6 gap-y-4 auto-cols-frw-full ">
                <div class="col-span-6 md:col-span-3">
                    @component('components.categorySearch')
                             @slot('nativeSelection')
                                false
                             @endslot
                             @slot('categoryID')
                                {{$purchase_requirement->category_id}}
                             @endslot
                             @slot('labelClass')
                                block text-sm font-medium text-white required mb-1
                             @endslot
                             @slot('selectClass')
                                mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base
                             @endslot
                    @endcomponent
                    @error('category_id') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('product', 'Product/Service', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::text('product', old('product') ?? $purchase_requirement->product, ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md md:text-sm text-base border-0 border-gray-300 rounded-md']); !!}

                    @error('product') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('description', 'Description', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::textarea('description', old('description') ?? $purchase_requirement->description, ['class' => 'mt-1 h-16 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md md:text-sm text-base border-0 border-gray-300 rounded-md']); !!}

                    @error('description') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-start-1 col-span-6"><hr></div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('quantity', 'Quantity', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::number('quantity', old('quantity') ?? $purchase_requirement->quantity, ['step' => '0.01', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('quantity') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('metric_id', 'Metric', ['class' => 'block text-sm font-medium text-white required mb-1']); !!}
                    {!! Form::select('metric_id', $metrics, old('metric_id') ?? $purchase_requirement->metric_id, ['placeholder' => 'Pick a Category','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('metric_id') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('price', 'Target price (Unit/Service)', ['class' => 'block text-sm font-medium text-white required']); !!}
                    {!! Form::number('price', old('price') ?? $purchase_requirement->price, ['step' => '0.01', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('price') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-start-1 col-span-6"><hr></div>
                <div class="col-span-6">
                    {!! Form::label('url', 'Url', ['class' => 'block text-sm font-medium text-white']); !!}
                    <div class="mt-1 flex rounded-md shadow-md">
                        {!! Form::url('url', old('url') ?? $purchase_requirement->url, ['class' => 'focus:ring-indigo-500 focus:border-indigo-500 border-0 flex-1 block w-full rounded-none rounded-md md:text-sm text-base border-gray-300']); !!}
                    </div>

                    @error('url') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('pre_meeting_sample', 'Pre-meeting sample', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::textarea('pre_meeting_sample', old('pre_meeting_sample') ?? $purchase_requirement->pre_meeting_sample, ['class' => 'mt-1 h-16 focus:ring-indigo-500 focus:border-indigo-500 border-0 block w-full shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('pre_meeting_sample') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('certification_requirement', 'Certification requirements', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::textarea('certification_requirement', old('certification_requirement') ?? $purchase_requirement->certification_requirement, ['class' => 'mt-1 h-16 focus:ring-indigo-500 focus:border-indigo-500 block border-0 w-full shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('certification_requirement') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('looking_to_meet', 'Looking to meet', ['class' => 'block text-sm font-medium text-white mb-1']); !!}
                    {!! Form::select('looking_to_meet', $prospectTypes, old('looking_to_meet') ?? $purchase_requirement->looking_to_meet, ['placeholder' => 'Who are you looking to meet','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('looking_to_meet') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('looking_from', 'Prospects from', ['class' => 'block text-sm font-medium text-white mb-1']); !!}
                    {!! Form::select('looking_from', $prospectLocations, old('looking_from') ?? $purchase_requirement->looking_from, ['placeholder' => 'Anywhere','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('looking_from') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('trade_term', 'Trade terms', ['class' => 'block text-sm font-medium text-white mb-1']); !!}
                    {!! Form::select('trade_term', $tradeTerms, old('trade_term') ?? $purchase_requirement->trade_term, ['placeholder' => 'Pick a trade term','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('trade_term') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('payment_term', 'Payment terms', ['class' => 'block text-sm font-medium text-white mb-1']); !!}
                    {!! Form::select('payment_term', $paymentTerms, old('payment_term') ?? $purchase_requirement->payment_term, ['placeholder' => 'Pick a payment term','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('payment_term') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('target_purchase_date', 'Target purchase date', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::date('target_purchase_date', old('target_purchase_date') ?? $purchase_requirement->target_purchase_date, ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('target_purchase_date') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('purchase_frequency', 'Purchasing frequency', ['class' => 'block text-sm font-medium text-white mb-1']); !!}
                    {!! Form::select('purchase_frequency', $purchaseFrequencies, old('purchase_frequency') ?? $purchase_requirement->purchase_frequency, ['placeholder' => 'Pick a Frequency','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('purchase_frequency') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('purchase_policy', 'Purchasing policy', ['class' => 'block text-sm font-medium text-white mb-1']); !!}
                    {!! Form::select('purchase_policy', $purchasePolicies, old('purchase_policy') ?? $purchase_requirement->purchase_policy, ['placeholder' => 'Pick a Policy','class' => 'select2 mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}

                    @error('purchase_policy') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('warranties_requirement', 'Warranties requirements', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::text('warranties_requirement', old('warranties_requirement') ?? $purchase_requirement->warranties_requirement, ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 border-0 block w-full shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('warranties_requirement') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('safety_standard', 'Safety standard', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::text('safety_standard', old('safety_standard') ?? $purchase_requirement->safety_standard, ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}

                    @error('safety_standard') <div class="text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 sm:col-span-2">
                    {!! Form::label('hs_code', 'HS code', ['class' => 'block text-sm font-medium text-white']); !!}
                    {!! Form::select('hs_code[]',  $hs_codes, old('hs_code[]') ?? $purchase_requirement->hs_codes, ['multiple'=> 'multiple', 'class' => 'select2 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}
                    @error('hs_code') <div class="text-xs text-red-600 text-left">{{ $message }}</div> @enderror
                </div>
                <div class="col-start-1 col-span-6"><hr></div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('images[]', 'Images', ['class' => 'block text-sm font-medium text-white']); !!}
                    <div x-data="imageUploader()" class="flex flex-col flex-grow mt-1" @mouseover = "showClear = true" @mouseover.away = "showClear = false">
                        <div id="FileUpload" class="block w-full py-2 px-3 relative bg-white appearance-none border-0 shadow-md border-gray-300 border-solid rounded-md hover:shadow-outline-gray">
                            <button x-cloak type="button" x-show="showClear && previewImages.length > 0" @click="clearImages()" class="z-50 absolute top-1 right-1 bg-red-700 text-white rounded p-2 cursor-pointer hover:bg-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>

                            <input type="hidden" name="images_changed" :value="images_changed"/>
                            <template x-if="previewImages.length > 0">
                                <div class="flex flex-row gap-2 justify-center space-y-1 max-w-full overflow-x-auto">
                                    <template x-for="(_,index) in Array.from({ length: previewImages.length })">
                                        <img :src="previewImages[index]" class="w-24 h-24 rounded"/>
                                    </template>
                                </div>
                            </template>
                            <div class="flex relative flex-col space-y-2 my-2 items-center justify-center">
                                <input type="file" multiple name="images[]" accept="image/*"
                                class="absolute inset-0 z-40 m-0 p-0 w-full h-full outline-none opacity-0"
                                @change="filesChosen"
                                x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                            />
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                <p class="text-gray-700">Drag your files here or click in this area.</p>
                                {{-- <a href="javascript:void(0)" class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700">Select a file</a> --}}
                            </div>
                        </div>
                    </div>
                    @error('images') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                    @error('images.*') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>
                <div class="col-span-6 md:col-span-3">
                    {!! Form::label('requirement_specification', 'Requirement specification document', ['class' => 'block text-sm font-medium text-white']); !!}
                    <div class="flex flex-col flex-grow mt-1">
                        <div x-data="specificationUploader()" @mouseover = "showClear = true" @mouseover.away = "showClear = false" class="block w-full py-2 px-3 relative bg-white appearance-none border-0 shadow-md border-gray-300 border-solid rounded-md hover:shadow-outline-gray">
                            <button x-cloak type="button" x-show="showClear && files.length > 0" @click="clearFiles()" class="z-50 absolute top-1 right-1 bg-red-700 text-white rounded p-2 cursor-pointer hover:bg-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <input type="hidden" name="requirement_specification_changed" :value="file_changed"/>
                            <template x-if="files.length > 0">
                                <div class="flex flex-col space-y-1 max-w-full overflow-x-auto">
                                    <template x-for="(_,index) in Array.from({ length: files.length })">
                                        <div class="flex flex-row justify-center ">
                                            <span class="font-medium text-gray-900" x-text="files[index].name"></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <div class="flex flex-col space-y-2 my-2 items-center justify-center relative">
                                <input type="file" accept="application/pdf,application/vnd.ms-excel" name="requirement_specification"
                                    class="absolute inset-0 z-40 m-0 p-0 w-full h-full outline-none opacity-0"
                                    x-on:change="filesChosen"
                                    x-on:dragover="$el.classList.add('active')" x-on:dragleave="$el.classList.remove('active')" x-on:drop="$el.classList.remove('active')"
                                >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                  </svg>
                                <p class="text-gray-700">Drag your files here or click in this area.</p>
                                {{-- <a href="javascript:void(0)" class="flex items-center mx-auto py-2 px-4 text-white text-center font-medium border border-transparent rounded-md outline-none bg-red-700">Select a file</a> --}}
                            </div>
                        </div>
                    </div>
                    @error('requirement_specification') <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                </div>
                <div class="col-start-1 col-span-6"><hr></div>
                <div @tags-update="console.log('tags updated', $event.detail.tags)" data-tags='{{ $purchase_requirement->tags->pluck('name')}}' class="col-span-6" >
                    {!! Form::label('tags', 'Tags', ['class' => 'block text-sm font-medium text-white']); !!}
                    <div x-data="tagSelect()" x-init="init('parentEl')" @click.away="clearSearch()" @keydown.escape="clearSearch()">
                        <div class="relative" @keydown.enter.prevent="addTag(textInput)">
                            <input x-model="textInput" type="text" x-ref="textInput" @input="search($event.target.value)" class="mt-1 shadow-md appearance-none border-0 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter some tags">
                            <input x-model="textField" name="tags" type="hidden" x-ref="textInput" >
                            <div :class="[open ? 'block' : 'hidden']">
                                <div class="absolute z-40 left-0 mt-2 w-full">
                                    <div class="py-1 text-sm bg-white rounded shadow-lg border-0 border-gray-300">
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
                <div class="col-start-1 col-span-6 text-white">
                    Required fields are marked with an asterisk [*]
                </div>
            </div>
            <div class="pt-8 text-left">
                <a href="{{route('person.purchase_requirements.index')}}" class="inline-flex ml-2 justify-center py-2 px-6 shadow-md text-sm font-medium rounded-md text-gray-900 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-0 cursor-pointer">
                    Back
                </a>
                {!! Form::submit('Save', ['class' => 'inline-flex ml-2 justify-center py-2 px-6 shadow-md text-sm font-medium rounded-md text-white bg-purple-500 hover:bg-purple-600 focus:outline-none focus:ring-0 cursor-pointer']); !!}
            </div>
        </div>
    </div>
    </div>

    {!! Form::close() !!}

    <script type="text/javascript">
        function _x_fn() {
            return {
                newContact: false,
                init() {
                    newContact: false;
                    // this.get_contact_businesses();
                },
                get_contact_businesses() {
                    // let contact = document.getElementById('contact_id').value;
                    let contact = {{auth()->guard('person')->user()->id}};
                    // console.log(contact);
                    window.axios.get('/agent/__get_person_businesses/'+contact)
                        .then(function (response) {
                            // console.log(response.data);
                            let data = response.data;
                            let options = '<option selected="selected" value="">Pick a Business</option>';
                            data.forEach((business) => {
                                // console.log(business);
                                options += '<option value="'+business.id+'">'+business.name+'</option>';
                            });
                            document.getElementById('business_id').innerHTML = options;
                        })
                }
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

        function imageUploader() {
            return {
                showClear: false,
                images_changed: false,
                previewImages: {!! $purchase_requirement->images->map(function($image){
                   return $image->public_path;
                }) !!},
                filesChosen(event) {
                    this.images_changed = true;
                    this.fileToDataUrl(event);
                },
                fileToDataUrl(event) {
                    if (! event.target.files.length) return;

                    this.previewImages = [];
                    Object.values(event.target.files).forEach((file) => {
                        reader = new FileReader();
                        reader.readAsDataURL(file);
                        reader.onload = e => {
                            this.previewImages.push(e.target.result);
                        }
                    });
                },
                clearImages(){
                    this.images_changed = true;
                    this.previewImages = [];
                }
            }
        }

        function specificationUploader() {
            return {
                showClear: false,
                file_changed: false,
                files: @if($purchase_requirement->requirementSpecificationDocument) ['{!! $purchase_requirement->requirementSpecificationDocument->filename !!}'] @else [] @endif,
                filesChosen(event) {
                    this.file_changed = true;
                    this.fileToDataUrl(event);
                },
                fileToDataUrl(event) {
                    if (! event.target.files.length) return;
                    this.files = event.target.files;
                },
                clearFiles(){
                    this.file_changed = true;
                    this.files = [];
                }
            }
        }

        window.addEventListener('load',()=>{
            $(()=>{
                // $('.select2').select2({
                //     width: 'resolve',
                // });
            });
        });
    </script>

@endsection
