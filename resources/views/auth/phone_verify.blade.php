@extends('layouts.app')

@section('content')
    <div class="px-8 min-h-screen pt-24 overflow-hidden relative">
        <div  class="absolute inset-0 object-fit h-full w-full z-0 overflow-visible" style="z-index: -1;">
            <div class="relative inset-0 object-cover h-full w-full bg opacity-40" style="z-index: 1;">
            </div>
        </div>
        <div class="max-w-sm mx-auto md:max-w-lg relative mt-14">
            <div class="w-full">
                <div class=" py-3 rounded text-center flex flex-col items-center">
                    <h1 class="text-2xl font-bold">Phone Number Verification</h1>
                    <div class="flex flex-col mt-4"><span>Enter the verification code you received at</span> <span
                                class="font-bold">{{auth('person')->user()->routeNotificationForTwilio()}}</span></div>
                    <form action="{{route('person.phone.verify')}}" method="POST" autocomplete="off">
                        @csrf
                        <div class="flex flex-row justify-center text-center px-2 mt-5" >
                        <input class="m-2 border h-10 w-10 text-center form-control rounded number-input"
                               type="text" id="first" maxlength="1" autocomplete="false"/>
                        <input class="m-2 border h-10 w-10 text-center form-control rounded number-input"
                               type="text" id="second" maxlength="1" autocomplete="false"/>
                        <input class="m-2 border h-10 w-10 text-center form-control rounded number-input"
                               type="text" id="third" maxlength="1" autocomplete="false"/>
                        <input class="m-2 border h-10 w-10 text-center form-control rounded number-input"
                               type="text" id="fourth" maxlength="1" autocomplete="false"/>
                        <input class="m-2 border h-10 w-10 text-center form-control rounded number-input"
                               type="text" id="fifth" maxlength="1" autocomplete="false"/>

                        <input type="text" class="m-2 border h-10 w-10 text-center form-control rounded hidden"
                               name="code" id="code_input"/>

                        <script>
                            const code_input = document.getElementById('code_input');
                            var number_inputs = document.getElementsByClassName("number-input");
                            Array.from(number_inputs).forEach(function(element) {
                                element.addEventListener('change', (event) => {
                                    code_input.value = "";

                                    let number_array = [];
                                    Array.from(number_inputs).forEach(function(element) {
                                        number_array.push(element.value);
                                    });

                                    code_input.value = number_array.join('');

                                    console.log(code_input.value);
                                });
                            });

                            Array.from(number_inputs).forEach(function(element, index) {
                                element.addEventListener('keyup', (event) => {
                                    let concernedElement = undefined;
                                    if(event.target.value === "")
                                    {
                                        concernedElement = number_inputs[index-1];
                                    }
                                    else
                                    {
                                        concernedElement = number_inputs[index+1];
                                    }

                                    if(concernedElement)
                                    {
                                        concernedElement.focus();
                                    }
                                    else
                                    {
                                        document.activeElement.blur();
                                    }
                                });
                            });

                        </script>
                    </div>
                    <div class="flex flex-col justify-center items-center m-2 gap-2">
                        @error('code') <div class="text-xs text-red-700 text-left font-bold">{{ $message }}</div> @enderror
                        <button type="submit" class="text-white bg-primary hover:bg-primary_hover w-full py-2 rounded-md cursor-pointer "> Verify </button>
                    </div>
                    </form>
                    <div class="flex justify-center text-center my-2">
                        <form action="{{route('person.phone.verification.resend')}}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center text-blue-700 hover:text-blue-900 cursor-pointer "> Resend Code </button>
                        </form>
                    </div>
                    <div class="mx-auto inline-block relative mt-5">
                        <a href="{{route('person.dashboard')}}"
                           class="font-semibold flex rounded text-purple-500 px-3 py-2 hover:bg-purple-500 hover:text-white text-sm">
                            <svg class="fill-current mr-2 w-4" viewBox="0 0 448 512">
                                <path d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/>
                            </svg>
                            Back to dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
