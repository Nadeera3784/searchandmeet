@extends('layouts.app')

@section('content')
    <style></style>
    <div class="bg pb-12 pt-20 min-h-screen relative overflow-hidden"  x-data="waitingRoomManager()" x-init="init()">
        <div class="bg-white bg-opacity-60 inset-0 absolute pointer-events-none"></div>
        <div class="md:w-8/12 w-full mx-auto my-4 md:my-10 px-4 relative">
            <img src="/img/RedLine.png" class="absolute left-0 bottom-1/2  transform translate-y-1/2 -translate-x-full transition-opacity duration-150 ease-out opacity-0 md:opacity-100 object-cover" style="z-index: 2;" >
            <img src="/img/RedLine.png" class="absolute right-0 top-1/2  transform -translate-y-1/2 translate-x-full transition-opacity duration-150 ease-out opacity-0 md:opacity-100 object-cover" style="z-index: 2;" >
            <img src="/img/RoomIcon.png" class="mx-auto object-cover mb-3" style="z-index: 2;" >
            <div class="flex flex-col rounded-md relative overflow-hidden">
                <img src="/img/WaitingRoom.png" class="absolute inset-x-0 bottom-0 w-full transform transition-opacity duration-150 ease-out opacity-0 md:opacity-100 object-cover">
                <div class="px-4 py-5 sm:p-6 relative">
                    <div class="flex flex-col items-center justify-between container">
                        <small class="md:text-white text-gray-900 font-bold">You're in the waiting room, please wait for the other participants to join</small>
                    </div>
                    <div class="flex md:flex-row flex-col items-start justify-center gap-5 mt-12">
                        <div class="flex-col md:w-48 w-full h-full bg-white text-gray-900 shadow-lg relative rounded-lg my-4 p-2">
                            <div class="my-2 shadow w-20 h-20 absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->orderItem->order->person->name))))}}</div>
                            <div class="user-details flex flex-col justify-center items-center gap-2 mt-12 mb-3">
                                <span class="font-bold text-lg text-center">{{$meeting->orderItem->order->person->name}}</span>
                                <span x-show="!isOnline('{{$meeting->userAlias($meeting->orderItem->order->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
                                <span x-show="isOnline('{{$meeting->userAlias($meeting->orderItem->order->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
                                <span class="text-gray-700 text-md text-center">{{$meeting->orderItem->order->person->business->name}}</span>
                                <span class="text-xs">{{$meeting->orderItem->order->person->business->country->name}}</span>
                            </div>
                        </div>
                        <div class="flex-col md:w-48 w-full h-full bg-white text-gray-900 shadow-lg relative rounded-lg my-4 p-2">
                            <div class="my-2 shadow w-20 h-20 absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->orderItem->purchase_requirement->person->name))))}}</div>
                            <div class="user-details flex flex-col justify-center items-center gap-2 mt-12 mb-3">
                                <span class="font-bold text-lg text-center">{{$meeting->orderItem->purchase_requirement->person->name}}</span>
                                <span x-show="!isOnline('{{$meeting->userAlias($meeting->orderItem->purchase_requirement->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
                                <span x-show="isOnline('{{$meeting->userAlias($meeting->orderItem->purchase_requirement->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
                                <span class="text-gray-700 text-md text-center">{{$meeting->orderItem->purchase_requirement->person->business->name}}</span>
                                <span class="text-xs">{{$meeting->orderItem->purchase_requirement->person->business->country->name}}</span>
                            </div>
                        </div>
                        @if($meeting->agent_id)
                            <div class="flex-col md:w-48 w-full h-full bg-white text-gray-900 shadow-lg relative rounded-lg my-4 p-2" x-cloak>
                                <div class="my-2 shadow w-20 h-20 absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->agent->name))))}}</div>
                                <div class="user-details flex flex-col justify-center items-center gap-2 mt-12 mb-3">
                                    <span class="font-bold text-lg text-center">{{$meeting->agent->name}}</span>
                                    <span x-show="!isOnline('{{$meeting->userAlias($meeting->agent)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
                                    <span x-show="isOnline('{{$meeting->userAlias($meeting->agent)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
                                    <span class="text-gray-700 text-md text-center">Search Meetings Agent</span>
                                    <span class="text-xs">Meeting host</span>
                                </div>
                            </div>
                        @endif
                        @if($meeting->translator_id)
                            <div class="flex-col md:w-48 w-full h-full bg-white text-gray-900 shadow-lg relative rounded-lg my-4 p-2" x-cloak>
                                <div class="my-2 shadow w-20 h-20 absolute top-0 left-1/2 transform -translate-y-1/2 -translate-x-1/2 flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->translator->name))))}}</div>
                                <div class="user-details flex flex-col justify-center items-center gap-2 mt-12 mb-3">
                                    <span class="font-bold text-lg text-center">{{$meeting->translator->name}}</span>
                                    <span x-show="!isOnline('{{$meeting->userAlias($meeting->translator)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
                                    <span x-show="isOnline('{{$meeting->userAlias($meeting->translator)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
                                    <span class="text-gray-700 text-md text-center">Search Meetings Agent</span>
                                    <span class="text-xs">Translator</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="px-4 py-3 text-left mb-3 sm:px-6 flex justify-between relative">
                    <a href="{{route('person.orders.index')}}" class="py-2 px-6 flex items-center bg-purple-100 hover:bg-purple-300 border border-purple-100 rounded-md shadow-md text-sm font-semibold text-gray-800 focus:outline-none focus:ring-0">
                        Leave
                    </a>
                    <a x-show='!require_payment' @click="is_locked ? handleLocked('join') : joinMeeting()" :class="is_locked ? 'text-white bg-black-400 hover:bg-black-600' : 'text-white bg-primary hover:bg-primary_hover'" class="flex items-center justify-center gap-2 py-2 px-6 border rounded-md shadow-md text-sm font-semibold cursor-pointer focus:outline-none focus:ring-0">
                        <svg x-show="is_locked" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <svg x-show="!is_locked" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                        </svg>
                        Join meeting
                    </a>
                    <a x-show='require_payment' @click="can_process_payment ? toggleCardModal() : handleLocked('payment')"  :class="can_process_payment ? 'bg-blue-600 hover:bg-blue-700' : 'bg-black-400 hover:bg-black-600'" class="text-white flex items-center justify-center gap-2 py-2 px-6 border rounded-md shadow-md text-sm font-semibold cursor-pointer focus:outline-none focus:ring-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Pay and join
                    </a>
                </div>
                <div x-show="paymentModalOpen" class="fixed z-20 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div :class="paymentModalOpen ? 'ease-out duration-300 opacity-100' : 'ease-in duration-200 opacity-0'" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div  :class="paymentModalOpen ? 'ease-out duration-300 translate-y-0 sm:scale-100 opacity-100' : 'ease-in duration-200 opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95'" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
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
                                        <div x-show="paymentModalState === 'default'" class="mt-2">
                                            @if(auth('person')->user()->hasDefaultPaymentMethod())
                                                <p class="text-sm text-gray-500">
                                                    You have a card on file ending with {{auth('person')->user()->defaultPaymentMethod()->card->last4}}.
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    To use this card, confirm the payment or  <a href="#" @click="updateModalState('payment_methods')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                        select a different payment method
                                                    </a> for purchasing.
                                                </p>
                                            @endif
                                        </div>
                                        <div x-show="paymentModalState === 'payment_methods'" class="mt-2 flex flex-col gap-2">
                                            <p class="text-sm text-gray-500">
                                                Select payment method type
                                            </p>
                                            <a x-show="defaultPaymentMethod" @click="updateModalState('default')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                Use default payment method
                                            </a>
                                            <a href="#" @click="updateModalState('card')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                Credit/Debit card
                                            </a>
                                            <a href="#" @click="updateModalState('wechat')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-600">
                                                Wechat payment
                                            </a>
                                        </div>
                                        <div x-show="paymentModalState === 'card'" class="mt-2 flex flex-col gap-5">
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
                                        <div x-show="paymentModalState === 'wechat'" class="mt-2 flex items-center">
                                            <div class="flex flex-col gap-5 items-center" x-show="weChatQrCodeUrl !== undefined">
                                                <canvas id="qr-code-canvas"></canvas>
                                                <a :href="weChatQrCodeUrl" x-show="weChatQrCodeUrl !== undefined" x-text="'Authorize payment'" class="p-2 rounded shadow text-white font-medium text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2"></a>
                                                <p class="text-xs text-gray-500 text-center">
                                                    Please scan the QR code above on the Wechat app or click on the link to authorize this payment. Once authorized you will be able to process the payment.
                                                </p>
                                                <button x-show="paymentModalState === 'wechat'" :disabled="weChatIsAuthorized === false" type="button" @click="handleWeChatPayment()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-6 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:border-green-700 active:bg-green-700 transition ease-in-out duration-150 focus:outline-none">
                                                    <svg x-show="weChatIsAuthorized === false" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    <span x-text="weChatIsAuthorized === false ? 'Checking authorization' : 'Pay'"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="text-xs text-red-700 text-left mt-2" x-text="paymentErrorContent"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between bg-gray-50 px-4 py-3 sm:px-6">
                                <div class="flex flex-col">
                                    <a x-show="paymentModalState !== 'payment_methods'" href="#" @click="updateModalState('payment_methods')" class="cursor-pointer font-bold text-blue-500 hover:text-blue-700 text-xs">
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
                                    <button x-show="!['wechat','payment_methods'].includes(paymentModalState)" @click="handleCheckout()" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto md:text-sm text-base">
                                        Pay
                                    </button>
                                    <button type="button" @click="toggleCardModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto md:text-sm text-base">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($meeting->alert_count > 0)
        <div class="flex flex-col items-center justify-between container">
            <div class="flex items-center gap-2 text-black-500" style="z-index: 2;">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <small class="font-bold">
                    Participants haven't joined yet?
                </small>
            </div>
            <div class="flex">
                <small class="text-black-200" style="z-index: 2;">
                   Send email and SMS reminders to all participants in the meeting
                </small>
            </div>
            <a @click="sendMeetingReminders()" class="mt-2 flex  text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none px-4 py-2 text-sm rounded shadow cursor-pointer" style="z-index: 2;">
                <svg x-show="sendReminderLoading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="z-index: 2;">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Send
            </a>
        </div>
        @endif
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

        function waitingRoomManager()
        {
            return {
                roomData: {},
                client: null,
                channel: null,
                online_users: [],
                current_user_id: undefined,
                can_notify: false,
                is_locked: true,
                can_process_payment: false,
                status: '{{$meeting->orderItem->order->status === \App\Enums\Order\OrderStatus::Completed ? 'active' : 'payment'}}',
                require_payment: {{($meeting->orderItem->order->status !== \App\Enums\Order\OrderStatus::Completed) && ($meeting->orderItem->order->person->id == auth('person')->user()->id)  ? 1 : 0}},
                paymentModalState: 'default',
                paymentModalOpen: false,
                defaultPaymentMethod: {{auth('person')->user()->hasDefaultPaymentMethod() ? 1 : 0}},
                paymentErrorContent: '',
                weChatLoading: false,
                weChatQrCodeUrl: undefined,
                weChatSourceId: undefined,
                weChatIsAuthorized: false,
                weChatInterval: undefined,
                sendReminderLoading: false,
                sendReminderEnabled: true,
                init() {
                    const url = `/meetings/{{$meeting->getRouteKey()}}/waiting-room`;
                    const options = {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                    };

                    fetch(url, options)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            this.roomData = data;
                            this.runFlow();

                            if(this.roomData.shouldCheckout)
                            {
                                cardElement.mount('#card-element');

                                if(this.defaultPaymentMethod)
                                {
                                    this.paymentModalState = 'default';
                                }
                                else
                                {
                                    this.paymentModalState = 'card';
                                }
                            }

                            if (!("Notification" in window)) {
                                console.log("This browser does not support desktop notification");
                            }
                            else
                            {
                                Notification.requestPermission().then(function (permission) {
                                    if (permission === "granted") {
                                        this.can_notify = true;
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.log(error);
                        });

                },
                handleRtmEvents(event, args){
                    switch(event)
                    {
                        case 'ConnectionStateChanged':
                            break;
                        case 'MessageFromPeer':
                            break;
                        case 'ChannelMessage':
                            break;
                        case 'MemberJoined':
                            this.sendBrowserNotification({
                                title: 'Search meetings',
                                text: 'User is online in the waiting room'
                            });
                            this.online_users.push(args);
                            break;
                        case 'MemberLeft':
                            this.online_users = this.online_users.filter((item) => item != args);
                            break;
                        case 'AttributesUpdated':
                             this.status = args.status?.value;
                             if(this.status === 'active')
                             {
                                 this.sendBrowserNotification({
                                     title: 'Search meetings',
                                     text: 'The meeting is active, please join now!'
                                 });
                             }
                            break;
                    }
                    this.checkLock();
                },
                isOnline(id)
                {
                    return this.online_users.find((item) => item == id);
                },
                async runFlow(){
                    this.setupClient();
                    await this.login(this.roomData.uid, this.roomData.token);
                    @if($meeting->orderItem->purchase_requirement->person == auth('person')->user())
                    await this.setupAttributes();
                    @endif
                    await this.join(this.roomData.channel);
                },
                setupClient()
                {
                    this.client = window.AgoraRtm.createInstance(this.roomData.appId);
                    this.subscribeClientEvents();
                },
                async setupAttributes()
                {
                    await this.client.setChannelAttributes(this.roomData.channel, {
                        status: '{{$meeting->orderItem->order->status === \App\Enums\Order\OrderStatus::Completed ? 'active' : 'payment'}}'
                    });
                },
                async updateChannelAttributes(attributes)
                {
                    await this.client.addOrUpdateChannelAttributes(this.roomData.channel, attributes, {enableNotificationToChannelMembers: true});
                },
                async login(uid, token){
                    try {
                        await this.client.login({uid: uid, token});
                        const portions = uid.split('_');
                        this.current_user_id = portions[2];
                        window.addEventListener('beforeunload', (event) => {
                            this.logout();
                        });
                    }
                    catch (e) {
                        console.error(e);
                    }
                },
                async syncOnlineUsers()
                {
                    try {
                        const members = await this.channel.getMembers();
                        members.forEach((member) => {
                            this.online_users.push(member);
                        });

                        this.checkLock();
                    }
                    catch (e) {
                        console.error(e);
                    }
                },
                checkLock(){
                    if(this.status === 'active')
                    {
                        this.is_locked = false;
                    }
                    else if(this.online_users.length < this.roomData.capacity || this.status === 'payment')
                    {
                        this.is_locked = true;
                    }

                    if(this.online_users.length === this.roomData.capacity && this.status === 'payment')
                    {
                        this.can_process_payment = true;
                    }
                },
                async logout(){
                    await this.client.logout();
                },
                async join(name){
                    try {
                        console.log('joinChannel', name);
                        const channel = this.client.createChannel(name);
                        this.channel = channel;
                        this.subscribeChannelEvents();
                        await channel.join();
                        this.syncOnlineUsers();
                    }
                    catch (e) {
                        console.error(e);
                    }
                },
                async sendMeetingReminders(){
                    this.sendReminderLoading = true;
                    window.axios.post('{{route('person.meeting.reminders' ,$meeting->getRouteKey())}}')
                        .then((response) => {
                            let event = new CustomEvent('notice', {
                                detail: {
                                    'type' : 'success',
                                    'text': 'Successfully sent out reminders!'
                                }});
                            window.dispatchEvent(event);
                            this.sendReminderLoading = false;
                        })
                        .catch((error) => {
                            let event = new CustomEvent('notice', {
                                detail: {
                                    'type' : 'info',
                                    'text': 'Maximum reminder limit reached'
                                }});
                            window.dispatchEvent(event);
                            this.sendReminderLoading = false;
                        });
                },
                subscribeClientEvents (){
                    const clientEvents = [
                        'ConnectionStateChanged',
                        'MessageFromPeer'
                    ];

                    clientEvents.forEach((eventName) => {
                        this.client.on(eventName, (...args) => {
                            console.log('emit ', eventName, ...args);
                            // log event message
                            this.handleRtmEvents(eventName, ...args)
                        });
                    });
                },
                subscribeChannelEvents(){
                    const channelEvents = [
                        'ChannelMessage',
                        'MemberJoined',
                        'MemberLeft',
                        'AttributesUpdated'
                    ];

                    channelEvents.forEach((eventName) => {
                        this.channel.on(eventName, (...args) => {
                            console.log('emit ', eventName, ...args)
                            // log event message
                            this.handleRtmEvents(eventName, ...args)
                        });
                    });
                },
                sendBrowserNotification(notification, allTabs = true) {
                    if(this.can_notify)
                    {
                        if(allTabs)
                        {
                            new Notification(notification.title, {
                                body: notification.text
                            });
                        }
                        else if (document.visibilityState !== "visible")
                        {
                            new Notification(notification.title, {
                                body: notification.text
                            });
                        }
                    }
                },
                joinMeeting()
                {
                    const url = '{{route('person.meeting.join', $meeting->getRouteKey())}}';
                    const options = {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    };

                    fetch(url, options)
                        .then(async response => {
                            let data = await response.json();

                            if(response.status !== 200)
                            {
                                throw new Error(data.error)
                            }

                            return data;
                        })
                        .then(data => {
                            window.location.href = data.link;
                        })
                        .catch((error) => {
                            let event = new CustomEvent('notice', {
                                detail: {
                                    'type' : 'error',
                                    'text': 'Something went wrong, please try reloading the page'
                                }});
                            window.dispatchEvent(event);
                        });

                },
                async pay(paymentMethod = null, setAsDefault = false){
                    this.paymentErrorContent = '';
                    const url = '{{route('person.checkout')}}';
                    const options = {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: '{{$meeting->orderItem->order->getRouteKey()}}',
                            use_default_card: this.paymentModalState === 'default',
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

                        console.log(errorAction);
                        console.log(paymentIntent);
                        if (errorAction) {
                            this.paymentErrorContent =  errorAction.message;
                        } else {
                            this.handlePaymentComplete();
                        }
                    }
                    else if (data.message === 'failed') {
                        this.paymentErrorContent =  data.error;
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

                    this.updateChannelAttributes({
                        status: 'active'
                    });

                    this.status = 'active';
                    this.require_payment = 0;
                },
                async handleCheckout(){
                    if(this.paymentModalState === 'default')
                    {
                        this.pay();
                    }
                    else
                    {
                        const cardHolderName = document.getElementById('card-holder-name');
                        const setAsDefault = document.getElementById("card-default").checked;

                        if(cardHolderName.value === '')
                        {
                            this.paymentErrorContent = 'Please enter the cardholder name';
                            return;
                        }

                        const { paymentMethod, error } = await stripe.createPaymentMethod(
                            'card', cardElement, {
                                billing_details: { name: cardHolderName.value }
                            }
                        );

                        if (error) {
                            this.paymentErrorContent = error.message;
                        } else {
                            this.pay(paymentMethod, setAsDefault);
                        }
                    }
                },
                retrieveWeChatCode(){
                    this.weChatLoading = true;
                    const url = '{{route('order.wechat.source')}}';
                    window.axios.post(url, {
                        'order_id': '{{$meeting->orderItem->order->getRouteKey()}}'
                    })
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
                                this.paymentErrorContent = "Looks like this payment method is not available, please try a different method";
                            }
                            else if(error.response.data.error === "processing_error")
                            {
                                this.paymentErrorContent = "Failed to create QR code, please try refreshing your browser";
                            }
                            else
                            {
                                this.paymentErrorContent = "Looks like something went wrong, please try refreshing the browser";
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
                            this.handlePaymentComplete();
                        })
                        .catch((error) => {
                            this.paymentErrorContent = 'Something went wrong, please try again';
                        })
                },
                handleLocked(intent){
                    switch(intent)
                    {
                        case "join":
                            var event = new CustomEvent('notice', {
                                detail: {
                                    'type' : 'info',
                                    'text': "Please wait a moment for all participants to get ready, the button will turn green once it\'s good to go!"
                                }});
                            window.dispatchEvent(event);
                            break;
                        case "payment":
                            var event = new CustomEvent('notice', {
                                detail: {
                                    'type' : 'info',
                                    'text': "Please wait a moment for all participants to get ready, you can make the payment once all participants are in the waiting room!"
                                }});
                            window.dispatchEvent(event);
                            break;
                    }
                },
                toggleCardModal(){
                    this.paymentModalOpen = !this.paymentModalOpen;
                },
                updateModalState(state)
                {
                    if(state === 'wechat' && !this.weChatQrCodeUrl)
                    {
                        this.retrieveWeChatCode();
                    }

                    this.paymentModalState = state;
                    this.paymentErrorContent = '';
                },
            }
        }
    </script>
@endsection
