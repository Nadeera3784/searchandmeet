@extends('layouts.admin')

@section('content')
	@inject('timezoneService', 'App\Services\DateTime\TimeZoneService')
	@inject('translationService', 'App\Services\Language\TranslationService')
	<style>

		.modal-overlay {
			align-items: center;
			background: rgba(0, 0, 0, 0.5);
			display: flex;
			height: 100vh;
			justify-items: center;
			left: 0;
			position: fixed;
			top: 0;
			width: 100vw;
			z-index: 99;
		}
		.modal-container {
			background: white;
			height: 40vh;
			margin: auto;
			overflow: auto;
			width: 40vw;
		}
		.modal-container > .modal-head {
			background: #355c7d;
			color: white;
			display: flex;
			justify-content: space-between;
			padding: 15px;
			position: sticky;
			top: 0;
			z-index: 2;
		}
		.modal-container > .modal-head > .close {
			cursor: pointer;
			font-size: 15px;
			margin-right: -15px;
			text-align: center;
			width: 40px;
		}
		.modal-container > .modal-body {
			padding: 0 20px;
		}

	</style>
	<div class="pb-12 pt-7">
		<div class="max-w-8xl mx-auto sm:px-6 lg:px-8" x-data="chatHandler()" x-init="init()">
			<div class="flow-root mb-3">
				<div class="flex justify-between mb-3">
					<h1 class="text-xl font-bold text-gray-500">
						{{ __('Communications center') }}
					</h1>
				</div>
			</div>
			<div class="bg-white overflow-hidden shadow-sm">
				<div class="modal-overlay" x-show="modalVisible" x-cloak>
					<div class="modal-container" x-show="modalVisible" x-cloak>

						<div class="modal-head">
							<div class="article-attributes">
								<span x-show="modalIntent === 'message'">Send an attachment from your resources (Requirements, People, Orders, Meetings)</span>
							</div>
							<div class="close" @click="closeModal();"><i class="fas fa-times">X</i></div>
						</div>

						<div class="modal-body">
							<div class="w-full flex flex-col gap-3 py-2" x-show="modalIntent === 'message'">
								<div class="flex-col">
									<label for="status" class="block text-sm font-medium text-gray-700">Type of attachment</label>
									<select class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md" x-model="contentType">
										<option selected="selected" :value="null">Select content type</option>
										<option value="{{\App\Enums\Communication\MessageType::Person}}">Person</option>
										<option value="{{\App\Enums\Communication\MessageType::Order}}">Order</option>
										<option value="{{\App\Enums\Communication\MessageType::Requirement}}">Purchase requirement</option>
									</select>
								</div>
								<div class="flex-col" x-show="contentType == {{\App\Enums\Communication\MessageType::Requirement}}" >
									<label class="block text-sm font-medium text-gray-700">Search purchase requirements</label>
									<select id="purchaseReqSearch" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md"></select>
								</div>
								<div class="flex-col" x-show="contentType == {{\App\Enums\Communication\MessageType::Person}}" >
									<label class="block text-sm font-medium text-gray-700">Search people</label>
									<select id="personSearch" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md"></select>
								</div>
								<div class="flex-col" x-show="contentType == {{\App\Enums\Communication\MessageType::Order}}" >
									<label class="block text-sm font-medium text-gray-700">Search orders</label>
									<select id="orderSearch" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md"></select>
								</div>
								<div class="flex justify-end" x-show="contentId !== null">
									<button class="bg-blue-600 hover:bg-blue-600 text-white px-4 py-1 rounded inline-flex gap-2 justify-center items-center" @click="sendContentChat()">
										Send
									</button>
								</div>
								<span class="text-red-500 ml-3" x-text="errorMessage"></span>
							</div>
							<div class="w-full flex flex-col gap-3 py-2" x-show="modalIntent === 'new-chat'">
								<div class="flex-col">
									<label class="block text-sm font-medium text-gray-700">Select agent</label>
									<select id="agentSearch" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md"></select>
								</div>
								<div class="flex justify-end" x-show="selectedAgent !== null">
									<button class="bg-blue-600 hover:bg-blue-600 text-white px-4 py-1 rounded inline-flex gap-2 justify-center items-center" @click="createChat()">
										Start chatting
									</button>
								</div>
								<span class="text-red-500 ml-3" x-text="errorMessage"></span>
							</div>
						</div>

					</div>
				</div>

				<div class="flex flex-col">
					<div class="">
						<div class="grid grid-cols-8">
							<div class="col-span-2 py-2 px-2 h-full flex flex-col w-full">
								<div class="flex-none h-24 flex">
									<div class="flex flex-col justify-center w-full">
										<div class="flex justify-between">
											<span class="font-bold text-xl">Chats</span>
											<button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded inline-flex gap-2 justify-center items-center w-20" @click="openModal('new-chat')">
												<svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
												</svg>
												New
											</button>
										</div>
										<input x-model="searchQuery" @input="onSearch()" autocomplete="off" placeholder="Search.." class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md" name="name" type="text">
									</div>
								</div>
								<div style="height: 65vh;" class="px-2 flex-grow flex flex-col gap-2 items-center justify-start overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
									<template x-for="conversation in filteredConversations">
										<div class="flex bg-gray-50 hover:bg-gray-100 rounded shadow cursor-pointer h-16 w-full py-4 px-2 items-center justify-between" @click="syncConversation(conversation.id)">
											<div class="flex flex-col justify-center mr-2" >
												<span class="font-bold text-md line-clamp-1" x-text="getConversationTitle(conversation)"></span>
												<div class="flex items-center gap-2" >
													<span class="text-xs text-gray-400" x-text="getLastTimestamp(conversation)"></span>
												</div>
											</div>
											<div class="flex gap-2 items-center">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" x-show="!checkIfRead(conversation)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
												</svg>
												<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
												</svg>
											</div>
										</div>
									</template>
								</div>
							</div>
							<div class="col-span-6">
								<template x-if="currentConversation !== null">
									<div class="flex-1 p:2 sm:p-6 justify-between flex flex-col">
									<div class="flex sm:items-center justify-between py-3 px-3 bg-black-500 rounded">
										<div class="flex items-center space-x-4">
											<div class="flex gap-2 justify-center items-center">
												<span class="text-white text-2xl" x-text="conversationTitle"></span>
												<span class="text-xs text-white font-bold text-center h-6 bg-blue-600 px-4 py-1 rounded-xl mt-1" x-text="conversationRole"></span>
											</div>
										</div>
										<div class="flex items-center space-x-2">
{{--											<button type="button" class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">--}}
{{--												<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">--}}
{{--													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>--}}
{{--												</svg>--}}
{{--											</button>--}}
										</div>
									</div>
									<div style="height: 60vh;" class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
										<template x-for="message in currentConversation.messages" x-if="currentConversation !== null">
											<div>
												<div class="chat-message" x-show="message.type === {{\App\Enums\Communication\MessageType::Text}}">
													<div :class="messageRole(message.user.id) === 'local' ? 'flex flex-col justify-end' : 'flex flex-col justify-end items-end'">
														<div :class="`flex flex-col space-y-2 text-xs max-w-xs mx-2 ${messageRole(message.user.id) === 'local' ? 'items-start' : 'items-end'}`">
															<div>
																<span :class="`px-4 py-2 rounded-lg inline-block text-white ${messageRole(message.user.id) === 'local' ? ' rounded-bl-none bg-blue-600' : 'rounded-br-none bg-gray-700'}`" x-text="message.content.text"></span>
															</div>
														</div>
														<span class="text-xs text-gray-500 mx-3" x-text="moment(parseInt(message.timestamp)).format('DD-MM-YYYY HH:mm')"></span>
													</div>
												</div>
												<div class="chat-message" x-show="message.type === {{\App\Enums\Communication\MessageType::Requirement}}">
													<div :class="messageRole(message.user.id) === 'local' ? 'flex flex-col justify-end' : 'flex flex-col justify-end items-end'">
														<div :class="`flex flex-col px-4 py-2 rounded-lg w-2/5 ${messageRole(message.user.id) === 'local' ? 'bg-blue-600 rounded-bl-none items-start' : ' bg-gray-700 rounded-br-none items-end'}`">
															<span class="text-white text-lg line-clamp-1" x-text="message.content.product"></span>
															<span class="text-white text-xs" x-text="message.content.person_email"></span>
															<span :class="`my-2 text-black bg-orange-500 font-semibold rounded-lg text-xs px-2 py-1 flex items-end ${messageRole(message.user.id) === 'local' ? '' : 'justify-end'}`">Purchase requirement</span>
															<a x-show="message.content.link !== undefined" :href="message.content.link" target="_blank" :class="`my-2 py-2 text-white rounded w-1/2 text-center text-xs font-bold px-4 py-2 ${messageRole(message.user.id) === 'local' ? 'bg-gray-700 hover:bg-gray-500' : 'bg-blue-600 hover:bg-blue-500'}`"> View </a>
															<span x-show="message.content.length === 0" :class="`my-2 py-2 text-white rounded w-1/2 text-center text-xs font-bold px-4 py-2 ${messageRole(message.user.id) === 'local' ? 'bg-gray-700 hover:bg-gray-500' : 'bg-blue-600 hover:bg-blue-500'}`">Resource not found</span>
														</div>
														<span class="text-xs text-gray-500 mx-3" x-text="moment(parseInt(message.timestamp)).format('DD-MM-YYYY HH:mm')"></span>
													</div>
												</div>
												<div class="chat-message" x-show="message.type === {{\App\Enums\Communication\MessageType::Person}}">
													<div :class="messageRole(message.user.id) === 'local' ? 'flex flex-col justify-end' : 'flex flex-col justify-end items-end'">
														<div :class="`flex flex-col px-4 py-2 rounded-lg w-2/5 ${messageRole(message.user.id) === 'local' ? 'bg-blue-600 rounded-bl-none items-start' : ' bg-gray-700 rounded-br-none items-end'}`">
															<span class="capitalize text-white text-lg line-clamp-1" x-text="message.content.name"></span>
															<span class="text-white text-xs" x-text="message.content.email"></span>
															<span :class="`my-2 text-black bg-orange-500 font-semibold rounded-lg text-xs px-2 py-1 flex items-end ${messageRole(message.user.id) === 'local' ? '' : 'justify-end'}`">Person</span>
															<a x-show="message.content.link !== undefined" :href="message.content.link" target="_blank" :class="`my-2 py-2 text-white rounded w-1/2 text-center text-xs font-bold px-4 py-2 ${messageRole(message.user.id) === 'local' ? 'bg-gray-700 hover:bg-gray-500' : 'bg-blue-600 hover:bg-blue-500'}`"> View </a>
															<span x-show="message.content.length === 0" :class="`my-2 py-2 text-white rounded w-1/2 text-center text-xs font-bold px-4 py-2 ${messageRole(message.user.id) === 'local' ? 'bg-gray-700 hover:bg-gray-500' : 'bg-blue-600 hover:bg-blue-500'}`">Resource not found</span>
														</div>
														<span class="text-xs text-gray-500 mx-3" x-text="moment(parseInt(message.timestamp)).format('DD-MM-YYYY HH:mm')"></span>
													</div>
												</div>
												<div class="chat-message" x-show="message.type === {{\App\Enums\Communication\MessageType::Order}}">
													<div :class="messageRole(message.user.id) === 'local' ? 'flex flex-col justify-end' : 'flex flex-col justify-end items-end'">
														<div :class="`flex flex-col px-4 py-2 rounded-lg w-2/5 ${messageRole(message.user.id) === 'local' ? 'bg-blue-600 rounded-bl-none items-start' : ' bg-gray-700 rounded-br-none items-end'}`">
															<span class="capitalize text-white text-lg line-clamp-1" x-text="`${message.content.id} ${message.content.product}`"></span>
															<span class="text-white text-xs" x-text="message.content.type"></span>
															<span :class="`my-2 text-black bg-orange-500 font-semibold rounded-lg text-xs px-2 py-1 flex items-end ${messageRole(message.user.id) === 'local' ? '' : 'justify-end'}`">Order</span>
															<a  x-show="message.content.link !== undefined" :href="message.content.link" target="_blank" :class="`my-2 py-2 text-white rounded w-1/2 text-center text-xs font-bold px-4 py-2 ${messageRole(message.user.id) === 'local' ? 'bg-gray-700 hover:bg-gray-500' : 'bg-blue-600 hover:bg-blue-500'}`"> View </a>
															<span x-show="message.content.length === 0" :class="`my-2 py-2 text-white rounded w-1/2 text-center text-xs font-bold px-4 py-2 ${messageRole(message.user.id) === 'local' ? 'bg-gray-700 hover:bg-gray-500' : 'bg-blue-600 hover:bg-blue-500'}`">Resource not found</span>
														</div>
														<span class="text-xs text-gray-500 mx-3" x-text="moment(parseInt(message.timestamp)).format('DD-MM-YYYY HH:mm')"></span>
													</div>
												</div>
											</div>
										</template>
									</div>
									<div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
										<div class="relative flex">
											<input @keyup.enter="sendTextChat()" type="text" x-model="textContent" placeholder="Write Something" class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-6 bg-gray-200 rounded-full py-3">
											<div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
												<button type="button" @click="openModal('message')" class="inline-flex items-center justify-center rounded-full h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
													<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
													</svg>
												</button>
												<button id="sendMessageBtn" @click="sendTextChat()" type="button" class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 transform rotate-90">
														<path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
													</svg>
												</button>
											</div>
										</div>
										<span class="text-red-500 ml-3" x-text="errorMessage"></span>
									</div>
								</div>
								</template>
								<template x-if="currentConversation === null">
									<div class="w-full h-full flex justify-center items-center">
										<span class="text-lg font-bold">Select a conversation</span>
									</div>
								</template>
								<style>
									.scrollbar-w-2::-webkit-scrollbar {
										width: 0.25rem;
										height: 0.25rem;
									}

									.scrollbar-track-blue-lighter::-webkit-scrollbar-track {
										--bg-opacity: 1;
										background-color: #f7fafc;
										background-color: rgba(247, 250, 252, var(--bg-opacity));
									}

									.scrollbar-thumb-blue::-webkit-scrollbar-thumb {
										--bg-opacity: 1;
										background-color: #edf2f7;
										background-color: rgba(237, 242, 247, var(--bg-opacity));
									}

									.scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
										border-radius: 0.25rem;
									}
								</style>

								<script>
									const el = document.getElementById('messages')
									el.scrollTop = el.scrollHeight
								</script>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>

		function chatHandler()
		{
			return {
				modalVisible: false,
				modalIntent: false,
				currentConversation: null,
				conversationTitle: null,
				conversationRole: null,
				externalUsers: [],
				currentUser: {{auth('agent')->user()->id}},
				messages: [],
				conversationLoading: false,
				conversations: [],
				conversationCheckInterval: null,
				filteredConversations: [],
				textContent: '',
				errorMessage: '',
				contentType: null,
				contentId: null,
				selectedRequirement: null,
				selectedOrder: null,
				selectedMeeting: null,
				selectedPerson: null,
				selectedAgent: null,
				searchQuery: '',
				init() {
					this.getConversations();
					setInterval(() => {
						this.getConversations();
					}, 5000);
				},
				openModal(intent) {
					this.modalVisible = true;
					this.modalIntent = intent;
					this.errorMessage = '';
					if (intent === 'message') {
						$('#purchaseReqSearch').select2({
							placeholder: "Pick a purchase requirement",
							ajax: {
								url: "/api/v1/purchase_requirements",
								dataType: 'json',
								processResults: function (data) {
									return {
										results: $.map(data, function (item) {
											return {
												text: item.name + item.person,
												id: item.id
											}
										})
									};
								},
								cache: false,
								allowClear: true
							}
						});

						$('#purchaseReqSearch').on('select2:select', (event) => {
							this.contentId = event.target.value;
						});

						$('#personSearch').select2({
							placeholder: "Select a person",
							ajax: {
								url: "/api/v1/people/search",
								dataType: 'json',
								processResults: function (data) {
									return {
										results: $.map(data, function (item) {
											return {
												text: `${item.name} | ${item.business.name}`,
												id: item.id,
											}
										})
									};
								},
								cache: false,
								allowClear: true
							}
						});

						$('#personSearch').on('select2:select', (event) => {
							this.contentId = event.target.value;
						});

						$('#orderSearch').select2({
							placeholder: "Select an order",
							ajax: {
								url: "/api/v1/orders/search",
								dataType: 'json',
								processResults: function (data) {
									return {
										results: $.map(data, function (item) {
											return {
												text: `${item.id} | ${item.product}`,
												id: item.id,
											}
										})
									};
								},
								cache: false,
								allowClear: true
							}
						});

						$('#orderSearch').on('select2:select', (event) => {
							this.contentId = event.target.value;
						});
					} else if (intent === 'new-chat') {
						$('#agentSearch').select2({
							placeholder: "Select an agent",
							ajax: {
								url: "/api/v1/users/search",
								dataType: 'json',
								processResults: function (data) {
									return {
										results: $.map(data, function (item) {
											return {
												text: `${item.name} ${item.email}`,
												id: item.id,
											}
										})
									};
								},
								cache: false,
								allowClear: true
							}
						});

						$('#agentSearch').on('select2:select', (event) => {
							this.selectedAgent = event.target.value;
						});
					}
				},
				createChat() {
					const conversation = this.conversations.find((item) => item.id == this.selectedAgent);
					if (conversation) {
						this.syncConversation(conversation.id);
						this.closeModal();
					} else {
						let result = $.ajax({
							url: `/api/v1/communications/conversations`,
							type: 'POST',
							dataType: 'json',
							async: false,
							data: {
								receiver_id: this.selectedAgent,
							},
							global: false,
							success: function (response) {
								return response;
							},
							error: function (response) {

							},
						});

						if (result.status === 200) {
							this.getConversations();
							this.syncConversation(result.responseJSON.data.id);
							this.closeModal();
						}
					}
				},
				checkIfRead(conversation) {
					const user = conversation.users.find((item) => item.id === this.currentUser);
					return user.pivot.is_read === 1;
				},
				closeModal() {
					this.errorMessage = '';
					this.modalVisible = false;
					this.modalIntent = null;
				},
				sendContentChat() {
					this.errorMessage = '';
					if (!_.isEmpty(this.contentId) && !_.isEmpty(this.contentType)) {
						this.sendMessage(this.contentId, this.contentType, () => {
							this.closeModal();
						})
					} else {
						this.errorMessage = 'Please enter some text';
					}
				},
				sendTextChat() {
					this.errorMessage = '';
					if (!_.isEmpty(this.textContent)) {
						this.sendMessage(this.textContent, {{\App\Enums\Communication\MessageType::Text}}, () => {
							this.textContent = '';
						});
					} else {
						this.errorMessage = 'Please enter some text';
					}
				},
				onSearch() {
					if (_.isEmpty(this.searchQuery)) {
						this.filteredConversations = this.conversations;
					} else {
						this.filteredConversations = this.conversations.filter((item) => {
							const user_string = this.getConversationTitle(item);
							const lowered_string = user_string.toLowerCase();
							return lowered_string.search(this.searchQuery.toLowerCase()) >= 0;
						})
					}
				},
				sendMessage(content, type, successHandler) {
					let result = $.ajax({
						url: `/api/v1/communications/conversations/${this.currentConversation.id}/message`,
						type: 'POST',
						dataType: 'json',
						async: false,
						data: {
							content: content,
							type: type,
							timestamp: moment.utc().valueOf()
						},
						global: false,
						success: function (response) {
							return response;
						},
						error: function (response) {

						},
					});

					if (result.status === 200) {
						this.syncConversation(this.currentConversation.id);
						successHandler();
					}
				},
				getLastTimestamp(conversation){
					const last_message = conversation.messages[conversation.messages.length - 1];
					if(last_message)
					{
						return moment(parseInt(last_message.timestamp)).format('hh:mm A');
					}

					return '';
				},
				syncConversation(conversationId){
					this.conversationLoading = true;
					let result = $.ajax({
						url: `/api/v1/communications/conversations/${conversationId}`,
						type: 'GET',
						dataType: 'json',
						async: false,
						global: false,
						success: function (response) {
							this.conversationLoading = false;
							return response;
						},
						error: function (response) {
							this.conversationLoading = false;
						},
					});

					if (result.status === 200) {
						this.setConversation(result.responseJSON.data);

						if(this.conversationCheckInterval)
						{
							clearInterval(this.conversationCheckInterval);
							this.conversationCheckInterval= null;
						}

						if(!this.conversationCheckInterval)
						{
							this.conversationCheckInterval = setInterval(() => {
								this.syncConversation(conversationId);
							},5000);
						}
					}
				},
				getConversations(){
					let result = $.ajax({
						url: `/api/v1/communications/conversations`,
						type: 'GET',
						dataType: 'json',
						async: false,
						global: false,
						success: function (response) {
							return response;
						},
						error: function (response) {
							this.conversations = [];
						},
					});

					if (result.status === 200) {
						this.conversations = result.responseJSON.data;
						this.filteredConversations = this.conversations;
					}
				},
				getExternalUsers(conversation){
					return conversation.users.reduce((carry, user) => {
						if(user.id !== this.currentUser)
						{
							carry.push(user);
						}

						return carry;
					},[]);
				},
				getConversationTitle(conversation){
					const users = this.getExternalUsers(conversation);
					return users.map((user) => user.name).join(', ');
				},
				setConversation(conversation){
					this.currentConversation = conversation;
					this.externalUsers = this.getExternalUsers(conversation);

					this.conversationTitle = this.getConversationTitle(conversation);
					this.conversationRole = this.getRole(this.externalUsers[0]);
				},
				messageRole(id)
				{
					if(id === this.currentUser)
					{
						return 'local';
					}

					return 'remote';
				},
				getRole(role){
					switch(role)
					{
						case 1:
							return 'Admin';
						case 2:
							return 'Agent';
						case 3:
							return 'Translator';
						case 4:
							return 'Support';
						case 5:
							return 'Group conversation';
						default:
							return 'Agent';
					}
				},
			}
		}

	</script>

@endsection
