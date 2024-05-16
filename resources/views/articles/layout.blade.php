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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.3.1/build/styles/default.min.css">

    <link rel="icon" href="/img/favicon.svg" sizes="any" type="image/x-icon">
    <title>Search Meetings | Blogs</title>
</head>
<body>
    <div class="max-w-screen-2xl w-full mx-auto">
        <div class="grid {{$article->image_url !== '' ? 'md:grid-cols-2' : 'bg-primary'}} relative grid-cols-1 overflow-hidden md:bg-primary"  style="min-height : 30rem;">
            @if($article->image_url !== '')
            <div class="col-span-1 h-full md:relative absolute inset-0">
                    <img src={{$article->image_url}} alt="article cover" class="w-full h-full object-cover">
            </div>
            @endif
            <div class="col-span-1 w-full h-full">
                <div class="flex p-10 flex-col w-full justify-end h-full relative md:bg-transparent bg-black-900  {{$article->image_url !== '' ? 'bg-opacity-50' : 'bg-opacity-0'}} ">
                    <div class="absolute top-20 right-20 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-28 w-28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h1 class="text-white text-xl font-semibold absolute top-2 -left-28 origin-bottom-right transform  -rotate-90">{{date("F d, Y",strtotime($article->date))}}</h1>
                    <h1 class="text-white md:text-4xl text-2xl font-semibold md:w-4/5 w-full  ">{{$article->title}}</h1>
                    <div class="flex items-center mt-5 pr-5 text-white hidden">
                        <p class=" flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                          </svg> 2.5K </p>
                        <p class="ml-10 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                          </svg> 183</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-auto max-w-screen-lg w-10/12 text-justify my-12  article-page">
            {!! $article->view !!}
        </div>
        <div class="text-center mb-12 flex-shrink-0 border border-footer w-max mx-auto py-2 px-6">
            <a href="{{route('articles')}}" class="leading-none m-0">Explore All Articles <span class="text-xl text-primary mt-1 ml-2 leading-none">+</span></a>
        </div>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.3.1/build/highlight.min.js"></script>
    <!-- and it's easy to individually load additional languages -->
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.3.1/build/languages/go.min.js"></script>
    <script>hljs.highlightAll();</script>
</body>
</html>
