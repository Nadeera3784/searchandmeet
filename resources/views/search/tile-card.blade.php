@foreach ($purchaserequirements as $purchaserequirement)
    <div class="p-5 bg-white rounded-lg flex flex-col justify-start">
        <img src="/img/feature-brand-{{ $purchaserequirement->id % 5 }}.png" alt="logo" class="object-cover w-16 h-16">
        <p class="mt-8 text-xs font-semibold">Purchase Volume: <span class="font-light">{{ $purchaserequirement->quantity * $purchaserequirement->price }}</span></p>
        <h3 class="mt-1 text-2xl font-bold">{{ $purchaserequirement->category->name }}</h3>

        <div class="flex flex-wrap items-center justify-start mt-4">
            <div class="flex items-center px-3 py-1 mb-2 mr-2 bg-blue-100 xl:px-2 width-fit-content rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="ml-1 text-sm text-blue-500">{{ $purchaserequirement->person->business->country->name }}</span>
            </div>

            <div class="flex items-center px-3 py-1 mb-2 mr-2 bg-orange-100 xl:px-2 width-fit-content rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span class="ml-1 text-sm text-orange-500">{{ $purchaserequirement->person->business->type() }}</span>
            </div>

            <div class="flex items-center px-3 py-1 mb-2 bg-blue-100 xl:px-2 width-fit-content rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="ml-1 text-sm text-green-500" >{{date('Y-m-d',strtotime($purchaserequirement->created_at))}}</span>
            </div>
        </div>
        <p class="mt-5 text-gray-500 truncate" style="min-height: 50px">{{ $purchaserequirement->description }}</p>

        <div class="grid w-full grid-cols-1 gap-4 mt-auto md:grid-cols-2">
            {{-- <button class="flex items-center justify-center py-2 border rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                <span class="ml-1 text-uppercase whitespace-nowrap">Save it</span>
            </button> --}}
            <a href="{{route('purchase_requirements.show',$purchaserequirement->getRouteKey())}}" class="col-span-2 flex items-center justify-center py-2 text-white bg-primary hover:bg-primary_hover text-uppercase whitespace-nowrap rounded">Meet Now</a>
        </div>
    </div>
@endforeach
