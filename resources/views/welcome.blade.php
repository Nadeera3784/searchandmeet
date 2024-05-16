@extends('layouts.app')

@section('content')
<script>
    function carousel(){
        return {
            slides : ['Buyers','Customers','Prospects','Cooperates'],
            i : 0,
            init(){
                setInterval(() =>{
                    this.i++;
                },2000);
            },
            active_slide(data) {
                if(this.i == 4) this.i = 0
                return this.slides.indexOf(data) == this.i;
            }
        }
    }
    window.addEventListener('load',()=>{
        $(()=>{
            slider('support_section');
            slider('price_section');
            slider('testimonial_section');
            slider('buyer_section');
            slider_h('article_section');
        });

        $(window).resize(function() {
            slider_h('article_section');
        });
        const slider = (section) => {
            if($('.'+section).length == 0) return;
            let html = '';
            for(let i = 0; i < $('.'+section+' .slider_container>div').length ; i++){
                html += '<div index='+i+' class="bg-primary pointer-events-auto cursor-pointer hover:opacity-100 h-1.5 w-7 rounded-full transition-opacity duration-100 ease-in"></div>';
            }
            $('.'+section+' .sliderbtn').html(html);
            $('.'+section+' .sliderbtn>div').click(e => {
                $('.'+section+' .sliderbtn>div').css('opacity','0.5');
                $(e.target).css('opacity','1');
                $('.'+section+' .slider_container').scrollLeft($('.'+section+' .slider_container>div').innerWidth() * $(e.target).attr('index'))
            });
            $($('.'+section+' .sliderbtn>div')[0]).click();

            $('.'+section+' .slider_container').on('scroll',(e) => {
                var scrollW = $('.'+section+' .slider_container')[0].scrollWidth;
                $('.'+section+' .sliderbtn>div').each((index,el) => {
                    $(el).css('opacity','0.5');
                    var scrollAt = $('.'+section+' .slider_container').scrollLeft();
                    var scrollOffset = $('.'+section+' .slider_container>div').innerWidth();
                    if( scrollAt < (scrollOffset * (index + 1)) && scrollAt >= (scrollOffset * index)){
                        $(el).css('opacity','1');
                    }
                });
            });
        }

        const slider_h = (section) => {
            if($('.'+section).length == 0) return;
            let html = '';
            const perSlide = screen.width > 768 ? 2 : 1;
            for(let i = 0; i < Math.round($('.'+section+' .slider_container>div').length/perSlide + 0.1) ; i++){
                html += '<div index='+i+' class="bg-primary ring-1 ring-primary border-2 border-white rounded-full pointer-events-auto cursor-pointer hover:opacity-100 h-3 w-3 transition-opacity duration-100 ease-in"></div>';
            }
            console.log(perSlide)
            $('.'+section+' .sliderbtn').html(html);
            $('.'+section+' .sliderbtn>div').click(e => {
                $('.'+section+' .sliderbtn>div').css('opacity','0.5');
                $(e.target).css('opacity','1');
                $('.'+section+' .slider_container').scrollTop($('.'+section+' .slider_container>div').innerHeight() * $(e.target).attr('index'))
            });
            $($('.'+section+' .sliderbtn>div')[0]).click();

            // $('.'+section+' .slider_container').on('scroll',(e) => {
            //     var scrollW = $('.'+section+' .slider_container')[0].scrollWidth;
            //     $('.'+section+' .sliderbtn>div').each((index,el) => {
            //         $(el).css('opacity','0.5');
            //         var scrollAt = $('.'+section+' .slider_container').scrollTop();
            //         var scrollOffset = $('.'+section+' .slider_container>div').innerHeight();
            //         if( scrollAt < (scrollOffset * (index + 1)) && scrollAt >= (scrollOffset * index)){
            //             $(el).css('opacity','1');
            //         }
            //     });
            // });
        }
    });
