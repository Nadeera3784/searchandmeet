@extends('layouts.app')

@section('content')
    <div class="bg-gray-50  pb-8">
        <div class="container mx-auto pt-24">
            <div class="xl:ml-32">
                <a href="" class="flex md:ml-2 items-center px-4 width-fit-content ">
                <span class="bg-white shadow rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
                    <span class="text-sm font-bold ml-2 text-gray-500">Back</span>
                </a>
            </div>

            <div class="flex items-start justify-center md:flex-row flex-col mx-auto w-full xl:w-4/5">

                <div class="lg:w-3/4 md:w-3/5 mx-auto w-full p-5 md:px-8">
                    <div class="bg-white shadow rounded-lg p-5 py-8">
                        <h3 class="text-xl font-bold px-4 mb-3">Summery</h3>
                        <img class="w-24 h-24 mx-auto rounded-full object-cover" src="https://images.unsplash.com/photo-1513207565459-d7f36bfa1222?ixid=MnwxMjA3fDB8MHxzZWFyY2h8N3x8Z2lybHxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60" alt="user">
                        <p class="text-center truncate text-gray-500">Purchasing Requirment</p>
                        <h3 class="text-center font-bold text-xl mt-3">CATEGORY T3 Product</h3>
                        <p class="text-sm text-gray-500 mt-2 px-4">Detailed Description - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget odio molestie sem tincidunt congue sed eget odio.</p>
                        <hr class="my-5">

                        <div class="text-gray-500 mt-5  px-4 grid md:grid-cols-2 grid-cols-1">
                            <div class="py-2 ">Available Slot</div>
                            <div class="py-2 ">Meeting With Host</div>
                            <div class="py-2 ">Pick an available time</div>
                            <div class="py-2 ">Request Hoted Meeting</div>
                            <div class="py-2 ">Organize, follow up and facilitate the meeting</div>
                        </div>

                    </div>

                </div>

                <div class="lg:w-1/4 md:w-2/5 w-full p-5">
                    <div class="bg-white shadow rounded-lg p-5 ">
                        <h3 class="font-bold text-xl mt-3">Checkout</h3>
                        <p class="font-bold text-xl mt-3"><span class="text-gray-600 mr-2 font-light">Total</span>100$</p>

                        <form action="">
                            <p class="text-sm text-gray-500 mt-3">Enter Card Number</p>
                            <input type="text" placeholder="xxxx-xxxx-xxxx" class="block w-full  text-sm mt-2 bg-gray-100 focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300 ">
                            <button class="text-sm mt-5 font-medium font-semibold w-full block text-center py-3 border-r  bg-primary text-white rounded-sm " >Checkout</button>
                        </form>
                   </div>

                </div>


            </div>
        </div>
    </div>
@endsection

