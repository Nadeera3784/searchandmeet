<footer style="min-height: max-content" class="z-40  w-full max-w-screen-2xl py-12 bg-purple-500 bg mx-auto">
    <div style="height: max-content" class="w-10/12 mx-auto flex md:flex-row flex-col">
        <div class="inline-flex flex-col md:w-2/5 w-full">
            @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                <img src="{{asset('img/footer_logo.png')}}" class="w-40" alt="logo">
            @else
                <img src="{{asset('img/Logo-White.png')}}" class="w-40" alt="">
            @endif

            <div class="text-white mt-5 text-sm">
                <p class="font-bold text-base mb-3">Search Meetings Inc</p>
                <p class="mt-1">
                    1001 Wilshire Boulevard #1018, Los Angeles, CA 90017
                </p>
                <p class="mt-2">Phone: <a href="tel://+12133741550">+1 213-374-1550 #100</a></p>
                <p class="mt-2">Email: <a href="mailto://info@searchmeetings.com">info@searchmeetings.com</a></p>
            </div>
            @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
            <div class="text-white mt-5 text-sm border-t pt-4 mr-4">
                <p class="font-bold text-base mb-3">Hangzhou Biying Internet Technology Co.Ltd</p>
                <p class="mt-1">
                    #105, Xixing street, Binjiang, Hangzhou, Zhejiang, China
                </p>
                <p class="mt-2">Phone: <a href="tel://+8618606525631">+86 18606525631</a></p>
                <p class="mt-2">Email: <a href="mailto://sales@yingwaimao.com">sales@yingwaimao.com</a></p>
            </div>
            @endif
        </div>
        <div class="inline-flex flex-row flex-wrap md:w-3/5 w-full md:pl-4 pl-0 md:gap-5 gap-2 ">
            <div class="inline-flex flex-col md:w-3/6  w-full mt-6 md:mt-0">
                <p class=" text-white mt-2 text-lg uppercase">Quick Links</p>
                <div class=" text-white text-sm font-thin mt-5 flex md:flex-row flex-col gap-5 ">
                    <a href="{{route('person.login.show')}}">Login</a>
                    <a href="{{route('person.register.show')}}">Register</a>
                    <span class="cursor-pointer" @click="$dispatch('click-contact', '')">Contact</span>
                    <a href="{{route('purchase_requirements.search')}}">Search</a>
                    <a target="_blank" href="https://join.searchmeetings.com/">Join On</a>
                </div>
            </div>
            <div class="inline-flex flex-col md:w-2/6 w-full md:pl-3">
                <p class=" text-white mt-2 text-lg uppercase">Social Media</p>
                <div class=" text-white mt-5 flex flex-row gap-4">
                    <a target="_blank" href="https://www.facebook.com/searchmeetings">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 34.875 34.664">
                            <path id="Icon_awesome-facebook" data-name="Icon awesome-facebook" d="M35.438,18A17.438,17.438,0,1,0,15.275,35.227V23.041h-4.43V18h4.43V14.158c0-4.37,2.6-6.784,6.586-6.784a26.836,26.836,0,0,1,3.9.34V12h-2.2a2.52,2.52,0,0,0-2.841,2.723V18h4.836l-.773,5.041H20.725V35.227A17.444,17.444,0,0,0,35.438,18Z" transform="translate(-0.563 -0.563)" fill="#fff"/>
                        </svg>
                    </a>
                    <a target="_blank" href="https://www.linkedin.com/showcase/74128398/admin/">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 56 56">
                            <path id="Exclusion_1" data-name="Exclusion 1" d="M28,56A28.007,28.007,0,0,1,17.1,2.2,28.007,28.007,0,0,1,38.9,53.8,27.824,27.824,0,0,1,28,56Zm6.831-29.057c3.4,0,3.4,3.219,3.4,5.569V42.75H44.75V31.2c0-5.2-.948-10.006-7.825-10.006a6.9,6.9,0,0,0-6.179,3.4h-.092V21.719H24.392V42.75h6.523V32.336C30.915,29.669,31.38,26.943,34.831,26.943ZM13.77,21.719V42.75H20.3V21.719ZM17.033,11.25a3.8,3.8,0,1,0,3.782,3.783A3.787,3.787,0,0,0,17.033,11.25Z" transform="translate(0 0)" fill="#fff"/>
                        </svg>
                    </a>
                    <a target="_blank" href="https://twitter.com/searchmeetings?s=11">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 60 60">
                            <path id="Exclusion_2" data-name="Exclusion 2" d="M30,60A30.008,30.008,0,0,1,18.323,2.358,30.008,30.008,0,0,1,41.677,57.643,29.813,29.813,0,0,1,30,60ZM12.348,42.394h0a21.762,21.762,0,0,0,11.8,3.448C37.828,45.842,46,34.728,46,23.983c0-.327,0-.666-.024-1a16.42,16.42,0,0,0,3.854-3.973A15.341,15.341,0,0,1,45.41,20.2a7.66,7.66,0,0,0,3.378-4.234,15.216,15.216,0,0,1-4.876,1.856,7.69,7.69,0,0,0-13.3,5.256,8.608,8.608,0,0,0,.191,1.76A21.889,21.889,0,0,1,14.963,16.8a7.693,7.693,0,0,0,2.379,10.275,7.757,7.757,0,0,1-3.473-.975v.1a7.716,7.716,0,0,0,6.161,7.54A8.17,8.17,0,0,1,18.008,34a9.646,9.646,0,0,1-1.451-.119,7.7,7.7,0,0,0,7.183,5.328A15.311,15.311,0,0,1,14.2,42.488,15.778,15.778,0,0,1,12.348,42.394Z" transform="translate(0 0)" fill="#fff"/>
                        </svg>
                    </a>
                </div>
            </div>
            <!-- <div class="inline-flex flex-row md:w-8/12 w-full pt-6">
                <input type="text" class="h-9 px-3 py-2 border-0 bg-white text-sm w-full rounded-l-md" placeholder="Enter Email Address">
                <button class="h-9 px-4 py-2 border-0 bg-primary hover:bg-primary_hover text-white text-sm w-max rounded-r-md break-normal whitespace-nowrap">Request for Meeting</button>
            </div> -->
        </div>
    </div>
    <div style="height: max-content" class="flex md:flex-row flex-col gap-5 w-10/12 mx-auto mt-6 pt-3 border-t border-gray-400 text-white text-opacity-50 text-sm font-thin">
        <div class=" ">Copyright &copy; {{$domainDataService->checkIdentifier(config('domain.identifiers.china')) ? 'Meet now Inc.' : 'Search Meetings Inc.'}} All rights reserved.</div>
        <div class="flex gap-5">
            <a class="cursor-pointer hover:text-white hover:text-opacity-100" href="{{route('policy.privacy')}}">Privacy </a>
            <a class="cursor-pointer hover:text-white hover:text-opacity-100" href="{{route('policy.terms')}}">Terms of Use </a>
            <a class="cursor-pointer hover:text-white hover:text-opacity-100" href="{{route('code.conduct')}}">Code of Conduct </a>
        </div>
    </div>
</footer>
