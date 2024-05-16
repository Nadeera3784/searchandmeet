@extends('layouts.app')

@section('content')
    @inject('cartService', 'App\Services\Cart\CartService')
    <div class="w-full px-8 md:px-28 mx-auto p-20">
        <div class="block">
            <a href="{{route('purchase_requirements.search')}}" class="font-semibold flex rounded max-w-max text-purple-500 px-3 py-2 hover:bg-purple-500 hover:text-white text-sm mt-10 md:ml-10">

                <svg class="fill-current mr-2 w-4" viewBox="0 0 448 512"><path d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/></svg>
               Back to search
            </a>
        </div>
        <div class="flex mb-10 flex-col md:flex-row">
            <div class="md:w-3/4 w-full bg-white md:px-10 py-10" x-data="orderDisplayHandler()">
                <div class="flex justify-between pb-8">
                    <h1 class="font-semibold text-2xl">New Meeting Booking</h1>
                    <h2 class="font-semibold text-2xl">{{$cartService->getItemCount()}} Items</h2>
                </div>

                @if($cartService->getItemCount() > 0)
                    @foreach($cartService->getItems() as $item)
                    <div class="p-5 flex flex-col mb-3 sm:flex-row sm:items-center bg-gray-50 hover:bg-gray-100 shadow-md rounded-md relative overflow-hidden" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
                        <div class="flex flex-col">
                            <span class="font-bold text-base">{{ucfirst($item['purchase_requirement']->person->business->name)}} <span class="bg-green-500 px-2 py-1 ml-1 text-xs text-white rounded">Video Meeting</span></span>
                            <span class="text-black-500 text-sm mt-1">Meeting with : {{ucfirst($item['purchase_requirement']->person->name)}}</span>
                            <span class="text-black-500 text-sm">Topic : {{ucfirst($item['purchase_requirement']->product)}}</span>
                            <span class="text-black-500 text-sm">{{\App\Enums\Order\OrderItemType::getKey($item['type'])}}</span>
                            @if($timeslot = $item['timeslot'])
                                <span class="text-left font-semibold text-sm text-muted">
                                    <p class="text-sm my-2"><span x-text="getLocalTime('{{$timeslot}}', timezone, 'Do of MMM YYYY')"></span>  <span class="font-medium " x-text="'From ' + getLocalTime('{{$timeslot}}', timezone, 'hh:mm A')"></span> <span class="font-medium "> To </span> <span x-text="'From ' + getLocalTime('{{\Carbon\Carbon::parse($timeslot)->addMinutes(30)}}', timezone, 'hh:mm A')"></span></p>
                                </span>
                            @else
                                <span class="text-center font-semibold text-sm text-muted">No timeslot selected</span>
                            @endif
                            <span class="text-black-100 text-xs mt-1">Get the direct email and phone number after the meeting</span>
                        </div>
                        <div class="ml-auto flex items-center mt-auto">
                            <div class="text-lg font-bold mr-3 flex items-center">
                                $ {{number_format($cartService->getItemCost($item['type'], $item['purchase_requirement']->person->business->country->id),2)}}
                            </div>
                            <form action="{{route('person.cart.remove')}}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="item_id" value="{{$item['id']}}"/>
                                <button class="text-primary transform hover:bg-primary hover:text-pink-100 bg-pink-100 px-2 py-1 mt-1 rounded flex items-center text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="flex justify-center items-center hover:bg-gray-100 -mx-8 px-6 py-5">
                        <p>No items in cart</p>
                    </d>
                    @endif
            </div>
            @if($cartService->getItemCount() > 0)
                <div id="summary" class="md:w-1/4 w-full py-10" x-data="orderCheckoutHandler()" x-init="init()">
                    <h1 class="font-semibold text-2xl border-b pb-5">Contact Summary</h1>
                    <div class="flex justify-between mt-5 mb-5">
                        <span class="font-semibold text-sm uppercase">{{$item['purchase_requirement']->person->name}} ({{ucfirst($item['purchase_requirement']->product)}}) : {{$cartService->getItemCount()}}</span>
                        <span class="font-semibold text-sm">${{$cartService->getTotal()}}</span>
                    </div>
                    <div>
                        @if($cartService->getItems()[0]['type'] != \App\Enums\Order\OrderItemType::AccessInformation)
                        <form action="{{route('person.cart.reserve')}}" method="POST" >
                            @csrf
                        @if(count($translationCombinations) > 0)
                        <div class="flex-col flex py-1 text-xs gap-2 my-2 bg-gray-50 pt-3 pb-6 px-3 rounded shadow">
                            <div class="flex font-semibold justify-between pt-4 flex-col">
                                <span class="text-black-500 text-lg">Add Translators</span>
                                <span class="text-black-500 text-xs">Preferred languages: {{$item['purchase_requirement']->person->preferredLanguages->pluck('name')->implode(',')}}</span>
                            </div>
                            @foreach($translationCombinations as $translationCombination)
                                <label class="flex items-center text-sm my-1">
                                    <input type="radio" name="translator" value="{{$translationCombination['code']}}" @change="updateCartTotal({{$translationCombination['price']}})" class="form-checkbox h-5 w-5 text-gray-600 outline-none cursor-pointer">
                                    <div class="flex justify-between w-full">
                                        <span class="ml-3 text-gray-700 leading-none">
                                        {{$translationCombination['first']->name}} to {{$translationCombination['second']->name}} translator
                                    </span>
                                        <span class="ml-3 text-gray-700 leading-none font-bold w-9">
                                      $ {{$translationCombination['price']}}
                                    </span>
                                    </div>
                                </label>
                            @endforeach
                            <label class="flex items-center text-sm my-1">
                                <input type="radio" name="translator" checked value="none" @change="updateCartTotal(0)" class="form-checkbox h-5 w-5 text-gray-600 outline-none cursor-pointer">
                                <div class="flex justify-between w-full">
                                        <span class="ml-3 text-gray-700 leading-none">
                                        Don't require translator
                                    </span>
                                    <span class="ml-3 text-gray-700 leading-none font-bold w-9">
                                      $ 0
                                    </span>
                                </div>
                            </label>
                        </div>
                        @endif
                        <div class="flex font-semibold justify-between py-4 text-sm uppercase">
                            <span>Total Amount</span>
                            <span x-text="'$ ' +  cart_total"></span>
                        </div>
                        <div class="flex font-semibold justify-between py-4 text-sm uppercase border-t">
                            <span class="font-bold">Total Due Now</span>
                            <span class="font-bold">$0</span>
                        </div>
                        <div class="flex justify-between py-1 text-xs text-gray-500">
                            <span>You have nothing to pay now, Pay the full amount right before the meeting starts</span>
                        </div>
                        @endif
                        @if($cartService->getItems()[0]['type'] != \App\Enums\Order\OrderItemType::AccessInformation)
                            <button type="submit" class="w-full ml-auto inline-flex mt-2 items-center justify-center  px-4 py-2 text-sm border border-transparent leading-6 font-medium rounded-md text-white bg-teal-500  hover:bg-teal-600 focus:border-rose-700 active:bg-teal-700 transition ease-in-out duration-150">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" style="display: none" xmlns="http://www.w3.org/2000/svg" fill="none" id="button_loader" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Reserve meeting
                            </button>
                            <p class="text-black-100 text-xs mt-4">Please not that frequent cancelling or not being available for your meeting after it has been <b>reserved</b> will result in <b>account suspension.</b></p>
                        </form>
                        @else
                            <button @click="toggleCardModal()" class="w-full justify-center inline-flex mt-4 items-center px-4 py-2 text-sm border border-transparent leading-6 font-medium rounded-md text-white bg-teal-500  hover:bg-teal-600 focus:border-rose-700 active:bg-teal-700 transition ease-in-out duration-150">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" style="display: none" xmlns="http://www.w3.org/2000/svg" fill="none" id="button_loader" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Checkout
                            </button>
                        @endif
                    </div>

                    <div x-show="cardModalOpen" class="fixed z-20 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div :class="cardModalOpen ? 'ease-out duration-300 opacity-100' : 'ease-in duration-200 opacity-0'" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div  :class="cardModalOpen ? 'ease-out duration-300 translate-y-0 sm:scale-100 opacity-100' : 'ease-in duration-200 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95'" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                Checkout
                                            </h3>
                                            <div x-show="modalState === 'default'" class="mt-2">
                                                @if(auth('person')->user()->hasDefaultPaymentMethod())
                                                <p class="text-sm text-gray-500">
                                                    You have a card on file ending with {{auth('person')->user()->defaultPaymentMethod()->card->last4}}.
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                   To use this card, confirm the payment or  <a href="#" @click="updateModalState('payment_methods')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                        select a different payment method
                                                    </a> for purchasing.
                                                </p>
                                                @endif
                                            </div>
                                            <div x-show="modalState === 'payment_methods'" class="mt-2 flex flex-col gap-2">
                                                <p class="text-sm text-gray-500">
                                                    Select payment method type
                                                </p>
                                                <a x-show="defaultPaymentMethod" @click="updateModalState('default')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                    Use default payment method
                                                </a>
                                                <a href="#" @click="updateModalState('card')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                   New Credit/Debit card
                                                </a>
                                                <a href="#" @click="updateModalState('wechat')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                   Wechat payment
                                                </a>
                                            </div>
                                            <div x-show="modalState === 'card'" class="mt-2 flex flex-col gap-5">
                                                <div>
                                                    {!! Form::label('card_name', 'Cardholder name', ['class' => 'block text-xs font-medium text-gray-700 required']); !!}
                                                    {!! Form::text('card_name', old('type_id'), ['id' => 'card-holder-name', 'placeholder' => 'Enter the cardholder\'s name','class' => 'mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                </div>
                                                <div id="card-element" class="mt-1 px-2 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base"></div>
                                                <div class="flex flex-row gap-2">
                                                    {!! Form::checkbox('default_card', null, old('default_card'), ['id' => 'card-default']) !!}
                                                    {!! Form::label('default_card', 'Save as default card?', ['class' => 'block text-xs font-medium text-gray-700 required']); !!}
                                                </div>
                                            </div>
                                            <div x-show="modalState === 'wechat'" class="mt-2 flex items-center">
                                                <div class="flex flex-col gap-5 items-center" x-show="weChatQrCodeUrl !== undefined">
                                                    <canvas id="qr-code-canvas"></canvas>
                                                    <a :href="weChatQrCodeUrl" x-show="weChatQrCodeUrl !== undefined" x-text="'Authorize payment'" class="p-2 rounded shadow text-white font-medium text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2"></a>
                                                    <p class="text-xs text-gray-500 text-center">
                                                        Please scan the QR code above on the Wechat app or click on the link to authorize this payment. Once authorized you will be able to process the payment.
                                                    </p>
                                                    <button x-show="modalState === 'wechat'" :disabled="weChatIsAuthorized === false" type="button" @click="handleWeChatPayment()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-6 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:border-green-700 active:bg-green-700 transition ease-in-out duration-150 focus:outline-none">
                                                        <svg x-show="weChatIsAuthorized === false" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        <span x-text="weChatIsAuthorized === false ? 'Checking authorization' : 'Pay'"></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="text-xs text-red-700 text-left mt-2" x-text="errorContent"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between bg-gray-50 px-4 py-3 sm:px-6">
                                    <div class="flex flex-col">
                                        <a x-show="modalState !== 'payment_methods'" href="#" @click="updateModalState('payment_methods')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-700 text-xs">
                                            Other payment methods
                                        </a>
                                        <div class="flex gap-2 mt-2">
                                            <span class="text-xs text-gray-500">We accept</span>
                                            <img src="{{asset('img/wechat-pay.png')}}" class="h-5"/>
                                            <img src="{{asset('img/placeholder/visa-brand.png')}}" class="h-5"/>
                                            <img src="{{asset('img/placeholder/mastercard-brand.png')}}" class="h-5"/>
                                        </div>
                                    </div>
                                    <div>
                                        <button x-show="!['wechat','payment_methods'].includes(modalState)" @click="handleCheckout()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto md:text-sm text-base">
                                            Pay
                                        </button>
                                        <button type="button" @click="toggleCardModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto md:text-sm text-base">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
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

        function orderCheckoutHandler() {
            return {
                item_cost: {{$cartService->getTotal()}},
                cart_total: 0,
                modalState: 'default',
                cardModalOpen: false,
                defaultPaymentMethod: {{auth('person')->user()->hasDefaultPaymentMethod() ? 1 : 0}},
                errorContent: '',
                weChatLoading: false,
                weChatQrCodeUrl: undefined,
                weChatSourceId: undefined,
                weChatIsAuthorized: false,
                weChatInterval: undefined,
                updateCartTotal(cost){
                    this.cart_total = this.item_cost + cost;
                },
                async pay(paymentMethod = null, setAsDefault = false){
                    this.errorContent = '';
                    const url = '{{route('person.checkout')}}';
                    const options = {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            use_default_card: this.modalState === 'default',
                            payment_method: paymentMethod,
                            save_as_default: setAsDefault
                        })
                    };

                    fetch(url, options)
                        .then(async response => {
                            let data = await response.json();

                            if(response.status !== 200)
                            {
                                let error = new Error(data.message);
                                error.data = data;
                                throw error;
                            }
                        })
                        .then(response => {
                            this.handlePaymentComplete();
                        })
                        .catch(async (error) => {
                            await this.handleErrorResponse(error.data);
                        });

                },
                async handleErrorResponse(data)
                {
                    if (data.message === 'requires_action') {
                        // Use Stripe.js to handle the required card action
                        const { error: errorAction, paymentIntent } =
                            await stripe.confirmCardPayment(data.client_secret);

                        if (errorAction) {
                            this.errorContent =  errorAction.message;
                        } else {
                            this.handlePaymentComplete();
                        }
                    }
                    else if (data.message === 'failed') {
                        this.errorContent =  data.error;
                    }
                },
                handlePaymentComplete(){
                    let event = new CustomEvent('notice', {
                        detail: {
                            'type' : 'success',
                            'text': 'Checked out successfully!'
                        }});
                    this.toggleCardModal();
                    window.dispatchEvent(event);

                    setTimeout(() => {
                        window.location.href = '{{route('person.orders.index')}}';
                    }, 500);
                },
                async handleCheckout(){
                    if(this.modalState === 'default')
                    {
                        this.pay();
                    }
                    else
                    {
                        const cardHolderName = document.getElementById('card-holder-name');
                        const setAsDefault = document.getElementById("card-default").checked;

                        if(cardHolderName.value === '')
                        {
                            this.errorContent = 'Please enter the cardholder name';
                            return;
                        }

                        const { paymentMethod, error } = await stripe.createPaymentMethod(
                            'card', cardElement, {
                                billing_details: { name: cardHolderName.value }
                            }
                        );

                        if (error) {
                            this.errorContent = error.message;
                        } else {
                            this.pay(paymentMethod, setAsDefault);
                        }
                    }
                },
                retrieveWeChatCode(){
                    this.weChatLoading = true;
                    const url = '{{route('order.wechat.source')}}';
                    window.axios.post(url)
                        .then((response) => {
                            this.weChatQrCodeUrl = response.data.qr_code_url;
                            this.weChatSourceId = response.data.source_id;
                            var canvas = document.getElementById('qr-code-canvas');
                            window.qrCode.toCanvas(canvas, this.weChatQrCodeUrl, function (error) {
                                if (error) console.error(error);
                            });

                            this.weChatInterval = setInterval(() => {
                                if(!this.weChatIsAuthorized)
                                {
                                    this.checkAuthorization();
                                }
                                else
                                {
                                    clearInterval(this.weChatInterval);
                                }
                            }, 5000);

                            this.weChatLoading = false;
                        })
                        .catch((error) => {
                            if(error.response.data.error === "payment_method_not_available")
                            {
                                this.errorContent = "Looks like this payment method is not available, please try a different method";
                            }
                            else if(error.response.data.error === "processing_error")
                            {
                                this.errorContent = "Failed to create QR code, please try refreshing your browser";
                            }
                            else
                            {
                                this.errorContent = "Looks like something went wrong, please try refreshing the browser";
                            }

                            this.weChatLoading = false;
                        })
                },
                checkAuthorization(){
                    const url = '{{route('order.wechat.check_authorization')}}';
                    window.axios.post(url, {
                        'source_id': this.weChatSourceId
                    })
                        .then((response) => {
                            if(response.data.status === 'authorized')
                            {
                                this.weChatIsAuthorized = true;
                            }
                            else
                            {
                                this.weChatIsAuthorized = false;
                            }
                        })
                        .catch((error) => {

                        })
                },
                handleWeChatPayment(){
                    const url = '{{route('order.wechat.process_payment')}}';
                    window.axios.post(url, {
                        'source_id': this.weChatSourceId
                        })
                        .then((response) => {
                            window.location.href = '{{route('person.orders.index')}}';
                        })
                        .catch((error) => {
                            this.errorContent = 'Something went wrong, please try again';
                        })
                },
                toggleCardModal(){
                    this.cardModalOpen = !this.cardModalOpen;
                },
                updateModalState(state)
                {
                    if(state === 'wechat' && !this.weChatQrCodeUrl)
                    {
                        this.retrieveWeChatCode();
                    }
                    this.modalState = state;
                    this.errorContent = '';
                },
                init() {
                    cardElement.mount('#card-element');
                    this.cart_total = this.item_cost;
                    if(this.defaultPaymentMethod)
                    {
                        this.modalState = 'default';
                    }
                    else
                    {
                        this.modalState = 'card';
                    }
                }
            }
        }

        function orderDisplayHandler(){
            return {
                timezone: '{{$cartService->getItemCount() > 0 && $cartService->getItems()[0]['purchase_requirement']->person->timezone->name}}',
                getLocalTime(dateTime, timezone, format = 'YYYY-MM-DD HH:mm:ss') {
                    return moment.utc(dateTime).local().format(format);
                },
            }
        }
    </script>
@endsection
