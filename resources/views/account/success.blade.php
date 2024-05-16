@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://pagecdn.io/lib/font-awesome/5.10.0-11/css/all.min.css" integrity="sha256-p9TTWD+813MlLaxMXMbTA7wN/ArzGyW/L7c5+KkjOkM=" crossorigin="anonymous">
    <div class="container-fluid flex justify-center items-center pt-28">
        <div class="flex flex-col justify-center items-center">
            <div class="p-2" id="animation_container" style="width: 40vw;height: 40vh;">

            </div>
            <span class="text-lg font-bold">Registration successful!</span>
            <span class="text-sm text-black-200 text-center">Check your email for the account verification link to verify your email address and setup a new password.</br>
                If you don’t receive an email within the next few minutes please check your spam box, or promotions tab (if you are using Gmail).
            </span>
            <div class="flex flex-row justify-center gap-2 mt-3">
                <a href="{{route('home')}}" class="w-28 p-2 px-5 my-2 font-semibold bg-primary hover:bg-primary_hover text-white text-center rounded-md focus:outline-none focus:ring-2 ring-blue-300 ring-offset-2">Home</a>
            </div>
        </div>

        <script>
            window.lottie.loadAnimation({
                container: document.getElementById('animation_container'), // the dom element that will contain the animation
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: '/animations/success.json'
            });
        </script>
    </div>

@endsection
