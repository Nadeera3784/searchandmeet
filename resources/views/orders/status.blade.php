@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="https://pagecdn.io/lib/font-awesome/5.10.0-11/css/all.min.css" integrity="sha256-p9TTWD+813MlLaxMXMbTA7wN/ArzGyW/L7c5+KkjOkM=" crossorigin="anonymous">
    <div class="container-fluid flex justify-center items-center pt-28">
        <div class="flex flex-col justify-center items-center">
            <div class="p-2" id="animation_container" style="width: 50vw;height: 50vh;">

            </div>
            @if(auth('person')->check())
                <p class="text-center">Go to dashboard</p>
                <div class="flex flex-row justify-center gap-2">
                    <button class="w-28 p-2 px-5 my-2 font-semibold bg-primary hover:bg-primary_hover text-white rounded-md focus:outline-none focus:ring-2 ring-blue-300 ring-offset-2">Home</button>
                    <button class="w-28 p-2 px-5 my-2 font-semibold bg-purple-500 hover:bg-purple-100 hover:text-purple-500 text-purple-100 rounded-md focus:outline-none focus:ring-2 ring-blue-300 ring-offset-2">Dashboard</button>
                </div>
            @else
                <p class="text-center">Login to your account to view the contacts details.</p>
                <div class="flex flex-row justify-center gap-2">
                    <button class="w-28 p-2 px-5 my-2 font-semibold bg-primary hover:bg-primary_hover text-white rounded-md focus:outline-none focus:ring-2 ring-blue-300 ring-offset-2">Home</button>
                    <button class="w-28 p-2 px-5 my-2 font-semibold bg-purple-500 hover:bg-purple-100 hover:text-purple-500 text-purple-100 rounded-md focus:outline-none focus:ring-2 ring-blue-300 ring-offset-2">Log in</button>
                </div>
            @endif
        </div>

        @if(request()->has('status') && request()->get('status') === 'success')
            <script>
                window.lottie.loadAnimation({
                    container: document.getElementById('animation_container'), // the dom element that will contain the animation
                    renderer: 'svg',
                    loop: false,
                    autoplay: true,
                    path: '/animations/payment_successful.json'
                });
            </script>
        @endif
        @if(request()->has('status') && request()->get('status') === 'cancelled')
                <script>
                    window.lottie.loadAnimation({
                        container: document.getElementById('animation_container'), // the dom element that will contain the animation
                        renderer: 'svg',
                        loop: false,
                        autoplay: true,
                        path: '/animations/payment_failed.json'
                    });
                </script>
        @endif
    </div>

@endsection
