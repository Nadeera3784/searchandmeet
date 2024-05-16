@extends('layouts.app')

@section('content')
    <div class="flex bg px-4 pt-20 min-h-screen relative">
        <div class="bg-white bg-opacity-60 inset-0 absolute"></div>
        <div class='overflow-x-auto w-full h-full my-10 md:w-10/12 mx-auto relative'>
            @include('components.alerts')
            <div class="grid grid-cols-1 gap-4 overflow-hidden py-5 bg-purple-800 bg-opacity-70 rounded-md px-4">
                <div class="w-full flex md:flex-row flex-col justify-between gap-3">
                    <h1 class="text-xl font-bold text-white">Meeting Request List</h1>
                    <a class="p-2 px-5 md:ml-0 ml-auto font-semibold bg-primary hover:bg-primary_hover text-white rounded-md focus:outline-none focus:ring-2 ring-blue-300 ring-offset-2" href="{{route('person.purchase_requirements.create')}}">Create New</a>
                </div>
                @if(count($purchase_requirements) == 0 )
                <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div class="text-xl font-semibold">
                        No Meeting Requirements Found
                    </div>
                </div>
                @endif
                @foreach($purchase_requirements as $purchase_requirement)
                <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center bg-gray-50 hover:bg-gray-100 shadow-md rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <h2 class="text-md font-bold">
                                {{$purchase_requirement->product}}
                            </h2>
                            @if($purchase_requirement->status === \App\Enums\PurchaseRequirementStatus::Unpublished)
                                <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">Unpublished</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 font-bold">
                            <span class="">Quantity : </span>
                            <span class="font-normal break-words">
                                {{$purchase_requirement->quantity}}
                                {{$purchase_requirement->metric->name}}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-bold  ">Category : </span>
                            <span class="break-words">
                                {{$purchase_requirement->category->name}}
                            </span>
                        </p>
                    </div>
                    <div class="md:ml-auto inline-flex flex-row flex-wrap md:items-center">
                        <p class="text-lg font-bold md:mr-3 w-full md:w-max mr-auto">$ {{number_format($purchase_requirement->price,2)}}
                        </p>
                        <a href="{{route('purchase_requirements.show', $purchase_requirement->getRouteKey())}}" class="mr-3 text-purple-800 transform hover:bg-purple-800 hover:text-purple-200 bg-purple-200 px-2 py-1 mt-1 rounded inline-flex w-max items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg> View</a>
                        <a href={{route('person.purchase_requirements.edit', $purchase_requirement->getRouteKey())}} class=" mr-3 text-orange-800 transform hover:bg-orange-800 hover:text-orange-200 bg-orange-200 px-2 py-1 mt-1 rounded inline-flex w-max items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                              </svg>
                              Edit</a>
                        <form action="{{route('person.purchase_requirements.delete', $purchase_requirement->getRouteKey())}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mr-3 text-pink-800 transform hover:bg-pink-800 hover:text-pink-200 bg-pink-200 px-2 py-1 mt-1 rounded flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                  </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="my-3 px-2">
                {{$purchase_requirements->links()}}
            </div>
        </div>
    </div>

@endsection
