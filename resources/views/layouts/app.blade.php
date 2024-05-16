<!doctype html>
<html lang="en">
@inject('domainDataService', 'App\Services\Domain\DomainDataService')
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KKC77QL');</script>
    <!-- End Google Tag Manager -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.cdnfonts.com/css/harabara" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/avenir-lt-std" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/app.css"/>
    <link rel="stylesheet" type="text/css" href="/css/owl.carousel.min.css">

    <link rel="icon" href="/img/favicon.svg" sizes="any" type="image/x-icon">

    @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
        <title>Meet now | On-Demand Business meetings. Businesses seeking to meet and connect from around the world</title>
    @else
        <title>Search Meetings | On-Demand Business meetings. Businesses seeking to meet and connect from around the world</title>
    @endif

    <meta type="description" content="Search among thousands of meeting requests with purchase requirements, pick an available time and meet the decision makers directly on video meetings, or just post your meeting request FREE."/>
    <meta type="keywords" content="search,meetings,global,business,import,export,meet,now"/>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("contact-form").submit();
        }
    </script>
</head>
@inject('domainDataService', 'App\Services\Domain\DomainDataService')
<body
x-data="{showContactUs:{{request()->has('contact_open') ? 'true' : 'false'}}, showInquiryForm:false}"
@click-contact="showContactUs=true"
@click-inquiry="showInquiryForm=true"
class="font-secondary tracking-wide">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KKC77QL"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

@include('components.toaster')
<div
x-show="showContactUs"
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 transform scale-90"
x-transition:enter-end="opacity-100 transform scale-100"
x-transition:leave="transition ease-in duration-300"
x-transition:leave-start="opacity-100 transform scale-100"
x-transition:leave-end="opacity-0 transform scale-90"
class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center z-50 ">
    <div class="modal-overlay absolute w-full h-full z-50"></div>

    <div  class="modal-container  bg-white w-5/12 md:w-5/12 md:mx-auto rounded-lg shadow-lg z-50 overflow-y-auto mx-3">

        <div  class="modal-content text-left w-full mx-auto relative flex">
            <div class="overflow-hidden hidden md:block w-3/6 md:w-3/6">
                <div  class="h-full w-80 relative flex flex-col justify-around overflow-hidden bg-gray-100">
                    <div class="inline-flex flex-col w-full px-6 py-4"  style="z-index: 2;">
                        @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                            <img src="{{asset('img/meetco-logo.png')}}" class="w-40" alt="">
                        @else
                            <img src="{{asset('./img/logo.svg')}}" class="w-40" alt="">
                        @endif
                    </div>
                    <div class="inline-flex flex-col w-full px-6 py-4"  style="z-index: 2;">
                        <div class="text-gray-900 mt-5 text-sm">
                            <p class="font-bold text-base mb-3">Search Meetings Inc</p>
                            <p class="mt-1">
                                1001 Wilshire Boulevard #1018,<br/> Los Angeles, CA 90017
                            </p>
                            <p class="mt-2">Phone: <a href="tel://+12132677303">+1 213 267 7303</a></p>
                            <p class="mt-2">Email: <a href="mailto://info@searchmeetings.com">info@searchmeetings.com</a></p>
                        </div>
                    </div>
                    <div class="inline-flex flex-col w-full px-6 py-4">
                        <div class=" text-gray-900 mt-5 text-sm font-thin">Copyright &copy; Search Meetings Inc.</div>
                        <div class=" text-gray-900 mt-1 text-sm font-thin">All rights reserved.</div>
                    </div>
                </div>
            </div>

            <div class="py-8 px-9 w-full md:w-full ">
                <div class="flex justify-between items-center ">
                <p class="text-2xl font-bold mr-8 text-primary">Contact Us</p>
                <div class="modal-close cursor-pointer z-50 ml-auto" @click="showContactUs=false">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                    <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
                </div>

                <div class="">
                    {!! Form::open(['url' => route('support.contact'), 'class' => 'modal_form', 'id' => 'contact-form']) !!}
                    <div class="grid grid-cols-1 md:grid-cols-2  justify-end py-4 gap-3">

                        <div class="w-full">
                            {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('name', old('name'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.name" x-text="errors.name ? errors.name[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>
                        <div class="w-full">
                            {!! Form::label('business_name', 'Business Name', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('business_name', old('business_name'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.b_name" x-text="errors.b_name ? errors.b_name[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>

                        <div class="w-full md:col-span-2">
                            {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('email', old('email'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>
                        <div class="w-full">
                            {!! Form::label('mobile', 'Mobile', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('mobile', old('mobile'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.mobile" x-text="errors.mobile ? errors.mobile[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>
                        <div class="w-full">
                            {!! Form::label('country', 'Country', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('country', old('country'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.mobile" x-text="errors.mobile ? errors.mobile[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>

                        <div class="w-full md:col-span-2">
                            {!! Form::label('website', 'Website Url', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::text('website', old('website'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.website" x-text="errors.website ? errors.website[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>
                        <div class="w-full md:col-span-2">
                            {!! Form::label('message', 'Message', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                            {!! Form::textarea('message', old('message'), ['required' => 'required', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}

                            {{-- <div x-show="errors.email" x-text="errors.email ? errors.email[0] : ''" class="text-xs text-red-700"></div> --}}
                        </div>

                        <div class="w-full md:col-span-2">
                            <button class="g-recaptcha cursor-pointer rounded text-sm mt-2 font-semibold w-full inline-block text-center py-2 px-6 border-r  bg-primary hover:bg-primary_hover text-white rounded-sm"
                                    data-sitekey="6Lf8N5sdAAAAAJJ0hCYGuyHo-D2Hxaq2hL8Gz-4x"
                                    data-callback='onSubmit'
                                    data-action='submit'>
                                Send
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loading" class="fixed w-screen h-screen top-0 left-0 z-50 bg-white grid place-items-center" ></div>
    <div x-data="{sidebar:false}">
        <div    x-show="sidebar" class="w-screen h-screen fixed top-0 left-0  z-20 md:hidden" style="background-color: rgba(0,0,0,0.5)">
                <div
                    x-show="sidebar"
                    x-transition:enter="transition ease-in-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-x-20"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in-out duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0 transform -translate-x-20"
                    class="w-3/5 h-screen bg-white p-3"
                    @click.away="sidebar=false">
                    <div  class="flex justify-end w-full mt-1 mr-2 ">
                        <button @click="sidebar=false" class="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @include('layouts.sidebar')


                </div>
            </div>

        @include('layouts.nav')

        <div class="mx-auto min-h-screen max-w-screen-2xl">
            @yield('content')
        </div>


        @include('layouts.footer')

    </div>
    <div id="inquiry-modal"></div>
    <script type="text/javascript" src="/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js" defer></script>

    <script src="https://js.stripe.com/v3/"></script>
    @yield('custom-js')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "aef941c23cdc258f16b90d8999a1a9d06b1957f62fb47243a72dc6a1dc734de24edb09d0b2ba707d8726cbafab649157", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.com/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script>
</body>
</html>
