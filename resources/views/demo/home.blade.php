@extends('layouts.app')

@section('content')



<div>
    <div class="container mx-auto">
        <div class=" flex items-center md:flex-row flex-col min-h-screen relative">
            <div class="md:w-2/4 w-full mt-5 md:mt-0">
                <div class="md:w-10/12 w-full px-4 mx-auto  px-6" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                    <h3 class="text-6xl font-bold tracking-wider">Get hired by the popular teams.</h3>
                    <p class="text-gray-500  tracking-wide text-lg mt-8">Creating a beautiful job website is not easy always. To make your life easier, we are introducing Jobcamp template.</p>
                </div>
            </div>
            <div class="md:w-2/4 w-full flex mt-5 md:mt-0 px-4 md:px-0" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                <img class="rounded-lg object-cover md:w-10/12 w-full  md:h-screen " src="/img/hero-image-1.png" alt="hero-image-1.png">
                <img class="md:block hidden rounded-lg object-cover bg-center w-2/12  h-screen ml-5" src="/img/hero-image-2.png" alt="hero-image-2hero-image-2.png.png">

            </div>

            <div data-aos="fade-right" data-aos-duration="500" data-aos-once="true" class="md:w-3/5 w-full mt-5 md:mt-0 bg-white relative   md:absolute z-20 md:bottom-12 md:left-16 shadow px-4 py-4">
                @include('demo.components.searchFilter')
            </div>


        </div>

        <h3 class="mt-16 block md:w-2/4 w-full font-bold text-4xl text-center mx-auto">Easy steps to land your next job</h3>

        <p class="mt-3 block md:w-2/4 w-full text-gray-400  text-center mx-auto">Creating a beautiful job website is not easy always. To make your life easier, we are introducing Jobcamp template.</p>


        <div class="grid md:grid-cols-3 grid-cols-1 gap-4 gap-x-6 pt-6 pb-10 mt-8">
            <div  class="p-8" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
             <div class="bg-blue-600 width-fit-content mx-auto  p-8 rounded-lg">
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" width="38" height="38" viewBox="0 0 38 38">
                     <g>
                         <g>
                             <path fill="#fff" d="M15.545 19a3.455 3.455 0 1 0 6.91 0 3.455 3.455 0 0 0-6.91 0zm13.819 0c0 5.724-4.64 10.364-10.364 10.364-5.724 0-10.364-4.64-10.364-10.364 0-5.724 4.64-10.364 10.364-10.364 5.724 0 10.364 4.64 10.364 10.364zM17.273 0v5.289A13.825 13.825 0 0 0 5.289 17.273H0v3.454l5.289.002a13.825 13.825 0 0 0 11.984 11.982V38h3.454l.002-5.289A13.825 13.825 0 0 0 32.711 20.73L38 20.727v-3.454h-5.289A13.825 13.825 0 0 0 20.73 5.289L20.727 0z"/>
                         </g>
                     </g>
                 </svg>
             </div>
                <h3 class="text-center font-bold text-lg mt-8">Register Your Account</h3>
                <p class="text-center text-gray-500 mt-5">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital.</p>
            </div>


            <div class="p-8" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                <div class="bg-red-600 width-fit-content mx-auto  p-8 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" width="28" height="36" viewBox="0 0 28 36">
                        <g>
                            <g>
                                <path fill="#fff" d="M14 17.333a6.665 6.665 0 0 0 6.667-6.666A6.665 6.665 0 0 0 14 4a6.665 6.665 0 0 0-6.667 6.667A6.665 6.665 0 0 0 14 17.333zm0 3.334c-5.525 0-10-4.475-10-10s4.475-10 10-10 10 4.475 10 10-4.475 10-10 10zm-1.667 11.666v-6.528a10.015 10.015 0 0 0-7.765 6.528zm3.334-6.528v6.528h7.765a10.015 10.015 0 0 0-7.765-6.528zm-15 9.862c0-7.364 5.97-13.334 13.333-13.334 7.364 0 13.333 5.97 13.333 13.334z"/>
                            </g>
                        </g>
                    </svg>
                </div>
                <h3 class="text-center font-bold text-lg mt-8">Apply for New Jobs</h3>
                <p class="text-center text-gray-500 mt-5">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative approaches.</p>
            </div>


            <div class="p-8" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                <div class="bg-yellow-400 width-fit-content mx-auto  p-8 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" width="38" height="36" viewBox="0 0 38 36">
                        <g>
                            <g>
                                <path fill="#fff" d="M17.767 15.107l-.152.143a1.68 1.68 0 0 1-2.315-.143l-.136-.16a1.91 1.91 0 0 1 .136-2.439l5.551-5.846.267-.268c3.154-3.025 8.023-2.845 10.967.405 2.945 3.25 2.887 8.381-.13 11.556l-1.236 1.297-7.4-7.794a1.683 1.683 0 0 0-2.468 0zM6.046 6.662l.269-.269c2.853-2.734 7.169-2.88 10.183-.347L12.831 9.91c-2.044 2.154-2.043 5.644.002 7.797 2.045 2.152 5.359 2.151 7.403-.002l1.849-1.948 6.167 6.495L19 31.998 6.046 18.355l-.255-.283c-2.82-3.265-2.709-8.288.255-11.41zM3.579 4.064C-.611 8.476-.87 15.542 2.986 20.28l13.546 14.315.191.186c1.385 1.254 3.453 1.172 4.744-.188l13.548-14.313c3.858-4.743 3.594-11.816-.605-16.226-4.198-4.41-10.914-4.67-15.408-.594-4.498-4.083-11.225-3.82-15.423.603z"/>
                            </g>
                        </g>
                    </svg>
                </div>
                <h3 class="text-center font-bold text-lg mt-8">Get Hired Immediately</h3>
                <p class="text-center text-gray-500 mt-5">Capitalize on low hanging fruit to identify a ballpark value added activity to beta test. Override the digital.</p>
            </div>


        </div>


    </div>

    <div class="bg-gray-100 w-full pt-12">
        <div class="container mx-auto py-8">
            <h3 class="text-4xl font-bold text-center">Featured Buyers</h3>
            <p class="text-gray-500 w-full md:w-2/5 text-center mx-auto mt-5">Creating a beautiful job website is not easy always. To make your life easier, we are introducing Jobcamp template.</p>

        <div class="grid md:grid-cols-3 grid-cols-1 gap-6 p-5 mt-10" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">

            <div class="rounded-md bg-white p-5 hover:shadow-lg">
                <div class=" flex items-center">
                    <div class="bg-pink-500 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" width="21" height="21" viewBox="0 0 21 21">
                            <g>
                                <g>
                                    <path fill="#fff" d="M20.354.646C20.256.55 20.11.5 19.914.5 19.475.549 9.225 2.306 5.027 6.504c-3.221 3.221-3.026 6.833-2.489 8.98l5.027-3.416c.245-.147.537.146.293.39L.146 20.17a.472.472 0 0 0 0 .684.443.443 0 0 0 .342.146.443.443 0 0 0 .342-.146l3.026-3.027c.634.293 2.196.928 4.198.928 2.44 0 4.636-.928 6.491-2.782 4.49-4.49 5.906-14.497 5.955-14.936a.554.554 0 0 0-.146-.39z"/>
                                </g>
                            </g>
                        </svg>
                    </div>

                    <div class="p-5">
                        <p class="text-md text-gray-500">Mexico</p>
                        <h4 class="text-xl font-bold mt-1">Sample Company Name</h4>
                        <p class="text-lg text-gray-500 font-semibold mt-1">Mobile Phone Keypads</p>

                        <p class="text-lg font-bold mt-3">Quantity: <span class="text-gray-500 font-light">10,000</span></p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8">
                    <div class="flex items-center justify-between">
                        <div class="bg-blue-100 flex items-center px-4 py-2 width-fit-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-blue-600 ml-2 text-xs" >Upcoming</span>
                        </div>

                        <div class="bg-purple-100 flex items-center px-8 py-2 width-fit-content ml-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="text-purple-600 ml-2 text-xs" >VIP</span>
                        </div>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="rounded-md bg-white p-5 hover:shadow-lg">
                <div class=" flex items-center">
                    <div class="bg-blue-500 p-2 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" width="38" height="10" viewBox="0 0 38 10">
                            <g>
                                <g>
                                    <g>
                                        <text dominant-baseline="text-before-edge" style="font-kerning:normal" fill="#fff" font-family="'Inter','Inter-Bold'" font-size="12" font-style="none" font-weight="700" transform="translate(-1 -2)">
                                            <tspan>Fimize</tspan>
                                        </text>
                                    </g>
                                </g>
                            </g>
                        </svg>

                    </div>

                    <div class="p-5">
                        <p class="text-md text-gray-500">Mexico</p>
                        <h4 class="text-xl font-bold mt-1">Sample Company Name</h4>
                        <p class="text-lg text-gray-500 font-semibold mt-1">Mobile Phone Keypads</p>

                        <p class="text-lg font-bold mt-3">Quantity: <span class="text-gray-500 font-light">10,000</span></p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8">
                    <div class="flex items-center justify-between">
                        <div class="bg-orange-100 flex items-center px-4 py-2 width-fit-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600" height="24px" viewBox="0 0 24 24" width="24px" stroke="currentColor" fill="none">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z"/>
                            </svg>

                            <span class="text-orange-600 ml-2 text-xs" >new</span>
                        </div>

                        <div class="bg-purple-100 flex items-center px-8 py-2 width-fit-content ml-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="text-purple-600 ml-2 text-xs" >VIP</span>
                        </div>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="rounded-md bg-white p-5 hover:shadow-lg">
                <div class=" flex items-center">
                    <div class="bg-blue-200 p-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" width="20" height="21" viewBox="0 0 20 21">
                            <g>
                                <g>
                                    <path fill="#fff" d="M.466 19.774c.066.262.328.393.59.393h18.356c.393 0 .656-.262.656-.655C20.068 9.022 11.545.5 1.056.5.86.5.663.631.532.762.4.96.335 1.222.466 1.418c.066.13 5.048 12.783.131 17.635-.196.196-.262.459-.13.72z"/>
                                </g>
                            </g>
                        </svg>

                    </div>

                    <div class="p-5">
                        <p class="text-md text-gray-500">Mexico</p>
                        <h4 class="text-xl font-bold mt-1">Sample Company Name</h4>
                        <p class="text-lg text-gray-500 font-semibold mt-1">Mobile Phone Keypads</p>

                        <p class="text-lg font-bold mt-3">Quantity: <span class="text-gray-500 font-light">10,000</span></p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8">
                    <div class="flex items-center justify-between">
                        <div class="bg-blue-100 flex items-center px-4 py-2 width-fit-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-blue-600 ml-2 text-xs" >Upcoming</span>
                        </div>

                        <div class="bg-purple-100 flex items-center px-8 py-2 width-fit-content ml-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="text-purple-600 ml-2 text-xs" >VIP</span>
                        </div>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>

            </div>


            <div class="rounded-md bg-white p-5 hover:shadow-lg">
                <div class=" flex items-center">
                    <div class="bg-yellow-300 p-4 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" width="14" height="17" viewBox="0 0 14 17">
                            <g>
                                <g>
                                    <g>
                                        <text dominant-baseline="text-before-edge" style="line-height:34px;font-kerning:normal" fill="#fff" font-family="'Inter','Inter-Bold'" font-size="21" font-style="none" font-weight="700" letter-spacing="-.21" transform="translate(-1 -4)">
                                            <tspan>K</tspan>
                                        </text>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>

                    <div class="p-5">
                        <p class="text-md text-gray-500">Mexico</p>
                        <h4 class="text-xl font-bold mt-1">Sample Company Name</h4>
                        <p class="text-lg text-gray-500 font-semibold mt-1">Mobile Phone Keypads</p>

                        <p class="text-lg font-bold mt-3">Quantity: <span class="text-gray-500 font-light">10,000</span></p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8">
                    <div class="flex items-center justify-between">
                        <div class="bg-orange-100 flex items-center px-4 py-2 width-fit-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600" height="24px" viewBox="0 0 24 24" width="24px" stroke="currentColor" fill="none">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z"/>
                            </svg>

                            <span class="text-orange-600 ml-2 text-xs" >new</span>
                        </div>

                        <div class="bg-purple-100 flex items-center px-8 py-2 width-fit-content ml-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="text-purple-600 ml-2 text-xs" >VIP</span>
                        </div>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="rounded-md bg-white p-5 hover:shadow-lg">
                <div class=" flex items-center">
                    <div class="bg-orange-500 p-4 rounded-xl">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" width="16" height="24" viewBox="0 0 16 24">
                            <g>
                                <g>
                                    <path fill="#fff" d="M14.77 7.258H9.335l1.852-6.48a.51.51 0 0 0-.49-.65h-7.13a.51.51 0 0 0-.492.375L.018 11.708a.51.51 0 0 0 .491.644h5.502L4.083 22.956a.51.51 0 0 0 .925.374L15.195 8.05a.508.508 0 0 0-.424-.792z"/>
                                </g>
                            </g>
                        </svg>

                    </div>

                    <div class="p-5">
                        <p class="text-md text-gray-500">Mexico</p>
                        <h4 class="text-xl font-bold mt-1">Sample Company Name</h4>
                        <p class="text-lg text-gray-500 font-semibold mt-1">Mobile Phone Keypads</p>

                        <p class="text-lg font-bold mt-3">Quantity: <span class="text-gray-500 font-light">10,000</span></p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8">
                    <div class="flex items-center justify-between">
                        <div class="bg-orange-100 flex items-center px-4 py-2 width-fit-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600" height="24px" viewBox="0 0 24 24" width="24px" stroke="currentColor" fill="none">
                                <path d="M0 0h24v24H0V0z" fill="none"/>
                                <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6h-6z"/>
                            </svg>

                            <span class="text-orange-600 ml-2 text-xs" >new</span>
                        </div>

                        <div class="bg-purple-100 flex items-center px-8 py-2 width-fit-content ml-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="text-purple-600 ml-2 text-xs" >VIP</span>
                        </div>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>

            </div>

            <div class="rounded-md bg-white p-5 hover:shadow-lg">
                <div class=" flex items-center">
                    <div class="bg-purple-500 p-2 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mx-auto" width="36" height="11" viewBox="0 0 36 11">
                            <g>
                                <g>
                                    <g>
                                        <text dominant-baseline="text-before-edge" style="font-kerning:normal" fill="#fff" font-family="'Inter','Inter-Bold'" font-size="13" font-style="none" font-weight="700" transform="translate(0 -2)">
                                            <tspan>Asios</tspan>
                                        </text>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>

                    <div class="p-5">
                        <p class="text-md text-gray-500">Mexico</p>
                        <h4 class="text-xl font-bold mt-1">Sample Company Name</h4>
                        <p class="text-lg text-gray-500 font-semibold mt-1">Mobile Phone Keypads</p>

                        <p class="text-lg font-bold mt-3">Quantity: <span class="text-gray-500 font-light">10,000</span></p>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-8">
                    <div class="flex items-center justify-between">
                        <div class="bg-blue-100 flex items-center px-4 py-2 width-fit-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-blue-600 ml-2 text-xs" >Upcoming</span>
                        </div>

                        <div class="bg-purple-100 flex items-center px-8 py-2 width-fit-content ml-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            <span class="text-purple-600 ml-2 text-xs" >VIP</span>
                        </div>

                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>

            </div>







        </div>


            <div class="width-fit-content mx-auto py-12">
                <a href="#" class="mx-auto width-fit-content flex items-center text-red-600">
                    <span class="text-uppercase text-center text-sm font-semibold ">SEE 1,294 MORE BUYERS</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>

                </a>
            </div>

        </div>
    </div>

    <div class="container mx-auto mt-24 bg-gray-50">
    <div class="flex md:flex-row flex-col p-5">
        <div class="md:w-2/4 w-full px-5" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
            <div class="w-3/4 md:mx-auto  relative md:h-full h-80 bg-cover bg-no-repeat rounded-lg" style="background-image: url('/img/content-1-img1.png')">
                <img class="md:w-48 w-40 md:h-48 h-40 border border-white absolute right-0 top-0 transform translate-x-2/4 md:translate-y-3/4 translate-y-2/4 -rotate-12" src="/img/content-1-img2.png" alt="" style="border-width: 10px">
            </div>
        </div>
        <div class="md:w-2/4 w-full p-5  md:px-24" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
           <h3 class="text-4xl font-bold leading-normal">Over <span class="text-red-500">50k+ people</span> landed their first job from Jobcamp.</h3>
            <p class="text-gray-500 mt-5">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative things to strategy foster collaborative thinking.</p>

            <a href="#" class="width-fit-content flex items-center text-red-600 py-8">
                <span class="text-uppercase  text-sm font-semibold ">Learn More</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>

            </a>

            <div class="flex py-5">
                <img class="w-12 h-12 rounded-full" src="/img/media-img1.png" alt="user">
                <div class="px-5">
                    <p>“Duis pretium gravida enim, vel maximus ligula fermentum a. Sed rhoncus eget ex id egestas. Nam nec nisl placerat, tempus erat a, condimentum metus.”</p>

                    <p class="text-sm font-bold mt-8">Davis Jones</p>
                    <p class="text-sm text-gray-500 mt-1">Full-Stack Developer</p>

                </div>
            </div>


        </div>
    </div>

    <div class="flex md:flex-row flex-col p-5 items-center mt-16">

        <div class="md:w-2/4 w-full p-5  md:px-24" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
            <h3 class="text-4xl font-bold leading-normal">Join companies from anywhere in the world.</h3>
            <p class="text-gray-500 mt-5">Leverage agile frameworks to provide a robust synopsis for high level overviews. Iterative things to strategy foster collaborative thinking.</p>

            <a href="#" class="width-fit-content flex items-center text-red-600 py-8">
                <span class="text-uppercase  text-sm font-semibold ">Learn More</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>

            </a>
        </div>

        <div class="grid gap-6 grid-cols-2 " data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
            <img class="h-60 rounded-lg w-full object-cover" src="/img/content-2-img1.png" alt="content-2-img1.png">
            <img class="h-60 rounded-lg w-full object-cover transform translate-y-1/4" src="/img/content-2-img2.png" alt="content-2-img2.png">
            <img class="h-60 rounded-lg w-full object-cover " src="/img/content-2-img3.png" alt="content-2-img3.png">
            <img class="h-36 rounded-lg w-full object-cover transform translate-y-2/4" src="/img/content-2-img1.png" alt="content-2-img1.png">
        </div>


    </div>


</div>

    <div class="bg-gray-700">
        <div class="container mx-auto py-12" data-aos="fade-in" data-aos-duration="800" data-aos-once="true">
            <h3 class="text-4xl font-bold text-center  text-white">Hear what people say about us</h3>

            <div class="owl-carousel owl-theme mt-12 px-4">
                @for($i=0;$i<10;$i++)
                <div class="w-full md:w-3/4 mx-auto flex md:flex-row flex-col items-center rounded-lg bg-white">
                    <img class="w-full md:w-2/5 rounded-lg" src="/img/testimonial.png" alt="user">
                    <div class="w-full md:w-3/5 p-6 px-16">

                        <img src="/img/testimonial-brand-logo.png" class="bg-contain h-5  " alt="logo">
                        <p class="text-gray-600 text-lg mt-8">“Being a small
                            but
                            growing brand, we have to definitely do a lot more with less. And when
                            you want to create a business bigger than yourself, you’re going to need
                            help. And that’s what Jobcamp does.”</p>


                        <p class="font-bold mt-8">Brandon & Rivera</p>

                        <p class="mt-2">Co-founders of Greener</p>

                    </div>
                </div>
                @endfor
            </div>






        </div>
    </div>


    <script>


    </script>

</div>


@endsection
