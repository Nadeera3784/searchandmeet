@foreach ($purchaserequirements as $purchaserequirement)
    <div class="w-full bg-white hover:shadow-lg p-5 mb-5 rounded-lg">
        <div class="w-full flex flex-col justify-between items-start md:items-center md:flex-row mb-3">
            <div class="flex items-center flex-row">
                <img src="/img/feature-brand-{{ $purchaserequirement->id % 5 }}.png" alt="logo" class="w-10 h-10 object-cover">
                <div class="ml-3">
                    <p class="font-bold text-lg">{{ $purchaserequirement->product}}</p>
                    <p class="text-md text-gray-500">{{ $purchaserequirement->description}}</p>
                </div>
            </div>

            {{-- <div class="flex items-center ml-auto width-fit-content">
               <span >
                   <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" width="24" height="24" viewBox="0 0 24 24"><g><g><g><path fill="#00b074" d="M0 12C0 5.373 5.373 0 12 0s12 5.373 12 12-5.373 12-12 12S0 18.627 0 12z"/></g><g/><g><path fill="#fff" d="M12 19.333a5 5 0 0 1-3.425-8.642C9.469 9.85 11.667 8.333 11.333 5c4 2.667 6 5.333 2 9.333.667 0 1.667 0 3.334-1.646.18.515.333 1.069.333 1.646a5 5 0 0 1-5 5z"/></g></g></g></svg>
               </span>

               <p class="text-uppercase text-xl font-bold ml-3"><span class="text-gray-500">$</span> {{number_format($purchaserequirement->price,2)}} </p>
            </div> --}}
        </div>
        <div class="w-full flex flex-col md:flex-row justify-center md:justify-between">
        {{-- <div class="flex flex-wrap items-center justify-center mt-3 md:mt-0">
            <div class="bg-blue-100 flex items-center px-3 xl:px-2 py-1 width-fit-content mr-2 mb-2 text-sm text-gray-600">
                Agile
            </div>
            <div class="bg-blue-100 flex items-center px-3 xl:px-2 py-1 width-fit-content mr-2 mb-2 text-sm text-gray-600">
                    WireFraming
            </div>
            <div class="bg-blue-100 flex items-center px-3 xl:px-2 py-1 width-fit-content mr-2 mb-2 text-sm text-gray-600">
              Prototyping
            </div>
        </div> --}}

            <div class="flex flex-wrap  justify-start items-center  mt-3 md:mt-0">
                <div class="bg-blue-100 flex items-center px-3 xl:px-2 py-1 width-fit-content mr-2 mb-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-blue-500 ml-1 text-sm" >{{ $purchaserequirement->person->business->country->name }}</span>
                </div>

                <div class="bg-orange-100 flex items-center px-3 xl:px-2 py-1 width-fit-content mr-2 mb-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="text-orange-500 ml-1 text-sm " >{{ $purchaserequirement->category->name }}</span>
                </div>

                <div class="bg-blue-100 flex items-center px-3 xl:px-2 py-1 width-fit-content mb-2 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-green-500 ml-1 text-sm" >{{date('Y-m-d h:m A',strtotime($purchaserequirement->created_at))}}</span>
                </div>

            </div>
            <div class="flex flex-col sm:flex-row items-center justify-end mt-3 sm:mt-0">
                {{-- <button class="flex items-center justify-center px-6 py-2 border rounded-sm sm:w-max w-full ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <span class="ml-1 text-uppercase whitespace-nowrap">Save it</span>
                </button> --}}
                <a href="{{ route('purchase_requirements.show',$purchaserequirement->getRouteKey()) }}" class="mt-3 sm:mt-0 text-center px-6 py-2  sm:w-max w-full text-white rounded bg-primary hover:bg-primary_hover text-uppercase whitespace-nowrap ">Meet Now</a>
            </div>
        </div>
    </div>
@endforeach
