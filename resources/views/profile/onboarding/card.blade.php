@extends('layouts.app')

@section('content')

    <div id="wrapper" class="max-w-full min-h-screen px-4 md:px-24 pt-28 pb-20 bg">
        <div class="md:w-1/2 w-full flex flex-col justify-center m-auto gap-5 p-6 md:p-16 shadow bg-white rounded-md bg-opacity-80">
            <div>
                <h1>Enter your card details</h1>
                <small class="text-black-100">This is for verification purposes only, We won't be charging any amount on card until you join a meeting. </small>
            </div>
            <div>
                {!! Form::label('card_name', 'Cardholder name', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                {!! Form::text('card_name', old('type_id'), ['id' => 'card-holder-name', 'placeholder' => 'Enter the cardholder\'s name','class' => 'mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                @error('card_name')
                <div class="text-xs text-red-700 text-left">{{ $message }}</div>
                @enderror
            </div>
            <div id="card-element" class="mt-1 px-2 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base"></div>

            <div class="text-xs text-red-700 text-left" id="error-box"></div>

            <div class="flex flex-col justify-center items-center gap-6">
                <button id="card-button" class=" bg-primary p-2 rounded text-white hover:primary_hover px-5 outline-none focus:outline-none">
                   Save as default card
                </button>

                <a href="{{route('person.onboarding', ['skip_card' => 'true'])}}" class="text-sm w-full text-primary hover:text-primary_hover outline-none focus:outline-none flex items-center gap-2">
                    Skip card setup
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <script>
                const stripe = Stripe('{{config('services.stripe.key')}}');

                const elements = stripe.elements();
                const cardElement = elements.create('card',{
                    hidePostalCode: true,
                    style: {
                        base: {
                            iconColor: '#666EE8',
                            color: '#31325F',
                            lineHeight: '40px',
                            fontWeight: 300,
                            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                            fontSize: '15px',

                            '::placeholder': {
                                color: '#000000',
                            },
                        },
                    }
                });

                cardElement.mount('#card-element');

                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');
                const errorBox = document.getElementById('error-box');

                cardButton.addEventListener('click', async (e) => {
                    if(cardHolderName.value === '')
                    {
                        errorBox.innerHTML = 'Please enter the cardholder name';
                        return;
                    }
                    const { paymentMethod, error } = await stripe.createPaymentMethod(
                        'card', cardElement, {
                            billing_details: { name: cardHolderName.value }
                        }
                    );

                    if (error) {
                        errorBox.innerHTML = error.message;
                    } else {
                        errorBox.innerHTML = '';
                        const url = '{{route('person.cards.update')}}';
                        const options = {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                payment_method: paymentMethod,
                            })
                        };

                        fetch(url, options)
                            .then(async response => {
                                let data = await response.json();

                                if(response.status !== 200)
                                {
                                    throw new Error(data.error)
                                }
                            })
                            .then(data => {
                                let event = new CustomEvent('notice', {
                                    detail: {
                                        'type' : 'success',
                                        'text': 'Payment method updated successfully!'
                                    }});

                                window.dispatchEvent(event);
                                setTimeout(() => {
                                    window.location.href = '{{route('person.dashboard')}}';
                                }, 500);
                            })
                            .catch((error) => {
                                //handle additional actions and new payment method
                                errorBox.innerHTML =  error.message;
                            });
                    }
                });
            </script>
        </div>
    </div>
@endsection
