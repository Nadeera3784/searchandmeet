@extends('layouts.app')

@section('content')
<div class="bg-gray-50  pb-8">
    <div class="container mx-auto pt-24">
        <div>
            <a href="" class="flex items-center px-4 width-fit-content">
                <span class="bg-white shadow rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
                <span class="text-sm font-bold ml-2 text-gray-500">Back</span>
            </a>
        </div>

        <div class="flex items-start md:flex-row flex-col">
            <div class="md:w-1/4 w-full px-5 pt-5 pb-0 md:pb-5">
                <p class="text-xl font-bold mb-5">Other Profile</p>
               <div class="md:block hidden">
                   @for($i=0;$i<8;$i++)
                       @include('demo.profile.single-other-profile')

                   @endfor
               </div>
                <div class="owl-carousel owl-theme   md:hidden block">
                    @for($i=0;$i<8;$i++)
                      @include('demo.profile.single-other-profile')

                    @endfor
                </div>

            </div>
            <div class="md:w-2/4 w-full p-5  pt-0">
                <div class="bg-white shadow p-5 mt-5 md:px-8 rounded-lg">
                    <p class="text-lg font-bold mb-4">Contact Information</p>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Contact Name</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Juan Manuel Calderon</div>
                    </div>
                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Title</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">CEO</div>
                    </div> <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Email</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">jmc@jcm.com</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Mobile</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">123-1234-12345</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Category T1,T2,T3</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Category T1</div>
                    </div>





                    <p class="text-lg font-bold my-8">Purchasing Requirment</p>

                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Categories</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Category A</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Product</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Product B</div>
                    </div> <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Detailed Description</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Detailed Description - more text please</div>
                    </div>
                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Purchase Quantity</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">100000</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Preferred Unit Price</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Wagons</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Purchase Value USD</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">10,000</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Product URL</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">www.samplelink.com</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Images</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4 grid md:grid-cols-4 grid-cols-2 gap-4">

                            @for($i=0;$i<8;$i++)
                                <img class="w-full object-cover max-h-24" src="https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NXx8Z2lybHxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60" alt="image">
                            @endfor

                        </div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Pre-Meeting Samples</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">sample</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Trade Terms</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Cash Down</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Cash Down</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Sample Terms</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Certification Requirment</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Nothing</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">HS Code</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">ABC-1234-DEF</div>
                    </div>




                    <p class="text-lg font-bold my-8">Company Information</p>

                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Company</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Juan Manuel Calderon</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Company Type</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Wholesaler</div>
                    </div> <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Current Importer</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Importer</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Phone Number</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">123-1234-12345</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Website</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">sample.website.com</div>
                    </div>
                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">LinkedIn Profile</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">someurlforlinkedin.com</div>
                    </div>
                    <div class="flex ">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Facebook Business Profile</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">fbbusiness.link.com</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Address</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">street address</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">City</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Some City</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">State</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Uptown State</div>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4 bg-gray-100 md:w-1/4 w-2/5">Country</div>
                        <div class="px-3 py-4 bg-gray-50 w-3/4">Some Country</div>
                    </div>





            </div>
            </div>
            <div class="md:w-1/4 w-full p-5 md:px-8">
                <div class="bg-white shadow rounded-lg p-5 py-8">
                    <img class="w-16 h-16 mx-auto rounded-full object-cover" src="https://images.unsplash.com/photo-1513207565459-d7f36bfa1222?ixid=MnwxMjA3fDB8MHxzZWFyY2h8N3x8Z2lybHxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=60" alt="user">
                    <p class="text-center truncate text-gray-500">Purchasing Requirment</p>
                    <h3 class="text-center font-bold text-xl mt-3">CATEGORY T3 Product</h3>
                    <p class="text-center text-sm text-gray-500 mt-2">Detailed Description - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget odio molestie sem tincidunt congue sed eget odio.</p>
                </div>
                <div class="bg-white shadow rounded-lg mt-5   border-gray-200  p-5 py-8">
                    <p class="text-center font-bold text-xl text-primary">Meet & Close The Deal</p>
                    <p class="text-center text-sm text-gray-400 mt-2">Select one of the available time slots or request a new time</p>
                    <select  placeholder="Country" class="block w-full mt-3 ml-2 text-sm p-2 pl-10 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300 ">
                        <option value="" hidden>Available Slot</option>
                        <option value="value 1">value 1</option>
                        <option value="value 2">value 2</option>
                        <option value="value 3">value 3</option>
                        <option value="value 4">value 4</option>
                        <option value="value 5">value 5</option>
                    </select>

                    <p class="text-center font-bold text-xl text-primary mt-3">Meeting With Host</p>
                    <p class="text-center font-bold text-xl mt-1">$200</p>

                    <select  placeholder="Country" class="block w-full mt-3 ml-2 text-sm p-2 pl-10 bg-white focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300 ">
                        <option value="" hidden>Meeting With Host</option>
                        <option value="value 1">value 1</option>
                        <option value="value 2">value 2</option>
                        <option value="value 3">value 3</option>
                        <option value="value 4">value 4</option>
                        <option value="value 5">value 5</option>
                    </select>

                    <a class="text-sm mt-5 font-medium font-semibold w-full block text-center py-3 border-r  bg-primary text-white rounded-sm " href="#">Sign Up</a>

                </div>
                <div class="bg-white shadow rounded-lg mt-5   border-gray-200  p-5 py-8">

                    <p class="text-center text-sm text-gray-400 mt-2">Get a professional consultant to call, organize and host the meeting.</p>
                    <ul class="text-gray-500 mt-5 list-outside px-4">
                        <li class="py-2 ">Access Information</li>
                        <li class="py-2 ">Meeting Management Dashboard</li>
                        <li class="py-2 ">Pick an available time</li>
                        <li class="py-2 ">Request Hoted Meeting</li>
                        <li class="py-2 ">Organize, follow up and facilitate the meeting</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
