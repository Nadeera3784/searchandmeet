<div x-data="{filter:false}" @click.away="filter=false" class="w-full md:w-max h-max bg-gray-900 bg-opacity-80   shadow p-4 rounded-md relative">
    {!! Form::open(['url' => route('purchase_requirements.search'), 'method' => 'get','id'=>'SearchForm']) !!}
        <div class="flex items-center md:mb-0 space-y-4 flex-col relative">
            <div class="flex w-full absalute items-center md:mb-0 md:flex-row  flex-col ">
                <div class="w-full  flex md:flex-row flex-col items-center">
                    <div class="relative w-full md:mb-0  md:w-60 md:mr-5 mb-3">
                        {!! Form::text('keyword', old('keyword'), ['class' => 'block w-full bg-white  text-md p-2 pl-10 shadow-md rounded border border-gray-100', 'placeholder' => 'Search Meetings']) !!}
                        <div  class="absolute inset-y-0 left-0 pl-3 flex items-center text-sm leading-5 text-gray-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class=" relative w-full md:mb-0  md:w-60">
                        {!! Form::select('country', $countries , old('country'), ['class' => 'block w-full bg-white  text-md p-2 pl-10 shadow-md rounded border border-gray-100', 'placeholder' => 'Country']) !!}
                        <div  class="absolute inset-y-0 left-0 pl-3 flex items-center text-sm leading-5 text-gray-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-gray-500 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="md:w-1/5 w-full md:ml-5 md:pr-1 mt-3 md:mt-0 flex ">
                    <button class="bg-primary hover:bg-primary_hover rounded focus:outline-none hover:border-gray-100 shadow-md text-white px-4 py-2 border border-primary w-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 dark:text-white mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search
                    </button>
                </div>
            </div>
            <div @click="filter=!filter"  class="w-full rounded  relative">
                <div class="flex justify-between p-1 px-2 cursor-pointer text-white">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                      <p class="px-2">Filter</p>
                    </div>
                    <span>
                            <svg x-show="!filter" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                           <svg x-show="filter" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                    </span>
                </div>
            </div>
        </div>
        <div x-show="filter"
             x-transition:enter="transition ease-in-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="height: max-content"
             class="w-full left-0 top-0 z-10 bg-gray-900 bg-opacity-80 text-white md:-bottom-2 transform translate-y-full md:mt-0 mt-16 rounded-md  p-5 absolute shadow-lg select-none">
            <p class="font-bold text-lg pb-2">Availability for Meetings</p>
            <div class="flex items-center md:flex-row  flex-col ">
                <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-4 grid-cols-2 w-full">
                    <label class="cursor-pointer flex items-center">
                        {!! Form::checkbox('availability', 'today', (request()->get('availability') == 'today' || in_array('today', request()->get('availability') ?? [])),['class="text-lg rounded form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray"']) !!}
                        <span class="ml-1.5 text-gray-300 cursor-pointer font-semibold">Today</span>
                    </label>

                    <label class="cursor-pointer flex items-center">
                        {!! Form::checkbox('availability', 'week', (request()->get('availability') == 'week' || in_array('week', request()->get('availability') ?? [])),['class="text-lg rounded form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray"']) !!}
                        <span class="ml-1.5 text-gray-300 cursor-pointer font-semibold">This Week</span>
                    </label>

                    <label class="cursor-pointer flex items-center">
                        {!! Form::checkbox('availability', 'nextMonth', (request()->get('availability') == 'nextMonth' || in_array('nextMonth', request()->get('availability') ?? [])),['class="text-lg rounded form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray"']) !!}
                        <span class="ml-1.5 text-gray-300 cursor-pointer font-semibold ">Next Month</span>
                    </label>

                    <label class="cursor-pointer flex items-center">
                        {!! Form::checkbox('availability', 'tomorrow', (request()->get('tomorrow') == 'tomorrow' || in_array('tomorrow', request()->get('availability') ?? [])),['class="text-lg rounded form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray"']) !!}
                        <span class="ml-1.5 text-gray-300 cursor-pointer font-semibold">Tomorrow</span>
                    </label>

                    <label class="cursor-pointer flex items-center">
                        {!! Form::checkbox('availability', 'thisMonth', (request()->get('availability') == 'thisMonth' || in_array('thisMonth', request()->get('availability') ?? [])),['class="text-lg rounded form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray"']) !!}
                        <span class="ml-1.5 text-gray-300 cursor-pointer font-semibold">This Month</span>
                    </label>

                    <label class="cursor-pointer flex items-center">
                        {!! Form::checkbox('availability', 'all', (request()->get('availability') == 'all' || in_array('all', request()->get('availability') ?? [])),['class="text-lg rounded form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray"']) !!}
                        <span class="ml-1.5 text-gray-300 cursor-pointer font-semibold">All</span>
                    </label>

                </div>
                {{-- <div class="md:w-1/4 w-full md:mt-0 mt-3">
                    <button class="border mx-auto block px-4 py-2 rounded-sm border-gray-500">By date</button>
                </div> --}}
            </div>
        </div>
    {!! Form::close() !!}
</div>

<script>
    // window.addEventListener('load',()=>{
    //     var TagsArray = []
    //     var input = document.querySelector('input[name=q]'),
    //     tagify = new Tagify(input,{
    //         whitelist : [],
    //         dropdown : {
    //             enabled: 1
    //         }
    //     }),controller;
    //     tagify.DOM.input.addEventListener('focus', ()=>{
    //         tagify.settings.whitelist.length = 0;
    //     })
    //     tagify.on('input', (e)=>{
    //         var value = e.detail.value;
    //         tagify.settings.whitelist.length = 0;
    //         tagify.loading(true).dropdown.hide.call(tagify)

    //         controller && controller.abort();
    //         controller = new AbortController();

    //         fetch('{!! route('__get_search_suggestions') !!}?q='+value)
    //         .then(RES => RES.json())
    //         .then(function(whitelist){
    //             // update inwhitelist Array in-place
    //             tagify.settings.whitelist.splice(0, whitelist.length, ...whitelist)
    //             tagify.loading(false).dropdown.show.call(tagify, value); // render the suggestions dropdown
    //         })
    //     })

    //     input.addEventListener('change', (e) =>{
    //         var tags = e.target.value;
    //         if(tags!=''){
    //             let tagsJson = JSON.parse(tags)
    //             TagsArray = Array.from(tagsJson).map(tag => tag.value)
    //         }else{
    //             TagsArray = []
    //         }
    //         console.log(TagsArray)

    //     });

    //     var formElm = document.querySelector('#SearchForm');

    //     formElm.addEventListener('submit',(e)=>{
    //         e.preventDefault()
    //         handleSubmit()
    //     })
    //     tagify.on('keydown',(e) => {
    //         if( e.detail.originalEvent.key == "Enter" &&         // "enter" key pressed
    //         !tagify.state.inputText &&  // assuming user is not in the middle oy adding a tag
    //         !tagify.state.editing       // user not editing a tag
    //         ){
    //             handleSubmit()
    //         }
    //     });

    //     function handleSubmit(){
    //         input.value = JSON.stringify(TagsArray);
    //         setTimeout(() => {
    //             formElm.submit()
    //         },500)
    //     }

    // });
</script>
