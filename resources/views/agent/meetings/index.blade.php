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
		<div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
			<div class="flow-root mb-3">
				<div class="flex justify-between mb-3">
					<h1 class="text-xl font-bold text-gray-500">
						{{ __('Meetings') }}
					</h1>
					@if(!request()->has('intent') && auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent)
					<a href="{{route('agent.meetings.index', ['intent' => 'claims'])}}" class="mx-1 bg-green-200 hover:bg-green-800 flex items-center text-green-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
						Open for claim
					</a>
					@endif
					@if(request()->has('intent'))
						<a href="{{route('agent.meetings.index')}}" class="mx-1 bg-green-200 hover:bg-green-800 flex items-center text-green-800 hover:text-gray-100 font-medium px-2 py-1 text-sm rounded float-right">
							@if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent || auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::translator)
								My meetings
							@else
								All meetings
							@endif
						</a>
					@endif
				</div>
			</div>
			<div class="flow-root my-3">
				<div class="flex-col">
					<div class="flex">
						<span>Search by</span>
					</div>
					{!! Form::open(['url' => route('agent.meetings.index'), 'class' => 'flex gap-3 items-center', 'method' => 'GET']) !!}

					<div class="flex-col">
						{!! Form::label('status', 'Status', ['class' => 'block text-sm font-medium text-gray-700']); !!}
						{!! Form::select('status', ['requires_participants' => 'Requires Participants', 'completed' => 'Completed', 'draft' => 'Draft', 'active' => 'Active'], request()->get('status'), ['placeholder' => 'Search by status', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
					</div>
                    <div class="flex-col">
                        {!! Form::label('participant_name', 'Participant', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                        {!! Form::text('participant_name', request()->get('participant_name'), ['placeholder' => 'Search by participant', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
                    </div>
					<div>
						<div class="flex-col">
							{!! Form::label('date', 'Date Filter', ['class' => 'block text-sm font-medium text-gray-700']); !!}
							{!! Form::date('date', request()->get('date'), ['class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm md:text-sm text-base border-gray-300 rounded-md']); !!}
						</div>
					</div>
					<div>
						{!! Form::submit('Search', ['class' => 'mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
						<a href="{{route('agent.meetings.index')}}" class="mt-5 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							Clear
						</a>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="bg-white overflow-hidden shadow-sm" x-data="meetingOperationsHandler()">
				<div class="modal-overlay" x-show="statusModalVisible" x-cloak>
					<div class="modal-container" x-show="statusModalVisible" @click.away="closeModal('status');" x-cloak>

						<div class="modal-head">
							<div class="article-attributes">
								<span>Update meeting status</span>
							</div>
							<div class="close" @click="closeModal('status');"><i class="fas fa-times">X</i></div>
						</div>

						<div class="modal-body">
							{!! Form::open(['url' => route('agent.meeting.update_status')]) !!}
							<div class="w-full flex flex-col gap-3 py-2">
								<div>
									<span x-text="'Updating status of meeting ' + current_meeting"></span>
								</div>
								<input type="hidden" x-model="current_meeting" name="meeting_id" />
								<div>
									{!! Form::label('status', 'New status', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
									{!! Form::select('status', [\App\Enums\Meeting\MeetingStatus::Cancelled => 'Cancel',\App\Enums\Meeting\MeetingStatus::Rejected => 'Reject', \App\Enums\Meeting\MeetingStatus::Reschedule => 'Reschedule'], old('status'), ['placeholder' => 'Select the new meeting status','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
								</div>
								<div class="flex justify-start">
									<button type="submit" class="bg-black-500 rounded py-1 px-3 text-white cursor-pointer w-20 h-10">Update</button>
								</div>

							</div>
							{!! Form::close() !!}
						</div>

					</div>
				</div>

				<div class="modal-overlay" x-show="linkModalVisible" x-cloak>
					<div class="modal-container" x-show="linkModalVisible" @click.away="closeModal('link');" x-cloak>

						<div class="modal-head">
							<div class="article-attributes flex flex-col">
								<span class="text-md font-bold"> Meeting links</span>
								<span class="text-xs">These links allow users to directly login to their account and enter the waiting room. Each link is only valid for 1 hour.</span>
							</div>
							<div class="close" @click="closeModal('link');"><i class="fas fa-times">X</i></div>
						</div>

						<div class="modal-body">
							<div class="w-full flex flex-col gap-4 py-2">
								<div class="w-full flex flex-col py-2">
									<div class="w-full flex gap-2">
										<span class="font-bold">Buyer link</span>
										<span class="font-bold text-blue-500 hover:text-blue-600 hover:underline cursor-pointer" @click="copyToClipboard(buyer_link)">Copy</span>
									</div>
									<span x-text="buyer_link" id="buyer_link_element" class="p-2 bg-gray-100 border-dashed border-gray-300 border-2 rounded"></span>
								</div>
								<div class="w-full flex flex-col py-2">
									<div class="w-full flex gap-2">
										<span class="font-bold">Supplier link</span>
										<span class="font-bold text-blue-500 hover:text-blue-600 hover:underline cursor-pointer" @click="copyToClipboard(supplier_link)">Copy</span>
									</div>
									<span x-text="supplier_link" class="p-2 bg-gray-100 border-dashed border-gray-300 border-2 rounded"></span>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="flex flex-col">
					<div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
						<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
							<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
								@if($meetings->count() > 0)
								<table class='mx-auto w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
									<thead class="bg-gray-50">
									<tr class="text-gray-600 text-left">
										<th class="font-semibold text-sm uppercase px-6 py-4">
											Order
										</th>
										<th class="font-semibold text-sm uppercase px-6 py-4">
											Time slot
										</th>
										@if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::translator)
										<th class="font-semibold text-sm uppercase px-6 py-4">
											Languages
										</th>
										@endif
										<th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
											Agents
										</th>
                                        <th class="font-semibold text-sm uppercase px-6 py-4">
                                            Participants
                                        </th>
										<th class="font-semibold text-sm uppercase px-6 py-4 text-center">
											Confirmation status
										</th>
										<th class="font-semibold text-sm uppercase px-6 py-4 text-center">
											Status
										</th>
										<th class="font-semibold text-sm uppercase px-6 py-4 text-center">
											Links
										</th>
										<th class="font-semibold text-sm uppercase px-6 py-4 text-center">
											Actions
										</th>
									</tr>
									</thead>
									<tbody class="divide-y divide-gray-200">
									@foreach($meetings as $meeting)
										<tr>
											<td class="px-6 py-4">
												<a href="{{route('agent.order.show', $meeting->orderItem->order->getRouteKey())}}" class="truncate w-20 px-2 hover:bg-blue-800 hover:text-white inline-flex items-center p-1 ml-1 text-xs text-blue-800 transition-colors duration-150 rounded focus:shadow-outline">
													{{$meeting->orderItem->order->getRouteKey()}}
												</a>

											</td>
											<td class="px-6 py-4">
												<p class="text-sm my-2">
													<span class="text-xs">{{$meeting->orderItem->agentTime()}}</span> <span class="ml-2 bg-gray-500 rounded-lg px-3 py-1 text-white text-xs">Agent time</span>
												</p>
												<p class="text-sm my-2">
													<span class="text-xs">{{$meeting->orderItem->supplierTime()}}</span> <span class="ml-2 bg-gray-500 rounded-lg px-3 py-1 text-white text-xs">Supplier time</span>
												</p>
												<p class="text-sm my-2">
													<span class="text-xs">{{$meeting->orderItem->buyerTime()}}</span> <span class="ml-2 bg-gray-500 rounded-lg px-3 py-1 text-white text-xs">Buyer time</span>
												</p>
											</td>
											@if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::translator)
											<td class="px-6 py-4">
												@if($languages = $translationService->getCombinationByCode($meeting->orderItem->required_translator))
													@if(count($languages) === 2)
													<b>{{$languages[0]->name}}</b> to <b>{{$languages[1]->name}}</b>
													@endif
												@endif
											</td>
											@endif
											<td class="px-6 py-3 whitespace-nowrap text-xs text-gray-500 flex flex-col gap-2">
												<div class="flex gap-2 items-center">
													@if($meeting->orderItem->purchase_requirement->person->agent)
														{{$meeting->orderItem->purchase_requirement->person->agent->name}}
													@else
														No agent assigned
													@endif
													<span class="bg-gray-500 px-3 py-1 rounded text-white">Buyer agent</span>
												</div>
												<div class="flex gap-2 items-center">
													@if($meeting->orderItem->order->person->agent)
														{{$meeting->orderItem->order->person->agent->name}}
													@else
														No agent assigned
													@endif
													<span class="bg-gray-500 px-3 py-1 rounded text-white">Supplier agent</span>
												</div>
											</td>
                                            <td>
												<div class="flex flex-col gap-2 items-center">
													<a target="_blank" href="{{route('agent.people.show', $meeting->participants[0]->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs transition-colors duration-150 text-blue-600 hover:text-blue-600 hover:underline rounded focus:shadow-outline">
														{{$meeting->participants[0]->name}}
													</a>
													<a target="_blank" href="{{route('agent.people.show', $meeting->participants[1]->getRouteKey())}}" class="inline-flex items-center px-2 py-1 ml-1 text-xs transition-colors duration-150 text-blue-600 hover:text-blue-600 hover:underline rounded focus:shadow-outline">
														{{$meeting->participants[1]->name}}
													</a>
												</div>
                                            </td>
											<td>
												<div class="flex flex-col gap-2 items-center">
													@if($meeting->orderItem->order->status !== \App\Enums\Order\OrderStatus::Cancelled)
														@if($meeting->is_confirmed)
															<span class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-green-600 hover:text-green-500 rounded focus:shadow-outline hover:bg-green-200">
																Meeting Confirmed
															</span>
														@else
															<span class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-orange-600">
																Pending confirmation
															</span>
															<form action="{{route('agent.meeting.confirm', $meeting->getRouteKey())}}" method="POST">
																@csrf
																<button type="submit" class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-600 hover:text-blue-500 rounded focus:shadow-outline hover:bg-blue-200">Confirm attendance</button>
															</form>
														@endif
													@else
														<span class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-red-600 hover:text-red-500 rounded focus:shadow-outline hover:bg-red-200">
															Meeting Cancelled
														</span>
													@endif
												</div>
											</td>
											<td class="px-6 py-4 text-center">
												@switch($meeting->status)
													@case(\App\Enums\Meeting\MeetingStatus::Requires_Participant)
													<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-yellow-400 hover:text-yellow-500 rounded focus:shadow-outline hover:bg-yellow-200">
														Requires participants
													</span>
													@break
													@case(\App\Enums\Meeting\MeetingStatus::Scheduled)
													<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-green-400 hover:text-green-500 rounded focus:shadow-outline hover:bg-green-200">
														Scheduled
													</span>
													@break
													@case(\App\Enums\Meeting\MeetingStatus::Reschedule)
													<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-red-600 hover:text-red-500 rounded focus:shadow-outline hover:bg-red-200">
														Reschedule
													</span>
													@break
													@case(\App\Enums\Meeting\MeetingStatus::Rejected)
													<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-red-600 hover:text-red-500 rounded focus:shadow-outline hover:bg-red-200">
														Rejected
													</span>
													@break
													@case(\App\Enums\Meeting\MeetingStatus::Cancelled)
													<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-red-600 hover:text-red-500 rounded focus:shadow-outline hover:bg-red-200">
														Cancelled
													</span>
													@break
													@case(\App\Enums\Meeting\MeetingStatus::Expired)
													<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-400 hover:text-blue-500 rounded focus:shadow-outline hover:bg-blue-200">
														Expired
													</span>
													@break
													@case(\App\Enums\Meeting\MeetingStatus::Draft)
													<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-400 hover:text-blue-500 rounded focus:shadow-outline hover:bg-blue-200">
														Draft
													</span>
													@break
												@endswitch
												@if($meeting->status !== \App\Enums\Meeting\MeetingStatus::Expired && $meeting->status !== \App\Enums\Meeting\MeetingStatus::Reschedule && $meeting->status !== \App\Enums\Meeting\MeetingStatus::Rejected && $meeting->status !== \App\Enums\Meeting\MeetingStatus::Cancelled)
													<span @click="openModal('{{$meeting->getRouteKey()}}', 'status')" class="mx-2 bg-gray-500 rounded text-white px-2 py-1 hover:bg-gray-600 cursor-pointer">Update status</span>
												@endif
											</td>
											<td>
												<button @click="openModal('{{$meeting->getRouteKey()}}', 'link')" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-500 rounded focus:shadow-outline hover:bg-blue-800" >View links</button>
											</td>
											<td class="px-6 py-4 flex gap-2 justify-center items center">
												@if($meeting->status != \App\Enums\Meeting\MeetingStatus::Cancelled && $meeting->status != \App\Enums\Meeting\MeetingStatus::Reschedule && $meeting->status != \App\Enums\Meeting\MeetingStatus::Rejected)
													@if(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::agent)
														@if(!$meeting->agent_id)
															<form action="{{route('agent.meeting.claim')}}"  method="POST">
																@csrf
																<input type="hidden" name="meeting" value="{{$meeting->id}}">
																<button type="submit" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-green-800 transition-colors duration-150 bg-green-200 hover:text-green-200 rounded focus:shadow-outline hover:bg-green-800">
																	Claim
																</button>
															</form>
														@endif
														@if($meeting->agent_id)
																@if($meeting->agent_id === auth('agent')->user()->id)
																	<a href="{{route('agent.meeting.waiting_room.show', $meeting->getRouteKey())}}" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-500 rounded focus:shadow-outline hover:bg-blue-800">Join waiting room</a>
																@endif
														@endif
													@elseif(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::translator)
														@if(!$meeting->translator_id)
															<form action="{{route('agent.meeting.claim')}}"  method="POST">
																@csrf
																<input type="hidden" name="meeting" value="{{$meeting->id}}">
																<button type="submit" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-green-800 transition-colors duration-150 bg-green-200 hover:text-green-200 rounded focus:shadow-outline hover:bg-green-800">
																	Claim
																</button>
															</form>
														@endif
														@if($meeting->translator_id)
															@if($meeting->translator_id === auth('agent')->user()->id)
																<a href="{{route('agent.meeting.waiting_room.show', $meeting->getRouteKey())}}" class="px-2 inline-flex font-medium items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-blue-500 rounded focus:shadow-outline hover:bg-blue-800">Join waiting room</a>
															@endif
														@endif
													@elseif(auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::admin || auth('agent')->user()->role->value === \App\Enums\Agent\AgentRoles::support)
														@if(!$meeting->translator_id && $meeting->orderItem->required_translator)
															<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-orange-600 rounded focus:shadow-outline hover:bg-orange-700">
																Requires translator
															</span>
														@endif
														@if(!$meeting->agent_id)
															<span  class="px-2 inline-flex items-center p-1 ml-1 text-xs text-white transition-colors duration-150 bg-orange-600 rounded focus:shadow-outline hover:bg-orange-700">
																Requires agent
															</span>
														@endif
													@endif
												@endif
											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
								<div class="mt-2">
									{{$meetings->links()}}
								</div>
								@else
									<div class="h-16 p-10 flex justify-center items-center">
										<span class="text-md italic text-gray-500">No meetings to show</span>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>

		function meetingOperationsHandler()
		{
			return {
				current_meeting: null,
				statusModalVisible: false,
				linkModalVisible: false,
				order_status: null,
				buyer_link: null,
				supplier_link: null,
				openModal(meetingId, type){
					switch(type)
					{
						case 'status':
							this.current_meeting = meetingId;
							this.statusModalVisible = true;
							break;
						case 'link':
							if(!this.buyer_link || !this.supplier_link)
							{
								this.getLinks(meetingId);
							}

							this.linkModalVisible = true;
							break;
					}

				},
				closeModal(type){

					switch(type)
					{
						case 'status':
							this.current_meeting = null;
							this.statusModalVisible = false;
							break;
						case 'link':
							this.linkModalVisible = false;
							break;
					}
				},
				copyToClipboard(text) {
					if(navigator.clipboard)
					{
						navigator.clipboard.writeText(text).then(function() {
							let event = new CustomEvent('notice', {
								detail: {
									'type': 'success',
									'text': 'Copied to clipboard'
								}
							});

							window.dispatchEvent(event);
						}, function(err) {
							let event = new CustomEvent('notice', {
								detail: {
									'type': 'error',
									'text': 'Clipboard unavailable, please copy manually'
								}
							});
							window.dispatchEvent(event);
						});
					}
					else
					{
						let event = new CustomEvent('notice', {
							detail: {
								'type': 'error',
								'text': 'Clipboard unavailable, please copy manually'
							}
						});
						window.dispatchEvent(event);
					}

				},
				getLinks(meetingId)
				{
					let result = $.ajax({
						url: `/api/v1/meetings/${meetingId}/links`,
						type: 'POST',
						dataType: 'json',
						async: false,
						global: false,
						success: function (response) {
							return response;
						}
					});

					if (result.status === 200) {
						this.buyer_link = result.responseJSON.buyer;
						this.supplier_link = result.responseJSON.supplier;
					}
				}
			}
		}
	</script>

@endsection
