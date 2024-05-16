@extends('layouts.admin')

@section('content')

    <div class="pb-12 pt-7">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
            <div class="flow-root mb-3">
                <div class="mb-3">
                    <h1 class="text-2xl font-bold text-gray-500">
                        {{ __('Set availability') }}
                    </h1>
                </div>
            </div>
            <div class="bg-white">
                <div x-data="availabilityConfigurator()" x-init="init()" class="flex px-4 relative">

                        <div class="flex flex-col w-11/12 sm:w-5/6 lg:w-1/2 max-w-2xl mx-auto rounded-lg border border-gray-300 shadow-xl">
                            <div class="flex flex-col justify-between p-6 bg-white border-b border-gray-200 rounded-tl-lg rounded-tr-lg">
                                <p class="font-semibold text-gray-800">Submit availability</p>
                                <p class="text-sm text-gray-700">The more slots you select, the more chances of getting a meeting</p>
                            </div>
                            <div class="flex flex-col px-6 py-5 bg-gray-50">
                                <div class="h-full flex flex-col gap-2">
                                    <form>
                                        <div class="flex flex-col">
                                            <div class="flex flex-col gap-2">

                                                <div class="bg-orange-100 border-t-4 border-orange-500 rounded-b text-orange-900 px-4 py-3 shadow-md rounded" role="alert" x-show="warningVisible">
                                                    <div class="flex">
                                                        <div class="py-1"><svg class="fill-current h-6 w-6 text-orange-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                                                        <div>
                                                            <p class="text-sm my-1" x-text="warningText"></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex flex-col gap-1 py-2">
                                                    <p class="mt-3 font-semibold text-gray-700">Availability based on the day of the week</p>
                                                    <p class="text-xs text-gray-700 ">Set specific time slots for each day of the week or leave the day as available and the default availability below will be considered. If you
                                                        are unavailable on a certain day, mark it as unavailable.</p>
                                                    <div class="flex gap-2 mt-2">
                                                        <template x-for="day in days" :key="day.id">
                                                            <div>
                                                    <span @click="setCurrentDay(day.id)"
                                                          x-text="day.name.substring(0,3)"
                                                          :class="getDayClassNames(day.id)"
                                                          class="uppercase cursor-pointer hover:bg-blue-900 w-10 h-10 flex justify-center items-center rounded-full text-xs text-white"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                    <template x-if="selected_day !== undefined">
                                                        <div class="flex flex-col gap-2 mt-2">
                                                            <div class="form-control">
                                                                <label class="flex cursor-pointer label justify-start gap-3 items-center">
                                                                    <input type="checkbox" class="checkbox"
                                                                           x-on:change="toggleDayStatus($event.target.checked)"
                                                                           x-model="days[selected_day].active"/>
                                                                    <span x-text="'Set available times on ' + days[selected_day]?.name"></span>
                                                                </label>
                                                            </div>
                                                            <template x-if="!days[selected_day]?.active">
                                                                <span>No available slots selected</span>
                                                            </template>
                                                            <template x-if="days[selected_day]?.active">
                                                                <div class="flex gap-2 grid grid-cols-6">
                                                                    <div class="flex flex-col gap-1 lg:col-span-2 md:col-span-2 sm:col-span-2 col-span-3">
                                                                        {!! Form::time('timeslots[1][from]', null, ['x-model' => 'day_from', 'class' => 'mt-1 w-full py-2 float-left px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                                        <span class="text-xs text-gray-500">From</span>
                                                                    </div>
                                                                    <div class="flex flex-col gap-1 lg:col-span-2 md:col-span-2 sm:col-span-2 col-span-3">
                                                                        {!! Form::time('timeslots[1][to]', null, ['x-model' => 'day_to','class' => 'mt-1 w-full py-2 float-right px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                                        <span class="text-xs text-gray-500">To</span>
                                                                    </div>
                                                                    <a class="lg:col-span-1 md:col-span-1 sm:col-span-3 col-span-3 bg-primary hover:bg-primary_hover p-2 text-white h-10 w-14 rounded text-center cursor-pointer"
                                                                       @click="addDaySlot()">Add</a>
                                                                </div>
                                                            </template>
                                                            <div class="flex flex-col gap-2 mt-2">
                                                                <template x-for="timeslot in days[selected_day]?.availability"
                                                                          :key="timeslot"
                                                                          x-if="(days[selected_day] !== undefined && days[selected_day]?.availability?.length > 0)">
                                                                    <div class='flex justify-between items-center hover:bg-gray-50 rounded border-2 border-gray-100 p-2 cursor-pointer'>
                                                            <span class='text-sm'
                                                                  x-text="'From ' + moment(timeslot.from, 'hh:mm').format('hh:mm A') + ' to ' + moment(timeslot.to, 'hh:mm').format('hh:mm A')"></span>
                                                                        <div x-on:click="removeDaySlot(timeslot.id)">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                </template>
                                                            </div>

                                                            <span class="text-red-500 font-bold text-xs"
                                                                  x-show="day_availability_error !== undefined"
                                                                  x-text="day_availability_error"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="flex flex-col gap-1 pt-1 pb-2 border-t">

                                                    <p class="mt-3 font-semibold text-gray-700">All week availability</p>
                                                    <p class="text-xs text-gray-700 ">The default availability considered if you set a day as available above but do not set any specific time slots.</p>
                                                    <div class="flex gap-2 mt-2">
                                                        <div class="flex flex-col gap-1">
                                                            {!! Form::time('timeslots[1][from]', null, ['x-model' => 'default_availability.from', 'class' => 'mt-1 w-full py-2 float-left px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                            <span class="text-xs text-gray-500">From</span>
                                                        </div>
                                                        <div class="flex flex-col gap-1">
                                                            {!! Form::time('timeslots[1][to]', null, ['x-model' => 'default_availability.to', 'class' => 'mt-1 w-full py-2 float-right px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                            <span class="text-xs text-gray-500">To</span>
                                                        </div>
                                                    </div>
                                                    <span class="text-red-500 font-bold text-xs"
                                                          x-show="default_availability_error !== undefined"
                                                          x-text="default_availability_error"></span>
                                                </div>
                                                <div class="flex flex-col border-t py-2">
                                                    <p class="mt-3 font-semibold text-gray-700">Date overrides</p>
                                                    <p class="text-xs text-gray-700 ">Any time slots set here will override the above settings for that specific date.</p>
                                                    <div class="grid grid-cols-7 gap-2 w-full mt-2">
                                                        <div class="flex flex-col gap-1 col-span-2">
                                                            {!! Form::date('timeslots[1][date]', null, ['x-model'=> 'custom_date', 'class' => 'mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full border-0 shadow-md md:text-sm text-base border-gray-300 rounded-md']); !!}
                                                            <span class="text-xs text-gray-500">Date</span>
                                                        </div>
                                                        <div class="flex gap-2 col-span-4">
                                                            <div class="flex flex-col gap-1">
                                                                {!! Form::time('timeslots[1][from]', null, ['x-model'=> 'custom_from','class' => 'mt-1 w-full py-2 float-left px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                                <span class="text-xs text-gray-500">From</span>
                                                            </div>
                                                            <div class="flex flex-col gap-1">
                                                                {!! Form::time('timeslots[1][to]', null, ['x-model'=> 'custom_to','class' => 'mt-1 w-full py-2 float-right px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base']) !!}
                                                                <span class="text-xs text-gray-500">To</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-span-1 flex">
                                                            <button @click="addCustomSlot()"
                                                                    class="mb-3 cursor-pointer text-sm mt-2 font-semibold w-max inline-block text-center py-2 px-6 border-r  bg-primary text-white rounded"
                                                                    type="button"> Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col gap-2 mt-2">
                                                        <template x-for="timeslot in custom_timeslot_array"
                                                                  :key="timeslot.id">
                                                            <div class='flex justify-between items-center hover:bg-gray-50 rounded border-2 border-gray-100 p-2 cursor-pointer'>
                                                            <span class='text-sm'
                                                                  x-text="moment(timeslot.date).format('Do of MMM YYYY') + ' From ' + moment(timeslot.from, 'hh:mm').format('hh:mm A') + ' to ' + moment(timeslot.to, 'hh:mm').format('hh:mm A')"></span>
                                                                <div x-on:click="removeCustomSlot(timeslot.id)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                    <span class="text-red-500 font-bold text-xs"
                                                          x-show="custom_availability_error !== undefined"
                                                          x-text="custom_availability_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex justify-end">
                                            <a @click="saveAvailability()"
                                               class="cursor-pointer text-sm mt-2 font-semibold w-max inline-block text-center py-2 px-6 border-r  bg-primary hover:bg-primary_hover text-white rounded ">Save Availability</a>
                                        </div>
                                    </form>
                                </div>

                        </div>
                    </div>
            </div>
            <div class="py-3 bg-white text-left mb-3">
                <a href="{{route('agent.people.index')}}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Back
                </a>
            </div>
        </div>
    </div>

    <script>
        function availabilityConfigurator() {
            return {
                warningVisible: false,
                warningText: '',
                modalVisible: false,
                person_id: {{$person->id}},
                default_availability: {!! $person->schedule->default_availability !!},
                day_from: undefined,
                day_to: undefined,
                custom_date: '2021-11-10',
                custom_from: '10:00',
                custom_to: '11:00',
                message_error: undefined,
                message: '',
                recommend_similar_products: false,
                days: {!! $person->schedule->day_availability !!},
                selected_day: undefined,
                custom_timeslot_array: {!! $person->schedule->custom_availability !!},

                default_availability_error: undefined,
                custom_availability_error: undefined,
                day_availability_error: undefined,
                init() {
                    this.$watch('default_availability.from', value => {
                        this.checkUnsafeTimes();
                    });

                    this.$watch('default_availability.to', value => {
                        this.checkUnsafeTimes();
                    });
                },
                getDayClassNames(index) {
                    const day = this.days[index];
                    if (!day.active) {
                        return 'bg-gray-500';
                    } else if (index === this.selected_day) {
                        return 'bg-black-500';
                    } else if (day.availability.length > 0 && day.active) {
                        return 'bg-green-500';
                    } else if (day.availability.length === 0 && day.active) {
                        return 'bg-blue-500';
                    }
                },
                toggleDayStatus(status) {
                    this.days[this.selected_day].availability = [];
                    this.days[this.selected_day].active = status;
                },
                setCurrentDay(id) {
                    if (this.selected_day !== undefined && (id === this.selected_day)) {
                        this.selected_day = undefined;
                    } else {
                        this.selected_day = undefined;
                        this.selected_day = id;
                        if (this.days[id].availability.from && this.days[id].availability.to) {
                            this.custom_availability_from = this.days[id].availability.from;
                            this.custom_availability_to = this.days[id].availability.to;
                        } else {
                            this.custom_availability_from = undefined;
                            this.custom_availability_to = undefined;
                        }
                    }

                },
                validateTimeslots(from, to) {
                    if (!from) {
                        throw new Error('Start time field is required');
                    }

                    if (!to) {
                        throw new Error('End time field is required');
                    }

                    if (moment(from, 'HH:mm') >= moment(to, 'HH:mm')) {
                        throw new Error('Start time should be before the end time');
                    }
                },
                addDaySlot() {
                    this.day_availability_error = undefined;
                    try {
                        this.validateTimeslots(this.day_from, this.day_to);
                        this.days[this.selected_day].availability.forEach((item) => {

                            if ((moment(item.from, 'HH:mm') <= moment(this.day_to, 'HH:mm')) && (moment(this.day_from, 'HH:mm') <= moment(item.to, 'HH:mm'))) {
                                throw new Error('Times are overlapping')
                            }
                        });

                        this.days[this.selected_day].availability.push({
                            id: this.generateUuid(),
                            from: this.day_from,
                            to: this.day_to,
                        });

                        this.checkUnsafeTimes();
                    }
                    catch(error)
                    {
                        this.day_availability_error = error.message;
                    }
                },
                removeDaySlot(slotId) {
                    this.days[this.selected_day].availability = this.days[this.selected_day].availability.filter((item) => item.id !== slotId);
                    this.checkUnsafeTimes();
                },
                addCustomSlot() {
                    this.custom_availability_error = undefined;
                    try {
                        this.validateTimeslots(this.custom_from, this.custom_to);

                        if (!this.custom_date) {
                            throw new Error('Date field is required');
                        }

                        this.custom_timeslot_array.forEach((item) => {
                            if(moment(item.date).isSame(this.custom_date, 'day'))
                            {
                                if ((moment(item.from, 'HH:mm') <= moment(this.custom_to, 'HH:mm')) && (moment(this.custom_from, 'HH:mm') <= moment(item.to, 'HH:mm'))) {
                                    throw new Error('Times are overlapping')
                                }
                            }
                        });

                        this.custom_timeslot_array.push({
                            id: this.generateUuid(),
                            date: this.custom_date,
                            from: this.custom_from,
                            to: this.custom_to,
                        });

                        this.checkUnsafeTimes();
                    }
                    catch(error)
                    {
                        this.custom_availability_error = error.message;
                    }
                },
                checkUnsafeTimes(){
                    let unsafe = false;

                    const unsafe_start = '22:30';
                    const unsafe_end = '07:00';

                    function checkTimes(from, to){

                        if(from < unsafe_end || to > unsafe_start || from > unsafe_start || to < unsafe_end)
                        {
                            return true;
                        }

                        return false;
                    }

                    unsafe = checkTimes(this.default_availability.from, this.default_availability.to);

                    this.custom_timeslot_array.forEach((item) => {
                        unsafe = checkTimes(item.from, item.to);
                    });

                    this.days.forEach((day) => {
                        day.availability.forEach((item) => {
                            unsafe = checkTimes(item.from, item.to);
                        });
                    });

                    if(unsafe)
                    {
                        this.warningText = 'You have added unusual business hours for availability.';
                        this.warningVisible = true;
                    }
                    else
                    {
                        this.warningText = null;
                        this.warningVisible = false;
                    }
                },
                removeCustomSlot(slotId) {
                    this.custom_timeslot_array = this.custom_timeslot_array.filter((item) => item.id !== slotId);
                    this.checkUnsafeTimes();
                },
                setAvailability() {
                    if (this.custom_availability_from && this.custom_availability_to) {
                        const dayIndex = this.days.findIndex((item) => item.id === this.selected_day);
                        this.days[dayIndex].availability = {
                            from: this.custom_availability_from,
                            to: this.custom_availability_to,
                        };

                        this.selected_day = undefined;
                    } else {
                        this.custom_availability_error = 'Please enter both to and from times!';
                    }
                },
                saveAvailability() {
                    this.default_availability_error = undefined;
                    try {
                        this.validateTimeslots(this.default_availability.from, this.default_availability.to);
                    }
                    catch(error)
                    {
                        this.default_availability_error = error.message;
                        return;
                    }

                    const url = '{{route('agent.people.schedule.update', $person->getRouteKey())}}';
                    const data = {
                        custom_availability: this.custom_timeslot_array,
                        default_availability: this.default_availability,
                        day_availability: this.days,
                    };

                    window.axios.post(url, data)
                        .then((response) => {
                            let event = new CustomEvent('notice', {
                                detail: {
                                    'type': 'success',
                                    'text': 'Availability has been set successfully.'
                                }
                            });

                            window.dispatchEvent(event);
                        })
                        .catch((error) => {
                            let event = new CustomEvent('notice', {
                                detail: {
                                    'type': 'error',
                                    'text': 'Failed to set availability, please try again.'
                                }
                            });

                            window.dispatchEvent(event);
                        });

                },
                generateUuid() {
                    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
                        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                    );
                }
            }
        }
    </script>
@endsection