</script>
@inject('domainDataService', 'App\Services\Domain\DomainDataService')
    <div class="overflow-hidden">
        {{-- First Section --}}
        <div class="px-5 md:px-16 lg:px-28 relative z-20 pt-20  md:p-2 full_sections">
            <div  class="absolute inset-0 pt-20 object-fit bg h-full w-full z-0  overflow-visible" style="z-index: -1;">
                <div class="relative inset-0 pt-20 object-cover h-full w-full md:block hidden bg_clip transform rotate-180" style="z-index: 3;">
                    <img src="/img/assets/Asset 3.png" class="absolute left-0 bottom-0  w-1/3 md:hidden  object-cover transform rotate-180" style="z-index: 2;" >
                    <img src="/img/intro_new.png" class="absolute left-0 -top-20  w-full h-full md:block hidden object-cover transform rotate-180" style="z-index: 2;" >
                </div>
                <img src="/img/intro_help.png" class="absolute left-0 bottom-0 pt-20 w-full h-full md:block hidden object-cover" style="z-index: 2;" >
                <div class="absolute bottom-0 h-full w-full bg-repeat bg_clip_1 bg-primary transform rotate-180 md:block hidden" style="z-index: 1;"></div>
                {{-- <img src="/img/assets/bg_plain.png" class="absolute bottom-0 object-fit h-96 w-full bg-repeat" style="z-index: 1;"> --}}
            </div>
            <div class="h-full transform md:scale-90 relative md:pt-40 pt-20 ">
            <div class="flex flex-col space-y-10 justify-center">
                <div class="md:w-6/12 w-full" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                    <div class="md:text-5xl text-4xl font-bold w-full overflow-hidden pb-1 tracking-wider font-primary">
                        <div class="col-span-3 flex ">
                            <span class=" mr-2">Meet</span>
                            <div x-data="carousel()" class="relative" x-init="init()">
                                <template x-for="data in slides" :key="data">
                                    <div x-show="active_slide(data)"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform translate-x-full"
                                        x-transition:enter-end="opacity-100 transform translate-x-0"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100 transform scale-100"
                                        x-transition:leave-end="opacity-0 transform scale-90"
                                        class="absolute top-0 left-0"
                                        >
                                       <span class=" inline-block text-primary" x-text="data"></span>
                                    </div>
                                </template>
                                {{-- <div class="owl-carousel owl-theme text-primary w-60">
                                    <span class="inline-block">Buyers</span>
                                    <span class="inline-block">Customers</span>
                                    <span class="inline-block">Prospects</span>
                                    <span class="inline-block">Cooperates</span>
                                </div> --}}
                            </div>
                        </div>
                        <p class="leading-tight">On Video Meetings</p>
                    </div>
                    <p class="text-gray-700 tracking-wide mt-2 font-secondary text-lg">Business meetings on-demand. New connections, new opportunities and new possibilities</p>
                </div>
                <div class="z-20" data-aos="fade-right" data-aos-duration="500" data-aos-once="true" class="relative">
                    @include('components.searchFilter')
                </div>
            </div>
            </div>
        </div>
        {{-- End First Section --}}
        <div class="px-5 md:px-16 lg:px-28 py-10 z-10 relative overflow-hidden flex flex-col space-y-8" style="height: max-content;">
            <div class="absolute inset-0 object-fit h-full w-full z-0 overflow-visible" style="z-index: -1;">
                <img src="/img/assets/Asset 7.png" class="absolute left-0 bottom-1/2  w-28  opacity-60 object-cover transform -translate-x-1/2 translate-y-1/2 rotate-90" style="z-index: 2;" >
                <img src="/img/assets/Asset 7.png" class="absolute right-0 bottom-1/2  w-28  opacity-60 object-cover transform translate-x-1/2 translate-y-1/2 -rotate-90" style="z-index: 2;" >
                <img src="/img/assets/Asset 7.png" class="absolute left-3/4  -bottom-0.5  w-24   object-cover transform -translate-x-1/2 translate-y-1/2 rotate-180" style="z-index: 2;" >
            </div>
            <h3 class="font-bold text-4xl md:w-1/2 w-full mx-auto text-center font-primary tracking-wider text-primary">Here’s how you can meet your ideal prospects</h3>
            <p class="block md:w-3/4 w-full text-gray-700 text-base text-center mx-auto">Search among thousands of meeting requests with purchase requirements, pick an available time and meet the decision makers directly on video meetings</p>
            <div class="grid md:grid-cols-3 grid-cols-1 gap-4 gap-x-6 ">
                <div  class="p-8 flex flex-col space-y-6" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div class="width-fit-content mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" fill="none" viewBox="0 0 127.27 127.27" stroke="currentColor">
                            <defs>
                                <style>.cls-1{fill:#453163;}.cls-2{fill:#f7fbff;fill-rule:evenodd;}</style>
                                </defs>
                                <title>search_ico</title>
                                <g id="Layer_2" data-name="Layer 2">
                                <g id="Layer_1-2" data-name="Layer 1">
                                <circle class="cls-1" cx="63.64" cy="63.63" r="63.64"/>
                                <path class="cls-2" d="M75.59,71.3l6.67,6.62c.63.63,1.28,1.24,1.88,1.9a3.06,3.06,0,1,1-4.37,4.27c-2.54-2.51-5-5-7.57-7.57a10.93,10.93,0,0,1-.79-1C66.16,79,60.7,79.89,54.87,78A17.86,17.86,0,0,1,45,70.2,18.39,18.39,0,0,1,72.34,46.41,18.53,18.53,0,0,1,75.59,71.3ZM48.36,60.55A12.25,12.25,0,1,0,60.69,48.33,12.34,12.34,0,0,0,48.36,60.55Z"/>
                                </g>
                                </g>
                        </svg>
                    </div>
                    <h3 class="text-center font-bold text-2xl font-primary tracking-wider">Search Prospects </h3>
                    <p class="text-center text-gray-600 mt-5">Laser focus on ideal prospects you want to meet using location, industry, purchase requirement and many other filters. </p>
                </div>

                <div class="p-8 flex flex-col space-y-6" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div class="width-fit-content mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg"  class="h-24 w-24 text-white" viewBox="0 0 127.27 127.27">
                            <defs>
                                <style>.cls-1{fill:#453163;}.cls-2{fill:#fff;}.cls-2,.cls-3{fill-rule:evenodd;}.cls-3{fill:#e8214b;}</style>
                            </defs>
                            <title>search_p_ico</title>
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="Layer_1-2" data-name="Layer 1">
                                <circle class="cls-1" cx="63.64" cy="63.64" r="63.64" transform="translate(-11 13.35) rotate(-11.03)"/>
                                <path class="cls-2" d="M60.92,25.13A16.75,16.75,0,1,1,44.11,41.76,16.72,16.72,0,0,1,60.92,25.13Z"/><path class="cls-2" d="M60.17,61.14a19.22,19.22,0,0,0,13.4,31H39.65c-1.83,0-2.72-.92-2.72-2.77,0-3.66,0-7.32,0-11a17.37,17.37,0,0,1,14.37-17,83.72,83.72,0,0,1,8.84-.47Z"/><path class="cls-3" d="M86.93,81.37l5.21,5.17c.5.49,1,1,1.47,1.49a2.39,2.39,0,1,1-3.41,3.34c-2-2-4-3.94-5.92-5.92a8.68,8.68,0,0,1-.62-.79,14.45,14.45,0,0,1-12.93,2A13.94,13.94,0,0,1,63,80.51a14.37,14.37,0,0,1,21.4-18.59A14.48,14.48,0,0,1,86.93,81.37ZM65.65,73a9.57,9.57,0,1,0,9.63-9.56A9.63,9.63,0,0,0,65.65,73Z"/>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <h3 class="text-center font-bold text-2xl font-primary tracking-wider">Confirm</h3>
                    <p class="text-center text-gray-600 mt-5"> Pick the best available time suits you confirm the meeting and get your meeting assistant allocated</p>
                </div>

                <div class="p-8 flex flex-col space-y-6" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div class="width-fit-content mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" viewBox="0 0 127.27 127.27">
                            <defs>
                            <style>.cls-1{fill:#453163;}.cls-2{fill:#fff;}.cls-2,.cls-3{fill-rule:evenodd;}.cls-3{fill:#e8214b;}</style>
                            </defs>
                            <title>roi_ico</title>
                            <g id="Layer_2" data-name="Layer 2">
                            <g id="Layer_1-2" data-name="Layer 1">
                            <circle class="cls-1" cx="63.64" cy="63.64" r="63.64" transform="translate(-15.92 21.57) rotate(-17.13)"/>
                            <path class="cls-2" d="M35.76,69.65a6.19,6.19,0,0,1-4.83-4.38,6,6,0,0,1-.67-12,.89.89,0,0,0,.91-.69,5.89,5.89,0,0,1,5.67-3.82c1.09,0,2.18-.06,3.27,0a34.34,34.34,0,0,0,13.28-1.86c5.6-1.83,11.31-3.38,17-5l.69-.22c.25-1.55.6-1.85,2.14-1.85h3.74a1.47,1.47,0,0,1,1.66,1.67c0,3.11,0,6.23,0,9.34v1c4.14,1.55,6,4,6,7.64,0,3.35-2.11,5.85-6,7.18v9c0,3,0,3-3,3h-2.8a1.5,1.5,0,0,1-1.63-1.34,1.05,1.05,0,0,0-.56-.67c-7.75-2.3-15.5-4.56-23.25-6.87-.67-.2-.81.16-1,.59C43.9,75.18,41.52,80,39.11,84.74a4.83,4.83,0,0,1-9-.73,4.89,4.89,0,0,1,.36-3.71C32.24,76.85,34,73.4,35.67,70,35.7,69.89,35.7,69.83,35.76,69.65ZM71.09,44.82,48.72,51.4V67.1l22.37,6.58Zm-25.4,7c-3.16,0-6.24-.07-9.31,0a2.85,2.85,0,0,0-2.64,2.91q-.06,4.53,0,9.06a2.89,2.89,0,0,0,2.83,2.93c3,.06,6,0,9,0,.05,0,.09-.08.15-.13ZM43.16,69.71c-1.21,0-2.33,0-3.44,0a1.15,1.15,0,0,0-.81.54Q36,76,33.1,81.84a1.76,1.76,0,0,0,.68,2.55,1.86,1.86,0,0,0,2.59-.9q3.38-6.69,6.71-13.41A1.63,1.63,0,0,0,43.16,69.71Zm31,5.94h1.43V42.85H74.14Zm4.51-20.52v8.21a4.29,4.29,0,0,0,2.95-4A4.38,4.38,0,0,0,78.65,55.13ZM30.72,56.28a3,3,0,0,0-3,3,2.93,2.93,0,0,0,3,2.85Z"/><path class="cls-3" d="M95,60.73c-1.9,0-3.79,0-5.69,0-1.11,0-1.74-.57-1.72-1.52s.64-1.44,1.69-1.44h11.58a1.49,1.49,0,1,1,0,3C98.91,60.74,97,60.73,95,60.73Z"/><path class="cls-3" d="M86.69,54.4a1.45,1.45,0,0,1-1.62-1.15,1.38,1.38,0,0,1,.86-1.68c1.22-.53,2.47-1,3.71-1.51l6.21-2.53c1.06-.43,1.94-.14,2.28.71s-.08,1.63-1.18,2.07l-9.5,3.86C87.16,54.28,86.86,54.35,86.69,54.4Z"/><path class="cls-3" d="M98.22,69.37c0,1.38-1,2.12-2,1.74C92.83,69.76,89.4,68.36,86,66.94a1.43,1.43,0,0,1-.75-2,1.44,1.44,0,0,1,1.88-.78c3.41,1.35,6.81,2.71,10.19,4.15C97.76,68.55,98,69.16,98.22,69.37Z"/><path class="cls-3" d="M82.78,68.74a7.73,7.73,0,0,1,1.27.75q3.24,3,6.43,6.11a1.51,1.51,0,1,1-2,2.2c-2.18-2-4.33-4.12-6.5-6.18a1.39,1.39,0,0,1-.42-1.76A5.08,5.08,0,0,1,82.78,68.74Z"/><path class="cls-3" d="M82.75,49.72a5.48,5.48,0,0,1-1.2-1.07,1.37,1.37,0,0,1,.37-1.77l4.53-4.32c.68-.64,1.34-1.29,2-1.92a1.51,1.51,0,0,1,2.23,0,1.46,1.46,0,0,1-.15,2.16Q87.29,46,83.94,49.09A5.33,5.33,0,0,1,82.75,49.72Z"/>
                            </g>
                            </g>
                            </svg>
                    </div>
                    <h3 class="text-center font-bold text-2xl font-primary tracking-wider">Meet</h3>
                    <p class="text-center text-gray-600">Just turn up on time, our dedicated consultants will coordinate both parties and facilitate the meetings.</p>
                </div>
            </div>
        </div>

        <div class="bg-purple-500 bg relative w-full pt-12">
            <div class="absolute inset-0 object-fit h-full w-full z-0 overflow-hidden pointer-events-none" style="z-index: 1;">
                <img src="/img/dashed_white.png" class="absolute -left-10 md:top-14 top-5  w-36   object-cover transform  translate-y-1/2" style="z-index: 2;" >
                <img src="/img/assets/Asset 7.png" class="absolute left-3/4  top-0  w-24   object-cover transform -translate-x-1/2 -translate-y-1/2 " style="z-index: 2;" >
            </div>
            <div>
                <div class="container  mx-auto pt-8 md:px-12 px-4 text-white">
                    <h3 class="text-4xl font-bold text-center">Hard-to-get contact</h3>
                    <p class="text-gray-200 w-full md:w-2/5 text-center mx-auto mt-5">Availability search to find hard-to-get contact meeting available times and instantly confirm meetings.</p>
                </div>

                <div class="buyer_section md:px-12 pt-12 md:pb-12 text-white bg-purple-700 bg-opacity-60 mt-10 w-full Main_slider_cont" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                    <div
                    class="slider_container flex flex-row w-screen flex-auto relative overflow-x-auto items-center   md:w-10/12 mx-auto hide-scroll smooth-scroll slider_cont"
                    style="min-height: max-content !important;"
                    data-aos="fade-up"
                    data-aos-duration="800"
                    data-aos-once="true">
                        <div class="min-w-full md:min-w-0 md:w-full px-5 pointer-events-auto buyers-card relative h-full">
                            <div class="pt-4 px-4 w-full h-full block">
                                <div class="w-full flex items-center relative rounded-md bg-white">
                                    <div class="absolute -top-4 -left-4 z-40">
                                        <img class=" w-20 h-20 rounded-md" src="/img/Actor02.png" alt="hero-image-1.png">
                                    </div>
                                    <div class="absolute top-0 bottom-0 left-0 z-30">
                                        <div class="w-16 h-full rounded-l-md bg-pink-500"></div>
                                    </div>
                                    <div class="flex flex-col h-full space-y-1 overflow-hidden pl-20 py-5 pr-3">
                                        <span class="text-base text-primary">Janie Hauck</span>
                                        <span class="text-sm text-gray-600">Health & Beauty</span>
                                        <span class="text-sm text-gray-900">Globex Corporation</span>
                                        <span class="text-sm text-pink-500 flex ">
                                            United State
                                            <span class="ml-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                        </span>
                                        {{-- <span class="text-base text-gray-900 truncate">Globex Corporation</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="min-w-full md:min-w-0 md:w-full px-5 pointer-events-auto buyers-card relative h-full">
                            <div class="pt-4 px-4 w-full h-full block">
                                <div class="w-full flex items-center relative rounded-md bg-white">
                                    <div class="absolute -top-4 -left-4 z-40">
                                        <img class=" w-20 h-20 rounded-md" src="/img/Actor01.png" alt="hero-image-1.png">
                                    </div>
                                    <div class="absolute top-0 bottom-0 left-0 z-30">
                                        <div class="w-16 h-full rounded-l-md bg-pink-500"></div>
                                    </div>
                                    <div class="flex flex-col h-full space-y-1 overflow-hidden pl-20 py-5 pr-3">
                                        <span class="text-base text-primary">Dr. Loma Adams DDS</span>
                                        <span class="text-sm text-gray-600">Consumer Electronics</span>
                                        <span class="text-sm text-gray-900">Soylent Corp</span>
                                        <span class="text-sm text-pink-500 flex ">
                                            United Kingdom
                                            <span class="ml-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                        </span>
                                        {{-- <span class="text-base text-gray-900 truncate">Soylent Corp</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="min-w-full md:min-w-0 md:w-full px-5 pointer-events-auto buyers-card relative h-full">
                            <div class="pt-4 px-4 w-full h-full block">
                                <div class="w-full flex items-center relative rounded-md bg-white">
                                    <div class="absolute -top-4 -left-4 z-40">
                                        <img class=" w-20 h-20 rounded-md" src="/img/Actor03.png" alt="hero-image-1.png">
                                    </div>
                                    <div class="absolute top-0 bottom-0 left-0 z-30">
                                        <div class="w-16 h-full rounded-l-md bg-pink-500"></div>
                                    </div>
                                    <div class="flex flex-col h-full space-y-1 overflow-hidden pl-20 py-5 pr-3">
                                        <span class="text-base text-primary">Cassidy Gleason</span>
                                        <span class="text-sm text-gray-600">Apparel & Textiles</span>
                                        <span class="text-sm text-gray-900">Massive Dynamic</span>
                                        <span class="text-sm text-pink-500 flex ">
                                            Malasiya
                                            <span class="ml-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                        </span>
                                        {{-- <span class="text-base text-gray-900 truncate">Massive Dynamic</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sliderbtn text-white flex w-full mt-6 pb-6 justify-center space-x-3 pointer-events-none md:hidden">
                    </div>
                </div>
                <div class="width-fit-content mx-auto pt-12 pb-12 md:pb-0">
                    <a href="{{route('purchase_requirements.search')}}" class="mx-auto width-fit-content flex items-center text-primary hover:text-white px-3 py-2 transition-all duration-150 ease-in-out">
                        <span class="text-uppercase text-center text-base font-semibold ">SEE MORE BUYERS</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2 transform rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- <div class="container mx-auto mt-10">
            <div class="flex md:flex-row flex-col p-5 overflow-hidden py-16">
                <div class="md:w-2/4 w-full px-5" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                    <div class="w-3/4 md:mx-auto  relative md:h-full h-80 bg-cover bg-no-repeat rounded-lg" style="background-image: url('/img/content-1-img1.png')">
                        <img class="md:w-48 w-40 md:h-48 h-40 border border-white absolute right-0 top-0 transform translate-x-2/4 md:translate-y-3/4 translate-y-2/4 -rotate-12" src="/img/content-1-img2.png" alt="" style="border-width: 10px">
                    </div>
                </div>
                <div class="md:w-2/4 w-full p-5  md:px-24" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                    <h3 class="text-4xl font-bold leading-normal"><span class="text-red-500">Called & Verified Contacts</span> With Real Business Requirments</h3>
                    <p class="text-gray-500 mt-5">In-depth review of all users and products or services requirements and personalized multi strategy approach to Identify best key decision-makers by phone or video meetings. </p> --}}
{{--
                    <a href="#" class="width-fit-content flex items-center text-red-600 my-6 hover:bg-red-600 hover:text-white transform hover:translate-x-3 -ml-3 px-3 py-2">
                        <span class="text-uppercase  text-base font-semibold ">Learn More</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>

                    </a> --}}
{{--
                    <div class="flex py-5">
                        <img class="w-12 h-12 rounded-full" src="/img/media-img1.png" alt="user">
                        <div class="px-5">
                            <p>“Duis pretium gravida enim, vel maximus ligula fermentum a. Sed rhoncus eget ex id egestas. Nam nec nisl placerat, tempus erat a, condimentum metus.”</p>

                            <p class="text-base font-bold mt-8">Davis Jones</p>
                            <p class="text-base text-gray-500 mt-1">Full-Stack Developer</p>

                        </div>
                    </div> --}}
                {{-- </div>
            </div> --}}
        <div class="relative w-full bg-primary md:bg-opacity-0 full_sections_2">
            <div class="flex md:flex-row flex-col p-5 overflow-hidden py-10  md:pt-20">
                <div  class="absolute inset-0 object-fit h-full w-full z-0 overflow-hidden" style="z-index: -1;">
                    <div class="relative inset-0 pt-20 object-cover h-full w-full bg bg_clip_2_full bg-purple-500" style="z-index: 1;">
                    </div>
                    <img src="/img/dashed_white.png" class="absolute -right-10 top-0  w-36  object-cover transform translate-y-1/2" style="z-index: 3;" >
                    <img src="/img/rings.png" class="absolute left-10 top-10  w-16 object-cover transform translate-y-1/2 rotate-90" style="z-index: 3;" >
                    <img src="/img/rings.png" class="absolute right-40 bottom-128  w-16 object-cover transform translate-y-1/2 rotate-90" style="z-index: 3;" >
                    <img src="/img/black_line.png" class="absolute right-10 bottom-20  w-full object-cover transform translate-y-1/2" style="z-index: 3;" >
                    <div class="absolute bottom-0 h-full w-full bg-repeat bg bg_clip_2 bg-primary" style="z-index: 2;"></div>
                </div>
                <div class="md:w-2/4 w-full p-5 flex flex-col  md:px-24" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                    <div class="text-4xl font-bold flex flex-col">
                        <span class="text-white text-4xl">Called & Verified Contacts</span>
                        <span>With Real Business Requirments</span>
                    </div>
                    <p class="text-white mt-5">In-depth review of all users and products or services requirements and personalized multi strategy approach to Identify best key decision-makers by phone or video meetings. </p>
                </div>
                <div class="md:w-2/4 w-full px-5 md:px-24 flex mt-20 md:mt-0 " data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                    <div class="w-80 bg-gray-900 bg-opacity-70 text-white rounded-xl relative flex flex-col mx-auto md:mx-0" x-data="{page : 'about'}">
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <img class="rounded-full border-4 border-primary h-28 w-28 mx-auto object-cover shadow-md" src="/img/main/image06.jpg" alt="hero-image-2hero-image-2.png.png">
                        </div>
                        <div class="py-8 w-full px-8 overflow-hidden">
                            <div class="pt-8">
                                <div>
                                    <h1 class="text-center mt-3 text-base font-bold ">William Rocheald</h1>
                                    <p class="text-center text-base uppercase mt-0 ">MANAGING DIRECTOR</p>
                                </div>
                            </div>
                            {{-- <div
                                x-show="page=='about'"
                                x-transition:enter="transition ease-in duration-0"
                                x-transition:enter-start="z-10 opacity-0 h-0"
                                x-transition:enter-end="z-20 opacity-100 h-full"
                                x-transition:leave="transition ease-out duration-0"
                                x-transition:leave-start="z-20 opacity-100 h-full"
                                x-transition:leave-end="z-10 opacity-0 h-0"
                                class="p-4 bg-white mt-4 text-gray-800 rounded-md">

                                <h1 class="text-left uppercase font-medium mb-3">About</h1>
                                <p class="text-left text-sm ">Whatever tattooed stumptown art party sriracha gentrify hashtag intelligentsia readymade schlitz brooklyn disrupt.</p>
                            </div> --}}
                            <div
                            x-show="page=='about'"
                            x-transition:enter="transition ease duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-5"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                             class="flex flex-col space-y-3 mt-4 p-4 bg-white text-gray-800 rounded-t-md rounded-br-md z-10">
                                <h1 class="text-left uppercase font-medium mt-2 ml-2">About</h1>
                                <div  class="flex items-start text-sm space-x-2">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Name : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold "> William Rocheald</p>
                                </div>
                                <div  class="flex items-start text-sm space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Title : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold ">Managing Director</p>
                                </div>
                                <div  class="flex items-start text-sm space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Company : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold ">Rocheald Export</p>
                                </div>
                                <hr class="my-3">
                                <div class="flex items-center space-x-2 mt-2">
                                    <div class="border-r-2 border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-left text-sm">Algonquin Rd, Three Oaks Vintage, MI, 49128</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="border-r-2 border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                          </svg>
                                    </div>
                                    <p class="text-left text-sm">(269) 756-9809</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="border-r-2 border-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                          </svg>
                                    </div>
                                    <p class="text-left text-sm">william@rocheald.com</p>
                                </div>
                            </div>
                            <div
                            x-show="page=='business'"
                            x-transition:enter="transition ease duration-500"
                            x-transition:enter-start="opacity-0 transform translate-y-5"
                            x-transition:enter-end="opacity-100 transform translate-y-0"

                            class="flex flex-col space-y-3 p-4 bg-white mt-4 text-gray-800 rounded-t-md rounded-bl-md z-10">
                                <h1 class="text-left uppercase font-medium mt-2 ml-2">{{ __('Business Details') }}</h1>
                                <div  class="flex items-start text-sm space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Name : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold ">Rocheald Export</p>
                                </div>
                                <div class="flex items-start text-sm  space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Business Type : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold ">Export</p>
                                </div>
                                <div class="flex items-start text-sm  space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Current Importer : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold ">Yes</p>
                                </div>
                                <div class="flex items-start  text-sm  space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Website : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold text-blue-500 truncate">www.rocheald.com</p>
                                </div>
                                <div class="flex items-start  text-sm  space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">Revenue : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold truncate">$ 124,141.00</p>
                                </div>
                                <div class="flex items-start  text-sm  space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">SIC Code : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold truncate">88452423</p>
                                </div>
                                <div class="flex items-start  text-sm  space-x-2 my-1">
                                    <div class="text-gray-500 border-gray-300 w-max">
                                        <span class="font-medium ml-2 whitespace-nowrap">NAICS Code : </span>
                                    </div>
                                    <p class="text-left text-sm font-semibold truncate">745VA541A</p>
                                </div>
                            </div>
                            <div class="mt-0 w-full grid grid-cols-2 z-20">
                                {{-- <div @click="page='about'" x-bind:class="{'bg-primary ' : page == 'about' }" class=" text-center py-3 cursor-pointer rounded-b-md transition-all duration-200 ease-in-out uppercase text-xs">About</div> --}}
                                <div @click="page='about'" x-bind:class="{'bg-primary transition-all duration-500 ease-in' : page == 'about' }" class=" text-center py-3 cursor-pointer rounded-b-md  uppercase text-xs">Contact</div>
                                <div @click="page='business'" x-bind:class="{'bg-primary transition-all duration-500 ease-in' : page == 'business' }" class=" text-center py-3 cursor-pointer rounded-b-md uppercase text-xs">Business</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="flex flex-col overflow-hidden relative">
                <div class="grid md:grid-cols-7 grid-cols-1 support_section">
                    <div class="slider_container p-10 flex flex-row w-screen md:w-full flex-auto md:flex-wrap relative overflow-x-auto md:col-span-4 col-span-1 md:row-start-1 md:row-end-2 row-start-2 row-end-3  hide-scroll smooth-scroll">
                        <div class="min-w-full md:min-w-0 md:w-1/2 p-3 md:px-14 px-4" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100" data-aos-once="true">
                            <div class="flex flex-col items-center  h-12">
                                <img src="/img/Globe.png" class="h-12 object-cover" style="z-index: 2;" >
                            </div>
                            <h3 class="font-bold text-base uppercase text-center text-primary line-clamp-2 mt-4">Dedicated support</h3>
                            <p class="text-gray-800 text-base my-3 font-medium text-center">Our specialized team will analysis the buyer requirement and match you with the correct buyers who are exactly looking for your products and organize meetings</p>
                        </div>
                        <div class="min-w-full md:min-w-0 md:w-1/2 p-3 md:px-14 px-4" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100" data-aos-once="true">
                            <div class="flex flex-col items-center h-12">
                                <img src="/img/People.png" class="h-10 object-cover" style="z-index: 2;" >
                            </div>
                            <h3 class="font-bold text-base uppercase text-center text-primary line-clamp-2 mt-4">Professional Meeting Host</h3>
                            <p class="text-gray-800 text-base my-3 font-medium text-center">Every meeting will be carried out professionally with a professional meeting host to make the meeting effective and successful</p>
                        </div>
                        <div class="min-w-full md:min-w-0 md:w-1/2 p-3 md:px-14 px-4" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100" data-aos-once="true">
                            <div class="flex flex-col items-center  h-12">
                                <img src="/img/Translate.png" class="h-8 object-cover" style="z-index: 2;" >
                            </div>
                            <h3 class="font-bold text-base uppercase text-center text-primary line-clamp-2 mt-4">Translators</h3>
                            <p class="text-gray-800 text-base my-3 font-medium text-center">Translators available on demand to help better communication with the buyer in multiple languages Support Languages</p>

                        </div>
                        <div class="min-w-full md:min-w-0 md:w-1/2 p-3 md:px-14 px-4 relative" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100" data-aos-once="true">
                            <img src="/img/cross.png" class="absolute opacity-0 md:opacity-100 top-0 left-0 w-8 object-cover transform -translate-y-1/2 -translate-x-1/2 filter grayscale" style="z-index: 3;" >
                            <img src="/img/cross.png" class="absolute opacity-0 md:opacity-100 bottom-0 left-0 w-8 object-cover transform translate-y-1/2 -translate-x-1/2 filter grayscale" style="z-index: 3;" >
                            <div class="flex flex-col items-center  h-12">
                                <img src="/img/Dashboard.png" class="h-12 object-cover" style="z-index: 2;" >
                            </div>
                            <h3 class="font-bold text-base uppercase text-center text-primary line-clamp-2 mt-4">Dashboard</h3>
                            <p class="text-gray-800 text-base my-3 font-medium text-center">Meeting management dashboard to manage schedule, send quoted direct to buyers, access buyer profiles, automated communication with email, SMS, WhatsApp & Call buyers</p>

                        </div>
                        <div class="min-w-full md:min-w-0 md:w-1/2 p-3 md:px-14 px-4" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100" data-aos-once="true">
                            <div class="flex flex-col items-center h-12">
                                <img src="/img/Trading.png" class="h-12 object-cover" style="z-index: 2;" >
                            </div>
                            <h3 class="font-bold text-base uppercase text-center text-primary line-clamp-2 mt-4">Trading Support</h3>
                            <p class="text-gray-800 my-3 text-base font-medium text-center">After meeting order completion support from expert local foreign trade consultants, includes logistics, tax and duty, product certifications and customs clearance</p>

                        </div>
                        <div class="min-w-full md:min-w-0 md:w-1/2 p-3 md:px-14 px-4" data-aos="fade-left" data-aos-duration="800" data-aos-delay="100" data-aos-once="true">
                            <div class="flex flex-col items-center h-12">
                                <img src="/img/Region.png" class="h-12 object-cover" style="z-index: 2;" >
                            </div>
                            <h3 class="font-bold text-base uppercase text-center text-primary line-clamp-2 mt-4">Multi Region Coverage</h3>
                            <p class="text-gray-800 text-base my-3 font-medium text-center">Get buyer form around the world, we have meeting teams covering over 45 countries, Yu can target your regular countries and expand to new countries as well Support Countries</p>
                        </div>
                    </div>
                    <div class="sliderbtn text-white flex w-full mt-6 pb-6 justify-center space-x-3 pointer-events-none md:hidden">
                    </div>
                    <div class="md:col-span-3 col-span-1 md:row-start-1 md:row-end-2 row-start-1 row-end-2">
                        <div class="w-full h-full relative"  >
                            <div class="absolute bottom-20 right-10 " style="z-index: 3;" >
                                <h1 class="mt-3  block  w-full font-bold text-4xl text-right ml-auto text-primary relative">
                                    <img src="/img/cross.png" class="absolute top-0 left-0 w-8 object-cover transform -translate-y-1/2" style="z-index: 3;" >
                                    Professional Support <br>& Tools <span class="text-white">for Success</span>
                                </h1>
                                <p class="block w-full mt-3 text-white font-bold text-right ml-auto">Connect the dots between prospecting and closed deals</p>
                            </div>
                            <img src="/img/bg_support.jpg" class="w-full h-full object-cover" style="z-index: 2;" >
                        </div>
                        <img src="/img/red_line.png" class="pointer-events-none absolute right-10 -top-10  w-full object-cover transform" style="z-index: 3;" >
                        <img src="/img/Ring_bw.png" class="pointer-events-none absolute md:right-0 right-20  bottom-0  w-16   object-cover transform -translate-x-1/2 translate-y-1/2" style="z-index: 2;" >
                    </div>
                </div>
            </div>
        </div>
            <div class=" px:4 py-10  relative price_section">
                <div class="absolute inset-0 pt-20 object-fit h-full w-full bg bg-gray-100 z-0 overflow-visible pointer-events-none" style="z-index: -1;">
                    <img src="/img/Ring_bw.png" class="absolute md:right-0 right-20  top-0  w-16   object-cover transform -translate-x-1/2 -translate-y-1/2" style="z-index: 2;" >
                    <img src="/img/assets/Asset 7.png" class="absolute md:left-20 left-10  -bottom-0.5  w-16   object-cover transform -translate-x-1/2 translate-y-1/2 " style="z-index: 2;" >
                </div>
                <p class="block md:w-2/4 w-full text-gray-500 font-bold text-center mx-auto">Simple & Transparent Pricing</p>
                <h3 class="mt-3  block md:w-2/4 w-full font-bold text-4xl text-center mx-auto">Pay for successful meetings only</h3>
                <div class="w-full md:w-1/3  mt-5  overflow-hidden mx-auto">
                    <div class="owl-carousel owl-theme text-center font-bold text-base text-primary">
                        <span class="uppercase">NO Setting UP COST</span>
                        <span class="uppercase">NO Monthly Commitment</span>
                        <span class="uppercase">NO Marketing Cost</span>
                        <span class="uppercase">NO Upfront Cost</span>
                    </div>
                </div>
                {{-- <div class="grid w-4/5 sm:w-5/6 md:4/6 mx-auto sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 grid-cols-1 gap-4 gap-x-6 pt-6 pb-10 mt-8"> --}}
                <div class="slider_container flex flex-row w-screen h-full flex-auto sm:flex-wrap relative overflow-x-auto sm:w-5/6 md:4/6 mx-auto p-6 pb-10 mt-8  hide-scroll smooth-scroll">
                    <div class="min-w-full min-h-full md:min-w-0 md:w-1/3 px-4 flex" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                        <div class="w-full shadow-lg h-full bg-gray-50 p-4 md:p-8 rounded-2xl flex flex-col" >
                            <div class="flex items-center space-x-3">
                                <div class="bg-pink-200 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-3 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-2xl">Meeting With Host</h3>
                            </div>
                            <div class="flex items-stsrt flex-col mt-6">
                                <span class="font-semibold text-gray-400 text-base">Starting from</span>
                                <div class="text-6xl font-bold">
                                    @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                                        <span class="text-gray-400 text-2xl font-semibold">$</span>81<span class="font-semibold text-base">.00</span>
                                        @else
                                        <span class="text-gray-400 text-2xl font-semibold">$</span>65<span class="font-semibold text-base">.00</span>
                                    @endif
                                </div>
                                <span class="font-semibold text-gray-400 text-base">Per Meeting</span>
                            </div>
                            <p class="text-gray-600 mt-6 font-medium">Get a professional consultant to call, organize and host the meeting.</p>
                            <div class="flex flex-col my-6 space-y-3 px-4">
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Coordinate & organize the meeting</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Conduct & facilitate the meeting</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Follow up support if required</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Meeting Management Dashboard</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="w-5/6">Access to contact information</p>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="w-5/6">Video meeting platform access</p>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="w-5/6">Email & Chat support</p>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="w-5/6">Live Phone Support</p>
                                </div>

                            </div>
                            <a href="{{route('purchase_requirements.search')}}" class="mt-auto text-center py-3 text-base font-semibold text-white rounded-lg bg-primary hover:bg-primary_hover cursor-pointer shadow-md">Search & Meet</a>
                        </div>
                    </div>
                    <div class="min-w-full min-h-full md:min-w-0 md:w-1/3 px-4 flex" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                        <div class="w-full shadow-lg h-full bg-gray-50 p-4 md:p-8 rounded-2xl flex flex-col" >
                            <div class="flex items-center space-x-3">
                                <div class="bg-pink-200 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-3 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-2xl">Book & Meet</h3>
                            </div>
                            <div class="flex items-stsrt flex-col mt-6">
                                <span class="font-semibold text-gray-400 text-base">Starting from</span>
                                <div class="text-6xl font-bold">
                                    @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                                        <span class="text-gray-400 text-2xl font-semibold">$</span>40<span class="font-semibold text-base">.00</span>
                                    @else
                                        <span class="text-gray-400 text-2xl font-semibold">$</span>25<span class="font-semibold text-base">.00</span>
                                    @endif
                                </div>
                                <span class="font-semibold text-gray-400 text-base">Per Meeting</span>
                            </div>
                            <p class="text-gray-600 font-medium mt-6">Confirm the meeting and be your own host</p>
                            <div class="flex flex-col my-6 space-y-3 px-4">
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Pay for successful meetings</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Access to contact information</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Requirement Details</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Company Details</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="w-5/6">Meeting Management Dashboard</p>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="w-5/6">Video meeting platform access</p>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="w-5/6">Email & Chat support</p>
                                </div>
                            </div>
                            <a href="{{route('purchase_requirements.search')}}" class="mt-auto text-center py-3 text-base font-semibold text-white rounded-lg bg-primary hover:bg-primary_hover cursor-pointer shadow-md">Search & Meet</a>
                        </div>
                    </div>
                    <div class="min-w-full min-h-full md:min-w-0 md:w-1/3 px-4 flex" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                        <div class="w-full shadow-lg h-full bg-gray-50 p-4 md:p-8 rounded-2xl flex flex-col" >
                            <div class="flex items-center space-x-3">
                                <div class="bg-pink-200 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-3 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-2xl">Access Information</h3>
                            </div>
                            <div class="flex items-stsrt flex-col mt-6">
                                <span class="font-semibold text-gray-400 text-base">Starting from </span>
                                <div class="text-6xl font-bold ">
                                    @if($domainDataService->checkIdentifier(config('domain.identifiers.china')))
                                        <span class="text-gray-400 text-2xl font-semibold">$</span>20<span class="font-semibold text-base">.00</span>
                                    @else
                                        <span class="text-gray-400 text-2xl font-semibold">$</span>5<span class="font-semibold text-base">.00</span>
                                    @endif
                                </div>
                                <span class="font-semibold text-gray-400 text-base">Per Record</span>
                            </div>
                            <p class="text-gray-600 font-medium mt-6">Get requirement details, coordinate with the prospect to finalize the meeting</p>
                            <div class="flex flex-col my-6 space-y-3 px-4">
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Contact Details</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Requirement Details</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Company Details</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Dashboard access</span>
                                </div>
                                <div class="flex space-x-3 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="w-5/6">Chat Support</span>
                                </div>
                            </div>
                            <a href="{{route('purchase_requirements.search')}}" class="mt-auto text-center py-3 text-base font-semibold text-white rounded-lg bg-primary hover:bg-primary_hover cursor-pointer shadow-md">Search</a>
                        </div>
                    </div>
                </div>
                <div class="sliderbtn text-white flex w-full mt-6 pb-6 justify-center space-x-3 pointer-events-none md:hidden">
                </div>
            </div>
        <div class="mx-auto overflow-hidden">
            <div class="grid md:grid-cols-8 grid-cols-1">
                <div class="md:col-span-4 col-span-7 p-16">
                    <h3 class="text-4xl font-bold font-primary text-primary">Search Prospects Form Current <br> Requirement</h3>
                    <p class="text-base font-semibold text-gray-800 mt-5">Dynamic search to filter real-time buying requirements updated constantly with deeper company intelligence at their fingertips</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 py-12 relative gap-y-5">
                        <div class="flex flex-col items-center p-3">
                            <div class="">
                                <img src="/img/presentation.png" class="w-20">
                            </div>
                            <div class="text-center text-base mt-6 text-gray-600">
                                <p>360-Degree requirement overview of key accounts</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center p-3">
                            <div class="">
                                <img src="/img/camera.png" class="w-20">
                            </div>
                            <div class="text-center text-base mt-6 text-gray-600">
                                <p>Over ten thousand daily Request for Meet (RFM) requests</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-center p-3">
                            <div class="">
                                <img src="/img/stats.png" class="w-20">
                            </div>
                            <div class="text-center text-base mt-6 text-gray-600">
                                <p>Pre forecast & scheduled purchase requirements pool</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-4 hidden md:block">
                    <div class="w-full h-full relative pl-10" style="z-index: -1;" >
                        <div class=" h-full bg_clip_3 overflow-hidden"  style="z-index: 4;">
                            <img src="/img/ClipGroup.png" class="absolute top-0 left-0 h-full object-cover " style="z-index: 1;" >
                        </div>
                        <img src="/img/Circle_line.png" class="absolute top-10 left-1/3  object-cover w-36" style="z-index: -1;" >
                    </div>
                </div>
            </div>
        </div>
        <div class="flex md:flex-row flex-col-reverse overflow-hidden md:py-24 relative">
            <div class="absolute inset-0 object-cover  w-full bg bg-primary z-0 overflow-visible" style="z-index: -1;" >
                <img src="/img/Fl_white.png" class="absolute left-20 -bottom-24  w-96  opacity-0 md:opacity-100 object-cover transform" style="z-index: 2;" >
                {{-- <img src="/img/assets/Asset 2.png" class="absolute -left-10 -bottom-0.5  w-7/12  opacity-0 md:opacity-100 object-cover transform  translate-y-1/2 " style="z-index: 2;" > --}}
            </div>
            <div class="md:w-2/5 w-full p-5 m-3 md:my-5 lg:mx-10 text-white h-full" data-aos="fade-right" data-aos-duration="800" data-aos-once="true">
                <h3 class="md:text-4xl text-4xl  font-bold font-primary">From 34 Countries 15 Languages</h3>
                <p class="text-md mt-5">Professional Support & Tools for Success. Every meeting will be carried out professionally with a professional meeting host to make the meeting effective and successful</p>
            </div>
            <div class="grid grid-cols-4 grid-rows-3 h-full auto-cols-max gap-1" data-aos="fade-left" data-aos-duration="800" data-aos-once="true">
                <img class="object-cover h-40 w-40 col-start-1 col-end-2 row-start-1 row-end-1 transform translate-y-1/3" src="/img/main/image01.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-2 col-end-3 row-start-1 row-end-1" src="/img/main/image02.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-3 col-end-4 row-start-1 row-end-1" src="/img/main/image03.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-4 col-end-5 row-start-1 row-end-1 transform translate-y-1/3" src="/img/main/image04.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-1 col-end-2 row-start-2 row-end-3 transform translate-y-2/3" src="/img/main/image05.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-2 col-end-3 row-start-2 row-end-3" src="/img/main/image11.jpg" alt="Image">
                <img class="object-cover h-40 w-40 col-start-3 col-end-4 row-start-2 row-end-3" src="/img/main/image07.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-4 col-end-5 row-start-2 row-end-3 transform translate-y-2/3" src="/img/main/image08.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-2 col-end-3 row-start-3 row-end-4" src="/img/main/image09.png" alt="Image">
                <img class="object-cover h-40 w-40 col-start-3 col-end-4 row-start-3 row-end-4" src="/img/main/image10.png" alt="Image">
            </div>
        </div>
        <div class="w-full relative overflow-hidden">
            <div class="absolute inset-0 object-cover  w-full z-0 overflow-visible" style="z-index: -1;" >
                <img src="/img/Fl_pink.png" class="absolute left-20 top-24  w-96  opacity-0 md:opacity-100 object-cover transform -translate-y-full" style="z-index: 2;" >
                <div class="w-full h-full bg-gray-200 md:block hidden" style="clip-path: polygon(0% 0%,40% 0%,59% 67%,50% 100%,0% 100%);"></div>
                <div class="w-full h-full bg-gray-200"></div>
                <img src="/img/bg_pospects.png" class="absolute right-0 top-1/2 bottom-0 md:w-3/4 w-full object-cover transform -translate-y-1/2" style="z-index: -1;" >
            </div>
            <div class="w-full md:pt-36 pt-20 pb-20">
                <div class="md:w-5/12 w-full md:ml-32 ml-4 px-5">
                    <h3 class="text-4xl font-bold font-primary text-primary"  data-aos="fade-right" data-aos-duration="800" data-aos-once="true">Future Proof B2B <br>Business Meetings</h3>
                    <p class="text-gray-800 mt-5 text-base"  data-aos="fade-right" data-aos-duration="800" data-aos-once="true">No costly digital or social marketing without any guaranteed results, save money time Prospects you want to meet, we will get them on video meetings from over 30 Countries covering 12 Languages</p>
                </div>
            </div>
        </div>
        @if($articles->count() > 0)
            <div class="w-full relative overflow-hidden bg-white bg bg-opacity-20 article_section" style="height: max-content;">
                <div class="grid md:grid-cols-2 grid-cols-1 overflow-hidden md:min-h-article">
                    <div class="col-span-1 h-full">
                        <div class="bg-blog-banner z-0 bg-no-repeat bg-cover md:h-full object-fill bg-bottom w-full md:w-article bg-clip-article h-56">
                            <div class="w-full bg-black-900 bg-opacity-50 md:px-20 md:py-12 p-5">
                                <p class="font-bold text-4xl text-white">Latest  News & Articles</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 py-10 md:pr-10 px-5 z-10 h-full">
                        <div class="flex flex-col h-full ">
                            <div class="w-full h-full relative flex md:flex-row flex-col">
                                <div class="w-full md:h-full h-96 relative">
                                    <div class="slider_container absolute inset-x-0 top-0 smooth-scroll flex flex-wrap h-full w-full overflow-y-hidden hide-scroll justify-evenly">
                                        @foreach ($articles as $article)
                                            <div class="md:w-2/5 w-full h-full overflow-hidden">
                                            <a  href="{{route('articles',$article->path)}}" class="w-full md:h-full h-max">
                                                <div class="w-full flex flex-col flex-grow-0">
                                                    <div class="w-full overflow-hidden rounded-3xl mb-2 h-max"><img src="{{$article->image_url !== "" ? $article->image_url : 'http://placehold.jp/eeeeee/cccccc/240x240.png?text=No%20Image'}}" class="w-full h-80 md:h-48 max-h-80 object-cover"></div>
                                                    <p class="pt-4 text-red-900 leading-tight line-clamp-4">{{$article->title}}</p>
                                                </div>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="sliderbtn mt-7 md:mt-0 flex gap-3 flex-shrink-0 px-3 md:flex-col items-center md:h-full h-max justify-center"></div>
                            </div>
                            <div class="text-center mt-8 flex-shrink-0">
                                <a href="{{route('articles')}}">Explore All Articles <span class="text-xl text-primary mt-1 ml-2">+</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="w-full bg-gray-900">
            <div class="container mx-auto py-12 testimonial_section" x-data="{ selected : 2 }"  data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                <div class="slider_container flex flex-row w-full h-full flex-auto relative overflow-x-auto mx-auto py-20  hide-scroll smooth-scroll" @click.away="selected=2">
                    <div class="min-w-full md:min-w-0 w-full  md:w-1/3 flex items-center relative md:z-10 transform md:translate-x-16  md:-translate-y-0  cursor-pointer opacity-100 md:opacity-50 transition-all duration-200 ease-in-out" :class="{ 'md:z-20 md:opacity-100  md:-translate-y-10': selected === 1 }" @click="selected=1">
                        <div class="w-11/12 mx-auto rounded-md bg-primary text-white relative">
                            <div class="font-primary text-9xl m-0 absolute -top-8 left-8 transform leading-none">"</div>
                            <div class="font-primary text-9xl m-0 absolute -bottom-8 right-8 transform leading-none rotate-180">"</div>
                            <p class=" text-base font-semibold mx-16 my-8">We rely on SearchMeetings.com to find new overseas buyers. It pays for itself 10x over. This is our main prospection channel now <br> Edward C. Smith, Importer</p>
                        </div>
                    </div>
                    <div class="min-w-full md:min-w-0 w-full  md:w-1/3 flex items-center relative md:z-10 transform md:-translate-y-0 cursor-pointer opacity-100 md:opacity-50 transition-all duration-200 ease-in-out" :class="{ 'md:z-20 md:opacity-100  md:-translate-y-10': selected === 2 }" @click="selected=2">
                        <div class="w-11/12 mx-auto rounded-md bg-primary text-white relative">
                            <div class="font-primary text-9xl m-0 absolute -top-8 left-8 transform leading-none">"</div>
                            <div class="font-primary text-9xl m-0 absolute -bottom-8 right-8 transform leading-none rotate-180">"</div>
                            <p class=" text-base font-semibold mx-16 my-8">Last 6 Months we booked 130 meetings. Our cost per conversion is 75% lower than other channels </br> William Kelly, CEO</p>
                        </div>
                    </div>
                    <div class="min-w-full md:min-w-0 w-full  md:w-1/3 flex items-center relative md:z-10 transform md:-translate-x-16  md:-translate-y-0  cursor-pointer opacity-100 md:opacity-50 transition-all duration-200 ease-in-out" :class="{ 'md:z-20 md:opacity-100  md:-translate-y-10': selected === 3 }" @click="selected=3">
                        <div class="w-11/12 mx-auto rounded-md bg-primary text-white relative">
                            <div class="font-primary text-9xl m-0 absolute -top-8 left-8 transform leading-none">"</div>
                            <div class="font-primary text-9xl m-0 absolute -bottom-8 right-8 transform leading-none rotate-180">"</div>
                            <p class="text-base font-semibold mx-16 my-8">We love the system, Our sales team spending way  less Searching and more selling with SearchMeetings.Com  meetings </br>Henry V, Export Manager </p>
                        </div>
                    </div>
                </div>
                <div class="sliderbtn text-white flex w-full mt-6 pb-6 justify-center space-x-3 pointer-events-none md:hidden">
                </div>
            </div>
        </div>
        <script>
            window.addEventListener('load',()=>{
                $(()=>{

                })
            });
        </script>
    </div>
@endsection


