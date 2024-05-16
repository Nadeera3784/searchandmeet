@extends('layouts.admin')
@section('content')
    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
            <div class="flow-root mb-3">
                <div class="mb-3">
                    <h1 class="text-2xl font-bold text-gray-500">
                        {{ __('Create new match') }}
                    </h1>
                </div>
            </div>
            <div class="bg-white" x-data="matchmakingHandler()" @category.window="category_id = $event.detail.message" x-init="init()">
                <div class="flex flex-col">
                    {!! Form::open(['url' => route('agent.matchmaking.store')]) !!}
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <h1 class="text-2xl m-0  text-gray-500">
                                {{ __('Matchmaking Details') }}
                            </h1>

                            <hr class="my-1 mb-5">

                            <div class="grid grid-cols-6 gap-5">
                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('type', 'Type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('type', \App\Enums\Matchmaking\MatchTypes::asSelectArray(), old('type'), ['x-model' => 'type', 'placeholder' => 'Select match type', 'class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                    @error('type')
                                        <div class="text-xs text-red-700 text-left">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3" x-show="type !== undefined">
                                    {!! Form::label('person_id', '', ['x-text' => "type == 0 ? 'Supplier' : 'Buyer'", 'class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('person_id', $people, old('person_id'), ['placeholder' => 'Select a person','class' => 'select2 mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                    @error('person_id')
                                        <div class="text-xs text-red-700 text-left">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">

                                </div>

                            </div>
                            <h1 class="text-2xl m-0  text-gray-500 mt-3">
                                <span x-text="type == 0 ? 'Search Purchase Requirements' : 'Search Suppliers'"></span>
                            </h1>

                            <hr class="my-1 mb-5">
                            <div class="grid grid-cols-1 gap-5">
                                <div class="col-span-6 sm:col-span-3" x-show="type == undefined">
                                  <span>Please select a match type to select items</span>
                                </div>
                                <div class="grid grid-cols-8 gap-5 w-full items-center" x-show="type == {{\App\Enums\Matchmaking\MatchTypes::Supplier}}">
                                    <div class="col-span-2">
                                        {!! Form::label('keyword', 'Keyword', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                        {!! Form::text('keyword', request()->get('keyword'), ['x-model' => 'keyword', 'placeholder' => 'Search keyword', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                                    </div>
                                    <div class="col-span-2">
                                        {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                        {!! Form::select('country_id', $countries, old('country_id'), ['x-model' => 'country_id', 'placeholder' => 'Select the country','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                    </div>
                                    <div class="col-span-2">
                                        {!! Form::label('category_id', 'Category', ['class' => 'block text-sm font-medium text-gray-700 required' ]); !!}
                                        <select id="supplier_category_search" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base">
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <button @click="search('requirement')" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Search</button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-8 gap-5 w-full items-center" x-show="type == {{\App\Enums\Matchmaking\MatchTypes::Buyer}}">
                                    <div class="col-span-2">
                                        {!! Form::label('keyword', 'Keyword', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                        {!! Form::text('keyword', request()->get('keyword'), ['x-model' => 'keyword', 'placeholder' => 'Search keyword', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                                    </div>
                                    <div class="col-span-2">
                                        {!! Form::label('country_id', 'Country', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                        {!! Form::select('country_id', $countries, old('country_id'), ['x-model' => 'country_id', 'placeholder' => 'Select the country','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                    </div>
                                    <div class="col-span-2">
                                        <button @click="search('supplier')" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-5 mt-4">
                                <div x-show="(suppliers.length === 0 && requirements.length === 0) || requestLoading">
                                    <span class="text-center" x-text="requestLoading ? 'Loading' : 'Nothing to show'"></span>
                                </div>
                                <div x-show="type == {{\App\Enums\Matchmaking\MatchTypes::Supplier}} && requirements.length > 0 && !requestLoading" style="max-height: 50vh; overflow-y: scroll;">
                                    <table class="table-fixed w-full relative">
                                        <thead class="sticky top-0 h-16 bg-white">
                                            <tr>
                                                <th class="w-1/6 text-left">Select</th>
                                                <th class="w-1/2 text-left">Product name</th>
                                                <th class="w-1/4 text-left">Person</th>
                                                <th class="w-1/4 text-left">Category</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <template x-for="requirement in requirements">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" :value="requirement.id" name="items[]"/>
                                                </td>
                                                <td>
                                                    <a x-bind:href="'{{url('')}}/agent/purchase_requirements/'+requirement.id" target="_blank" x-text="requirement.name"  class="text-indigo-500 mt-3 font-bold cursor-pointer"> </a>
                                                </td>
                                                <td>
                                                    <a x-bind:href="'{{url('')}}/agent/people/'+requirement.person_id" target="_blank" x-text="requirement.person"  class="text-indigo-500 mt-3 font-bold cursor-pointer"> </a>
                                                </td>
                                                <td>
                                                    <span x-text="requirement.category.name"></span>
                                                </td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                                <div x-show="type == {{\App\Enums\Matchmaking\MatchTypes::Buyer}} && suppliers.length > 0 && !requestLoading" style="max-height: 50vh; overflow-y: scroll;">
                                    <table class="table-fixed w-full relative">
                                        <thead class="sticky top-0 h-16 bg-white">
                                            <tr>
                                                <th class="w-1/6 text-left">Select</th>
                                                <th class="w-1/2 text-left">Person</th>
                                                <th class="w-1/4 text-left">Business name</th>
                                                <th class="w-1/4 text-left">Country</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <template x-for="supplier in suppliers">
                                            <tr>
                                                <td>
                                                    <input type="checkbox" :value="supplier.id" name="items[]"/>
                                                </td>
                                                <td>
                                                    <a x-bind:href="'{{url('')}}/agent/people/'+supplier.id" target="_blank" x-text="`${supplier.name} ${supplier.email}`"  class="text-indigo-500 mt-3 font-bold cursor-pointer"> </a>
                                                </td>
                                                <td>
                                                    <span x-text="supplier.business.name"></span>
                                                </td>
                                                <td>
                                                    <span x-text="supplier.country"></span>
                                                </td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="px-4 py-3 bg-gray-200 text-left sm:px-6">
                            <a href="{{route('agent.matchmaking.index')}}"
                               class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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

    <script>
        function matchmakingHandler() {
            return {
                type: undefined,
                items: [],
                category_id: undefined,
                country_id: undefined,
                keyword: '',
                requirements: [],
                suppliers: [],
                requestLoading: false,
                init() {
                    this.$watch('type', this.typeChanged);
                },
                typeChanged(value){
                    this.items = [];
                    if (value === '0')
                    {
                        let category_search = $('#supplier_category_search');
                        category_search.select2({
                            placeholder: "Pick a Category",
                            ajax: {
                                url: "/api/v1/search_categories",
                                dataType: 'json',
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item.treeName,
                                                id: item.id
                                            }
                                        })
                                    };
                                },
                                cache: false,
                                allowClear:true
                            }
                        });

                        category_search.on('change', (e) => {

                            let event = new CustomEvent('category', {
                                detail:
                                    {
                                        message: e.target.value
                                    }
                            });
                            window.dispatchEvent(event);
                        });
                    }
                },
                search(type){
                    if(type === 'requirement')
                    {
                        this.requestLoading = true;
                        this.requirements = [];
                        let result = $.ajax({
                            url: "/api/v1/purchase_requirements",
                            type: 'GET',
                            dataType: 'json',
                            async: false,
                            global: false,
                            data: {
                                "country_id": this.country_id,
                                "category_id": this.category_id,
                                "q": this.keyword,
                            },
                            success: function (response) {
                                return response;
                            }
                        });

                        if (result.status === 200) {
                            this.requestLoading = false;
                            this.requirements = result.responseJSON;
                        }
                    }
                    else if (type === 'supplier')
                    {
                        this.requestLoading = true;
                        this.suppliers = [];
                        let result = $.ajax({
                            url: "/api/v1/people/search",
                            type: 'GET',
                            dataType: 'json',
                            async: false,
                            global: false,
                            data: {
                                "country_id": this.country_id,
                                "type": 'supplier',
                                "q": this.keyword,
                            },
                            success: function (response) {
                                return response;
                            }
                        });

                        if (result.status === 200) {
                            this.requestLoading = false;
                            this.suppliers = result.responseJSON;
                        }
                    }
                }
            }
        }
    </script>
@endsection
