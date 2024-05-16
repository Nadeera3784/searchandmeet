@extends('layouts.app')
@section('content')

    <div x-data="{filter:false,grid:false}" class="bg-gray-100 w-full h-full pb-8 ">
        <div
            x-show="filter"
            x-transition:enter="transition ease-in-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-x-20"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in-out duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 transform -translate-x-20"

            class="fixed z-10 top-0 left-0 w-screen h-screen bg-white max-h-screen overflow-y-auto p-5">
                <div  class="flex justify-end w-full mt-2 mr-3 ">
                    <button @click="filter=false" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @include('demo.search-grid.filters')
            </div>


        <div class="container mx-auto md:px-8 px-4 ">
           <div class="flex items-start flex-col md:flex-row pt-8 pt-20">
               <div class="md:w-1/5  w-full p-3 hidden md:block">
                   @include('demo.search-grid.filters')

               </div>
               <div  class="md:w-4/5  w-full p-3 ">
                   <div class="flex items-center justify-between">
                      <div class="flex items-center justify-between w-full">
                          <h3 class="text-gray-500  text-md">120 results for <span class="text-lg">UI Designer</span></h3>
                          <div class="flex items-center">

                               <span class="cursor-pointer" @click="grid=false" :class="grid?'text-gray-400':''">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                    </svg>
                              </span>

                              <span class="cursor-pointer" @click="grid=true" :class="grid?'':'text-gray-400'" class="ml-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </span>




                          </div>

                      </div>
                       <button @click="filter=true" class="ml-2 px-4 py-1 bg-white md:hidden cursor-pointer  rounded-sm border flex items-center justify-center">

                           <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                           </svg>
                           <span class="text-uppercase ml-1 whitespace-nowrap">Filter</span>
                       </button>

                   </div>

                   <template
                   x-if="grid"
                   >
                       <div class="grid gap-4 mt-5 xl:gap-x-8 grid-cols-1 md:grid-cols-2 xl:grid-cols-3  w-full mt-3">
                           @for($i=1;$i<11;$i++)
                               @include('demo.search-grid.tile-card')
                           @endfor
                       </div>
                   </template>
                   <template
                   x-if="!grid"
                   >
                     <div class="mt-5">
                         @for($i=1;$i<11;$i++)
                             @include('demo.search-grid.list-card')
                         @endfor
                     </div>
                   </template>



               </div>
           </div>
        </div>




    </div>





@endsection
