@extends('layouts.admin')
@section('content')
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
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
            <div class="flow-root mb-3">
                <div class="mb-3">
                    <h1 class="text-2xl font-bold text-gray-500">
                        {{ __('Create an order') }}
                    </h1>
                </div>
            </div>
            <div class="bg-white">
                <div class="flex flex-col">
                    {!! Form::open(['url' => route('agent.order.store')]) !!}
                    <div class="shadow overflow-hidden sm:rounded-md" x-data="orderHandler()" x-init="init()" @pr.window="current_pr = $event.detail.message" @person.window="getPersonById($event.detail.message)">
                        <div class="modal-overlay" x-show="modalVisible" x-cloak>
                            <div class="modal-container" x-show="modalVisible" @click.away="closeModal();" x-cloak>

                                <div class="modal-head">
                                    <div class="article-attributes">
                                        <span>Person's preferred meeting times</span>
                                    </div>
                                    <div class="close" @click="closeModal();"><i class="fas fa-times">X</i></div>
                                </div>

                                <div class="modal-body">
                                    <template x-if="current_person !== undefined">
                                        <div class="flex gap-3 mt-2 items-center">
                                            <template x-for="preferredTime in current_person.preferred_times">
                                                <span x-text="preferredTime.time"  class="rounded-lg px-3 py-1 text-white text-xs bg-black-500"></span>
                                            </template>
                                            <span x-show="current_person.preferred_times.length === 0">No preferred times have been set this person.</span>
                                        </div>
                                    </template>
                                </div>

                            </div>
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <h1 class="text-2xl m-0  text-gray-500">
                                {{ __('Order Details') }}
                            </h1>

                            <hr class="my-1 mb-5">

                            <div class="grid grid-cols-6 gap-5">
                                <div class="col-span-6 sm:col-span-3">
                                    @component('components.peopleSearch')
                                        @slot('nativeSelection')
                                            true
                                        @endslot
                                        @slot('personID')
                                            null
                                        @endslot
                                        @slot('labelClass')
                                            block text-sm font-medium text-gray-700 required
                                        @endslot
                                        @slot('selectClass')
                                            mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md
                                            shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                                            md:text-sm text-base
                                        @endslot
                                    @endcomponent
                                    <template x-if="current_person != undefined">
                                        <div class="flex gap-1 flex-col">
                                            <div class="flex gap-3 mt-2 items-center">
                                                <span x-text="current_person.country"  class="rounded-lg px-3 py-1 text-white text-xs bg-green-500"></span>
                                                <span x-text="showSupplierTime()"  class="rounded-lg px-3 py-1 text-white text-xs bg-blue-500"></span>
                                                <span x-text="current_person.timezone" class="rounded-lg px-3 py-1 text-white text-xs bg-gray-500"></span>
                                                <a class="text-indigo-500 font-bold cursor-pointer" target="_blank"
                                                   x-show="current_person !== undefined"
                                                   x-bind:href="'{{url('')}}/agent/people/'+current_person.id">View person</a>
                                                <span class="text-indigo-500 font-bold cursor-pointer"
                                                   x-show="current_person !== undefined" @click="openModal()">View preferred times</span>
                                            </div>
                                        </div>
                                    </template>
                                    @error('person_id')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    @component('components.purchaseRequirementSearch')
                                        @slot('nativeSelection')
                                            true
                                        @endslot
                                        @slot('prID')
                                            null
                                        @endslot
                                        @slot('labelClass')
                                            block text-sm font-medium text-gray-700 required
                                        @endslot
                                        @slot('selectClass')
                                            mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md
                                            shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500
                                            md:text-sm text-base
                                        @endslot
                                    @endcomponent
                                    <a class="text-indigo-500 mt-3 font-bold cursor-pointer" target="_blank"
                                       x-show="current_pr !== undefined"
                                       x-bind:href="'{{url('')}}/agent/purchase_requirements/'+current_pr">View purchase
                                        requirement</a>
                                    @error('purchase_requirement_id')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('order_type', 'Order type', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}
                                    {!! Form::select('order_type', $order_types, old('order_type'), ['x-model'=> 'order_type','placeholder' => 'Select the order type...','class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                    @error('order_type')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('timeslot', 'Timeslot', ['class' => 'block text-sm font-medium text-gray-700 required']); !!}

                                    <div class="flex justify-start items-start mt-3"  x-show="current_pr !== undefined">
                                        <input type="hidden" x-model="selected_timeslot" name="timeslot"/>
                                        <div x-show="view === 'calendar'" id="myCalendar"
                                             class="vanilla-calendar m-0"></div>
                                        <div x-show="view === 'timeslot'" class="bg-white rounded p-4">
                                            <template x-if="time_slots.length > 0">
                                                <div>
                                                    <div class='flex flex-col gap-3 items-center p-3 px-2 py-1 w-full'>
                                                                        <span class="text-center w-full block"
                                                                              x-text="'Selected date: ' + moment(selected_date).format('Do of MMMM YYYY')"></span>
                                                                        <span class='bg-green-500 rounded-lg px-3 py-1 text-white' x-text="'Timezone is '+ timeslotTimezone"></span>
                                                        <button type="button" @click="change()"
                                                                class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                                            Change
                                                        </button>
                                                    </div>
                                                    <div class="grid grid-cols-4 gap-3 w-full my-3 px-2 overflow-y-auto max-h-56">
                                                        <template
                                                                x-for="time_slot in time_slots"
                                                                :key="time_slot">
                                                            <div class="px-2 py-1 h-12 w-full bg-red-500 rounded flex justify-center items-center cursor-pointer transform transition duration-200 hover:scale-105 hover:bg-red-600">
                                                                            <span @click="selectTimeslot(time_slot)"
                                                                                  x-text="convertTimezone(time_slot, timeslotTimezone, 'hh:mm A')"
                                                                                  class='text-white font-semibold text-sm'/>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                            <template x-if="time_slots.length === 0">
                                                <div class='flex flex-col gap-2 items-center p-3 px-2 py-1 w-full'>
                                                                    <span x-text="'No timeslots available on this date'"
                                                                          class='font-semibold text-sm'></span>
                                                    <button type="button" @click="change()"
                                                            class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                                        Change
                                                    </button>
                                                </div>
                                            </template>

                                        </div>
                                        <div x-show="view === 'change'" class="bg-white rounded p-4">

                                            <div class='flex flex-col gap-2 items-center'>
                                                <div class='flex flex-col items-center'>

                                                    <span class='text-sm' x-text="'Selected date: ' + convertTimezone(selected_timeslot, timeslotTimezone , 'Do of MMMM YYYY')"></span>
                                                    <span class='text-sm' x-text="'Selected time: ' + convertTimezone(selected_timeslot, timeslotTimezone , 'hh mm A')"></span>
                                                    <span class='bg-green-500 rounded-lg px-3 py-1 text-white' x-text="'Timezone is '+ timeslotTimezone"></span>
                                                </div>
                                                <div class='flex gap-2 items-center p-3'>
                                                    <button type="button" @click="change()"
                                                            class="bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                                        Change
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <span class='text-sm' x-show="current_pr === undefined">Please select a purchase requirement</span>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('requires_translator', 'Translator required?', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    {!! Form::checkbox('requires_translator', 'yes', false, ['placeholder' => 'Select the order type...']) !!}
                                    @error('requires_translator')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    {!! Form::label('package_id', 'Package for this order', ['class' => 'block text-sm font-medium text-gray-700']); !!}
                                    <template x-if="packages && packages.length > 0">
                                        <select class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base" name="package_id">
                                            <template x-for="package in packages" :key="package.id" x-if="packages && packages.length > 0">
                                                <option :value="package.id" x-text="package.title + ' | ' + (package.allowed_meeting_count - package.quota_used) + '/' + package.allowed_meeting_count + ' meetings remaining'"></option>
                                            </template>
                                        </select>
                                    </template>

                                    <template x-if="!current_person">
                                        <span class='text-sm'>Please select a person to get their active packages</span>
                                    </template>

                                    <template x-if="current_person && (!packages || packages.length === 0)">
                                        <span class='text-sm'>Selected person has no active packages</span>
                                    </template>
                                    @error('package_id')
                                    <div class="text-xs text-red-700 text-left">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 bg-gray-200 text-left sm:px-6">
                            <a href="{{route('agent.order.index')}}"
                               class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Back
                            </a>

                            {!! Form::submit('Save', ['class' => 'inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']); !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        function orderHandler() {
            return {
                modalVisible: false,
                current_pr: undefined,
                current_person: undefined,
                packages: [],
                selected_date: undefined,
                time_slots: [],
                selected_timeslot: undefined,
                view: "calendar",
                timeslotTimezone: undefined,
                init() {
                    const date = moment().format('DD-MM-YYYY');
                    
                    this.view = 'calendar';

                    let myCalendar = new VanillaCalendar({
                        selector: "#myCalendar",
                        pastDates: false,
                        datesFilter: true,
                        availableDates: this.getAvailableDays(date),

                        onSelect: (data) => {
                            let selectedDate = new Date(data.date).toISOString().substring(0, 10);
                            this.getTimeSlotsByDate(selectedDate);
                        },
                        onMonthChange: (data) => {
                            const date = moment(data).format('DD-MM-YYYY');
                            myCalendar.set({
                                availableDates: this.getAvailableDays(date),
                            })
                        }
                    });

                    var purchase_req_select = $('#pr_select');
                    var person_select = $('#person_select');

                    //FIXME
                    purchase_req_select.on('change', (e) => {

                        let event = new CustomEvent('pr', {
                            detail:
                                {
                                    message: e.target.value
                                }
                        });
                        window.dispatchEvent(event);

                        const date = moment().format('DD-MM-YYYY');
                        myCalendar.set({
                            availableDates: this.getAvailableDays(date),
                        });

                        this.view = "calendar";
                        this.selected_timeslot = undefined;
                    });

                    person_select.on('change', (e) => {

                        let event = new CustomEvent('person', {
                            detail:
                                {
                                    message: e.target.value
                                }
                        });
                        window.dispatchEvent(event);
                    });
                },
                openModal()
                {
                    this.modalVisible = true;
                },
                closeModal()
                {
                    this.modalVisible = false;
                },
                getPersonById(id) {
                    if(id)
                    {
                        const result = $.ajax({
                            url: `/api/v1/people/${id}`,
                            type: 'GET',
                            dataType: 'json',
                            async: false,
                            global: false,
                            success: function (response) {
                                return response.data;
                            }
                        });

                        if (result.status === 200) {
                            this.current_person = result.responseJSON.data;
                            this.getPackagesByPerson(this.current_person.id);
                        }
                    }
                },
                getPackagesByPerson(id){
                    const result = $.ajax({
                        url: `/api/v1/packages/searchByPerson`,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                          person_id: id
                        },
                        async: false,
                        global: false,
                        success: function (response) {
                            return response.data;
                        }
                    });

                    if (result.status === 200) {
                        this.packages = result.responseJSON;
                    }
                },
                getLocalTime(dateTime, format = 'YYYY-MM-DD HH:mm:ss') {
                    return moment.utc(dateTime).local().format(format);
                },
                convertTimezone(dateTime, timezone, format = 'YYYY-MM-DD HH:mm:ss') {
                    if(dateTime && timezone)
                    {
                        return moment.utc(dateTime).tz(timezone).format(format);
                    }
                    else {
                        return '';
                    }

                },
                showSupplierTime(){
                    if(this.current_person)
                    {
                        if(this.selected_timeslot)
                        {
                            return this.convertTimezone(this.selected_timeslot, this.current_person.timezone, 'Do of MMM YYYY HH:mm:ss');
                        }
                        else
                        {
                            return 'Select timeslot to display time in supplier timezone';
                        }
                    }
                    else
                    {
                        return 'Select person to display time in supplier timezone';
                    }
                },
                getAvailableDays(date){
                    if(this.current_pr) {
                        let available_dates = [];
                        let result = $.ajax({
                            url: "/api/v1/availability/check_month_availability",
                            type: 'POST',
                            dataType: 'json',
                            async: false,
                            global: false,
                            data: {
                                "purchase_requirement_id": this.current_pr,
                                "date": date
                            },
                            success: function (response) {
                                return response;
                            }
                        });

                        if (result.status === 200) {
                            available_dates = Object.keys(result.responseJSON).reduce((filtered, key) => {
                                if (result.responseJSON[key]) {
                                    filtered.push({date: key});
                                }

                                return filtered;
                            }, []);
                        }

                        return available_dates;
                    }

                    return [];
                },
                getTimeSlotsByDate(date) {
                    if(this.current_pr)
                    {
                        this.selected_date = date;
                        let result = $.ajax({
                            url: "/api/v1/availability/get_time_slots",
                            type: 'POST',
                            dataType: 'json',
                            async: false,
                            global: false,
                            data: {
                                "purchase_requirement_id": this.current_pr,
                                "date": this.selected_date,
                            },
                            success: function (response) {
                                return response;
                            }
                        });

                        if (result.status === 200) {
                            this.time_slots = result.responseJSON.time_slots;
                            this.timeslotTimezone = result.responseJSON.time_zone;
                            this.view = "timeslot";
                        }
                    }

                    return [];
                },
                selectTimeslot(time_slot) {
                    this.selected_timeslot = time_slot;
                    let concat_date = this.selected_date + " ";
                    this.view = "change";
                },
                confirm() {
                    this.view = "confirm";
                },
                change() {
                    this.view = "calendar";
                    this.selected_timeslot = undefined;
                },
            }
        }
    </script>
@endsection
