<div x-data="{filter:false}" @click.away="filter=false" class="w-full h-full">
    <form action="">
        <div class="flex items-center mb-4 md:mb-0 md:flex-row  flex-col">
            <div class="md:grid grid-cols-2  gap-x-4 gap-y-3  md:w-4/5 w-full">

                <div class="relative mb-3 md:mb-0">
                    <input type="text" placeholder="Search for Category" class="block w-full  text-sm p-2 pl-10 bg-gray-100 focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300 ">
                    <div  class="absolute inset-y-0 left-0 pl-3 flex items-center text-sm leading-5">
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-gray-500 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>


                <div class="relative mb-3 md:mb-0">
                    <select  placeholder="Country" class="block w-full  text-sm p-2 pl-10 bg-gray-100 focus:bg-gray-100 border-solid border border-gray-200 focus:outline-none rounded focus:border-primary  dark:border-black-500 dark:bg-black-400 dark:text-gray-300 ">
                        <option value="" hidden>Country</option>
                        <option value="value 1">value 1</option>
                        <option value="value 2">value 2</option>
                        <option value="value 3">value 3</option>
                        <option value="value 4">value 4</option>
                        <option value="value 5">value 5</option>
                    </select>
                    <div  class="absolute inset-y-0 left-0 pl-3 flex items-center text-sm leading-5">
                        <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-gray-500 dark:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div @click="filter=!filter"  class="col-span-2   border relative">
                    <div class="flex justify-between p-1 px-2 text-gray-400 cursor-pointer bg-gray-100">
                        <p class="">Filter</p>

                        <span>
                                <svg x-show="!filter" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                               <svg x-show="filter" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                        </span>
                    </div>
                </div>

            </div>
            <div class="md:w-1/5 w-full md:px-2 mt-3 md:mt-0">
                <button class="bg-primary text-white px-4 py-2 w-full">Search</button>
            </div>
        </div>
        <div x-show="filter"
             x-transition:enter="transition ease-in-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="w-full left-0  z-10 bg-white top-32 md:top-24   mt-8 border-t border-gray-200  p-5 absolute shadow-lg">
            <p class="font-bold text-lg py-2">Availability for Meetings</p>
            <div class="flex items-center md:flex-row  flex-col">
                <div class="grid gap-4 md:grid-cols-3 grid-cols-2 md:w-3/4 w-full">
                    <label>
                        <input type="checkbox" class="text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray">
                        <span class="ml-1 text-gray-500 cursor-pointer font-semibold">Today</span>
                    </label>

                    <label>
                        <input type="checkbox" class="text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray">
                        <span class="ml-1 text-gray-500 cursor-pointer font-semibold">This Week</span>
                    </label>

                    <label>
                        <input type="checkbox" class="text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray">
                        <span class="ml-1 text-gray-500 cursor-pointer font-semibold ">Next Month</span>
                    </label>

                    <label>
                        <input type="checkbox" class="text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray">
                        <span class="ml-1 text-gray-500 cursor-pointer font-semibold">Tomorrow</span>
                    </label>

                    <label>
                        <input type="checkbox" class="text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray">
                        <span class="ml-1 text-gray-500 cursor-pointer font-semibold">This Month</span>
                    </label>

                    <label>
                        <input type="checkbox" class="text-lg form-checkbox transition duration-150 ease-in-out text-primary form-radio focus:border-primary focus:outline-none focus:shadow-outline-primary dark:focus:shadow-outline-gray">
                        <span class="ml-1 text-gray-500 cursor-pointer font-semibold">All</span>
                    </label>

                </div>
                <div class="md:w-1/4 w-full md:mt-0 mt-3">
                    <button class="border mx-auto block px-4 py-2 rounded-sm border-gray-500">By date</button>
                </div>
            </div>
        </div>
    </form>
</div>
