<!doctype html>
<html lang="en">
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
    <title>Search Meetings | Blogs</title>

    <meta type="description" content="Search among thousands of meeting requests with purchase requirements, pick an available time and meet the decision makers directly on video meetings, or just post your meeting request FREE."/>
    <meta type="keywords" content="search,meetings,global,business,import,export,meet,now"/>
</head>
<body>
    <script>
        window.addEventListener('load',()=>{
            $(()=>{
                if(screen.width < 768){
                    slider_h('article_section');
                }else{
                    slider('article_section');
                }
            });
            $(window).resize(function() {
                if(screen.width < 768){
                    slider_h('article_section');
                }else{
                    slider('article_section');
                }
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
                    if(screen.width < 768) return false;
                    var scrollW = $('.'+section+' .slider_container')[0].scrollWidth;
                    $('.'+section+' .sliderbtn>div').each((index,el) => {
                        $(el).css('opacity','0.5');
                        var scrollAt = $('.'+section+' .slider_container').scrollLeft();
                        var scrollOffset = $('.'+section+' .slider_container>div').innerWidth();
                        if( scrollAt < (scrollOffset * (index + 1)) - 10 && scrollAt >= (scrollOffset * index) - 10){
                            $(el).css('opacity','1');
                        }
                    });
                });
            }

            const slider_h = (section) => {
                if($('.'+section).length == 0) return;
                let html = '';
                const perSlide = 1;
                for(let i = 0; i < Math.round($('.'+section+' .slider_container>div').length/perSlide + 0.1) ; i++){
                    html += '<div index='+i+' class="bg-primary pointer-events-auto cursor-pointer hover:opacity-100 h-1.5 w-7 rounded-full transition-opacity duration-100 ease-in"></div>';
                }
                $('.'+section+' .sliderbtn').html(html);
                $('.'+section+' .sliderbtn>div').click(e => {
                    $('.'+section+' .sliderbtn>div').css('opacity','0.5');
                    $(e.target).css('opacity','1');
                    $('.'+section+' .slider_container').scrollTop($('.'+section+' .slider_container>div').innerHeight() * $(e.target).attr('index'))
                });
                $($('.'+section+' .sliderbtn>div')[0]).click();
                $('.'+section+' .slider_container').on('scroll',(e) => {
                    if(screen.width > 768) return false;
                    var scrollW = $('.'+section+' .slider_container')[0].scrollWidth;
                    $('.'+section+' .sliderbtn>div').each((index,el) => {
                        $(el).css('opacity','0.5');
                        var scrollAt = $('.'+section+' .slider_container').scrollTop();
                        var scrollOffset = $('.'+section+' .slider_container>div').innerHeight();
                        if( scrollAt < (scrollOffset * (index + 1) - 10 ) && scrollAt >= (scrollOffset * index) - 10){
                            $(el).css('opacity','1');
                        }
                    });
                });
            }
        });
    </script>
    <div class="max-w-screen-2xl w-full mx-auto overflow-hidden">
        <div class="w-full h-screen bg-blog-banner z-0 bg-no-repeat bg-cover object-fill bg-center flex flex-col">

            <div class="article_section w-full h-2/3 md:h-auto mt-auto bg-black-900 bg-opacity-70">
                <div class=" w-full md:h-72 h-full mt-auto bg-no-repeat bg-contain object-fill bg-center bg-lines ">
                    <div class="w-7/12 h-full mx-auto md:overflow-x-auto overflow-y-auto md:overflow-y-hidden smooth-scroll hide-scroll slider_container flex flex-col md:flex-row flex-auto items-center">
                        @foreach ($articles as $article)
                            <div class="w-full min-w-full h-full flex-shrink-0 mx-auto flex md:flex-row flex-col items-center justify-center text-white gap-4">
                                <div class="w-full font-bold md:text-4xl text-xl leading-snug line-clamp-3">{{$article->title}}</div>
                                @if($article->description !== "")
                                    <div class="w-full font-semibold leading-snug line-clamp-3">{{$article->description}}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="sliderbtn w-full py-5 flex gap-2 justify-center items-center"></div>
            </div>
        </div>
        <div class="w-full md:p-16 py-16 px-8 ">
            <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-4">
                @foreach ($articles as $article)
                    <a href="{{route('articles',$article->path)}}" class="w-full relative min-h-60 flex hover:bg-primary group font-semibold transition-all">
                        <div class="w-14 h-full flex-shrink-0">
                            <div class="px-3 mt-14 origin-bottom-right transform -rotate-90 h-14 whitespace-nowrap leading-none flex items-center text-gray-400 group-hover:text-white">{{date("F d, Y",strtotime($article->date))}}</div>
                        </div>
                        <div class="w-full ">
                            <div class="w-full mb-2 border-0 h-64"><img src={{$article->image_url}} class="w-full h-full object-cover"></div>
                            <div class="flex items-center my-5 justify-between pr-5 text-gray-400 group-hover:text-white">
                                <p class="text-red-900 group-hover:text-white line-clamp-2">{{$article->title}}</p>
                                <p>></p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="">
            <div class="flex flex-col items-center my-12 article-pagiation">
                {{$articles->links()}}
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>
</body>
</html>
