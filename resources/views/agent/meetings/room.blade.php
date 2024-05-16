@extends('layouts.admin')

@section('content')
	<style></style>
	<div class="pb-12 pt-20 min-h-screen">
		<div class="md:w-10/12 w-full mx-auto my-4 md:my-10 px-4">
			<div class="flex flex-col bg-purple-50 rounded-md bg-opacity-70"  x-data="waitingRoomManager()" x-init="init()">
				<div class="px-4 py-5 sm:p-6">
					<div class="flex flex-col items-center justify-between container">
						<h1 class="text-2xl m-0 text-gray-500 font-bold">
							{{ __('Waiting room') }}
						</h1>
						<small class="text-black-200 font-bold">You're in the waiting room, please wait for the other participants to join</small>
					</div>
					<div class="flex">
						<div class="flex justify-center gap-5 items-center w-full">

							<div class="flex-col max-w-sm bg-white shadow-lg rounded-lg overflow-hidden my-4 w-1/5 p-2">
								<div class="my-2 shadow w-20 h-20 relative flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->orderItem->order->person->name))))}}</div>
								<div class="user-details flex flex-col justify-center items-center">
									<span class="font-bold text-lg">{{$meeting->orderItem->order->person->name}}</span>
									<span x-show="!isOnline('{{$meeting->userAlias($meeting->orderItem->order->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
									<span x-show="isOnline('{{$meeting->userAlias($meeting->orderItem->order->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
									<span class="text-black-200 text-md">{{$meeting->orderItem->order->person->business->name}}</span>
									<span class="text-xs">{{$meeting->orderItem->order->person->business->country->name}}</span>
								</div>
							</div>
							<div class="flex-col max-w-sm bg-white shadow-lg rounded-lg overflow-hidden my-4 w-1/5 p-2">
								<div class="my-2 shadow w-20 h-20 relative flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->orderItem->purchase_requirement->person->name))))}}</div>
								<div class="user-details flex flex-col justify-center items-center">
									<span class="font-bold text-lg">{{$meeting->orderItem->purchase_requirement->person->name}}</span>
									<span x-show="!isOnline('{{$meeting->userAlias($meeting->orderItem->purchase_requirement->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
									<span x-show="isOnline('{{$meeting->userAlias($meeting->orderItem->purchase_requirement->person)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
									<span class="text-black-200 text-md">{{$meeting->orderItem->purchase_requirement->person->business->name}}</span>
									<span class="text-xs">{{$meeting->orderItem->purchase_requirement->person->business->country->name}}</span>
								</div>
							</div>
							@if($meeting->agent_id)
								<div class="flex-col max-w-sm bg-white shadow-lg rounded-lg overflow-hidden my-4 w-1/5 p-2" x-cloak>
									<div class="my-2 shadow w-20 h-20 relative flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->agent->name))))}}</div>
									<div class="user-details flex flex-col justify-center items-center">
										<span class="font-bold text-lg">{{$meeting->agent->name}}</span>
										<span x-show="!isOnline('{{$meeting->userAlias($meeting->agent)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
										<span x-show="isOnline('{{$meeting->userAlias($meeting->agent)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
										<span class="text-black-200 text-md">Search Meetings Agent</span>
										<span class="text-xs">Meeting host</span>
									</div>
								</div>
							@endif
							@if($meeting->translator_id)
								<div class="flex-col max-w-sm bg-white shadow-lg rounded-lg overflow-hidden my-4 w-1/5 p-2" x-cloak>
									<div class="my-2 shadow w-20 h-20 relative flex justify-center items-center rounded-full bg-{{\Illuminate\Support\Arr::random(['red', 'green', 'blue', 'black'])}}-500 text-2xl text-white uppercase m-auto">{{ucfirst(implode('', array_map(function($v) { return $v[0]; }, explode(' ', $meeting->translator->name))))}}</div>
									<div class="user-details flex flex-col justify-center items-center">
										<span class="font-bold text-lg">{{$meeting->translator->name}}</span>
										<span x-show="!isOnline('{{$meeting->userAlias($meeting->translator)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-black-400 rounded" >Offline</span>
										<span x-show="isOnline('{{$meeting->userAlias($meeting->translator)}}')" class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-green-500 rounded" >Online</span>
										<span class="text-black-200 text-md">Search Meetings Agent</span>
										<span class="text-xs">Meeting host</span>
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
				<div class="px-4 py-3 text-left mb-3 sm:px-6 flex justify-between">
					<a href="{{route('agent.order.index')}}" class="py-2 px-6 bg-purple-100 hover:bg-purple-300 border border-purple-100 rounded-md shadow-md text-sm font-semibold text-gray-800 focus:outline-none focus:ring-0">
						Leave
					</a>
					<a x-show='!require_payment' @click="is_locked ? handleLockedJoin() : joinMeeting()" :class="is_locked ? 'text-white bg-black-400 hover:bg-black-600' : 'text-white bg-green-500 hover:bg-green-600'" class="flex items-center justify-center gap-2 py-2 px-6 border rounded-md shadow-md text-sm font-semibold cursor-pointer focus:outline-none focus:ring-0">
						<svg x-show="is_locked" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
						</svg>
						<svg x-show="!is_locked" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
						</svg>
						Join meeting
					</a>
					<a x-show='require_payment' @click="toggleCardModal()" class="text-white bg-blue-600 hover:bg-blue-700 flex items-center justify-center gap-2 py-2 px-6 border rounded-md shadow-md text-sm font-semibold cursor-pointer focus:outline-none focus:ring-0">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
						</svg>
						Pay and join
					</a>
				</div>
			</div>
		</div>
	</div>

	<script>
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
				status: '{{$meeting->orderItem->order->status === \App\Enums\Order\OrderStatus::Completed ? 'active' : 'payment'}}',
				require_payment: 0,
				paymentModalState: 'default',
				paymentModalOpen: false,
				defaultPaymentMethod: 0,
				paymentErrorContent: '',
				init() {
					const url = '{{route('agent.meeting.waiting_room.init', $meeting->getRouteKey())}}';
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
								this.roomData = data;
								this.runFlow();

								if(this.roomData.shouldCheckout)
								{
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
				handleLockedJoin(){
					let event = new CustomEvent('notice', {
						detail: {
							'type' : 'error',
							'text': "Please wait a moment for all participants to get ready, the button will turn green once it\'s good to go!"
						}});
					window.dispatchEvent(event);
				},
				isOnline(id)
				{
					return this.online_users.find((item) => item == id);
				},
				async runFlow(){
					this.setupClient();
					await this.login(this.roomData.uid, this.roomData.token);
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
					const url = '{{route('agent.meeting.join', $meeting->getRouteKey())}}';
					const options = {
						method: 'POST',
						headers: {
							'Accept': 'application/json',
							'Content-Type': 'application/json'
						}
					};

					fetch(url, options)
							.then(response => {
								if(response.status !== 200)
								{
									throw new Error(response.message)
								}

								return response.json()
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
			}
		}
	</script>
@endsection