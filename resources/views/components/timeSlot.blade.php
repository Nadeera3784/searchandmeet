
<div class="col-span-6" x-data="addTimeSlotHandler()" x-show="isNativeTimeSlot">

    <div class="flow-root mb-3">
        <div class="inline-flex float-left mb-3">
            <p class="font-bold {{ $labelClass }}">
                Available time slots
            </p>
        </div>
        <button @click="addNewField()" class="mt-1 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 float-right"  type="button">+ Add more</button>
    </div>

    <div class="grid grid-cols-6 md:gap-4 md:gap-x-6 gap-y-4 auto-cols-frw-full">
        <template x-for="(field, index) in fields" :key="index">
            <div class="col-span-6 md:col-span-2 mb-3" x-transition>
                <input placeholder="Pick a Category" x-model="field.date"
                       class="mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base"
                       :name="'timeslots['+index+'][date]'" type="date">
                <div class="grid grid-cols-2 gap-2">

                    <div class="sm:col-span-6 mt-2">
                        <select x-model="field.time" :name="'timeslots['+index+'][from]'"
                                class="inline-block w-full appearance-none bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Pick a time</option>
                            <template x-for="slot in slots" :key="slot">
                                <option :value="slot.start" x-text="slot.start +' - '+ slot.end"></option>
                            </template>
                        </select>
                        <button @click="removeField(index)" x-show="index > 0"
                                class="inline-flex mt-3 justify-center py-2 px-3 mb-3 shadow-md text-sm font-medium rounded-md text-gray-900 bg-gray-200 hover:bg-gray-400 focus:outline-none focus:ring-0 cursor-pointer float-right"
                                type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="20" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-trash-2 mr-3">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>
            @if ($errors->has('timeslots.0.date'))
                <div class="text-xs text-red-600 text-left mt-1">{{ $errors->first('timeslots.0.date') }}</div>
            @elseif($errors->has('timeslots.0.from'))
                <div class="text-xs text-red-600 text-left mt-1">{{ $errors->first('timeslots.0.from') }}</div>
            @endif
            @error('timeslots')
            <div class="col-start-1 col-span-6 text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
        </template>
    </div>
</div>



<div class="col-span-6" x-data="editTimeSlotHandler()" x-init="onInit()" x-show="!isNativeTimeSlot">

    <div class="flow-root mb-3">
        <div class="inline-flex float-left mb-3">
            <p class="font-bold {{ $labelClass }}">
               Available time slots
            </p>
        </div>
        <button @click="addNewField()" class="mt-1 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-500 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 float-right"  type="button">+ Add more</button>
    </div>

    <div class="grid grid-cols-6 md:gap-4 md:gap-x-6 gap-y-4 auto-cols-frw-full">
        <template x-for="(field, index) in fields" :key="index">
            <div class="col-span-6 md:col-span-2 mb-3" x-transition>
                <input x-model="field.date"
                       class="mt-1 block w-full py-2 px-3 border-0 border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 md:text-sm text-base"
                       :name="'timeslots['+index+'][date]'" type="date">
                <div class="grid grid-cols-2 gap-2">
                    <div class="sm:col-span-6 mt-2">
                        <select x-model="field.time" :name="'timeslots['+index+'][from]'"
                                class="inline-block w-full appearance-none bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <template x-for="slot in field.slots" :key="slot">
                                <option :value="slot.start" x-text="slot.start +' - '+ slot.end" :selected="field.time == slot.start"></option>
                            </template>
                        </select>
                        <button @click="removeField(index)" x-show="index > 0"
                                class="inline-flex mt-3 justify-center py-2 px-3 mb-3 shadow-md text-sm font-medium rounded-md text-gray-900 bg-gray-200 hover:bg-gray-400 focus:outline-none focus:ring-0 cursor-pointer float-right"
                                type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="20" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-trash-2 mr-3">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>
            @if ($errors->has('timeslots.0.date'))
                <div class="text-xs text-red-600 text-left mt-1">{{ $errors->first('timeslots.0.date') }}</div>
            @elseif($errors->has('timeslots.0.from'))
                <div class="text-xs text-red-600 text-left mt-1">{{ $errors->first('timeslots.0.from') }}</div>
            @endif
        </template>
        @error('timeslots')
        <div class="col-start-1 col-span-6 text-xs text-red-600 text-left mt-1">{{ $message }}</div> @enderror
    </div>
</div>



<script>

    var timeSlotData = {{ $timeSlotData }}

    var timeZone = {{ $timeZone }}

    var isNativeTimeSlot = {{ $nativeTimeSlot }}

    function addTimeSlotHandler(){
        return {
            fields: [{start: '', end: ''}],
            slots: [
                {start: '01:00', end: '01.30'},
                {start: '02:00', end: '02.30'},
                {start: '03:00', end: '03.30'},
                {start: '04:00', end: '04.30'},
                {start: '05:00', end: '05.30'},
                {start: '06:00', end: '06.30'},
                {start: '07:00', end: '07.30'},
                {start: '08:00', end: '08.30'},
                {start: '09:00', end: '09.30'},
                {start: '10:00', end: '10.30'},
                {start: '11:00', end: '11.30'},
                {start: '12:00', end: '12.30'},
                {start: '13:00', end: '13.30'},
                {start: '14:00', end: '14.30'},
                {start: '15:00', end: '15.30'},
                {start: '16:00', end: '16.30'},
                {start: '17:00', end: '17.30'},
                {start: '18:00', end: '18.30'},
                {start: '19:00', end: '19.30'},
                {start: '20:00', end: '20.30'},
                {start: '21:00', end: '21.30'},
                {start: '22:00', end: '22.30'},
                {start: "23:00", end: '23.30'}
            ],
            addNewField() {
                this.fields.push({
                    date: '',
                    time: ''
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }
    }


    function editTimeSlotHandler() {
        return {
            fields: [],
            slots: [
                {start: '01:00', end: '01:30'},
                {start: '02:00', end: '02:30'},
                {start: '03:00', end: '03:30'},
                {start: '04:00', end: '04:30'},
                {start: '05:00', end: '05:30'},
                {start: '06:00', end: '06:30'},
                {start: '07:00', end: '07:30'},
                {start: '08:00', end: '08:30'},
                {start: '09:00', end: '09:30'},
                {start: '10:00', end: '10:30'},
                {start: '11:00', end: '11:30'},
                {start: '12:00', end: '12:30'},
                {start: '13:00', end: '13:30'},
                {start: '14:00', end: '14:30'},
                {start: '15:00', end: '15:30'},
                {start: '16:00', end: '16:30'},
                {start: '17:00', end: '17:30'},
                {start: '18:00', end: '18:30'},
                {start: '19:00', end: '19:30'},
                {start: '20:00', end: '20:30'},
                {start: '21:00', end: '21:30'},
                {start: '22:00', end: '22:30'},
                {start: "23:00", end: '23:30'}
            ],
            onInit() {
                if(timeSlotData){
                    for (let index = 0; index < timeSlotData.length; index++) {

                        //let formated_date =  moment(timeSlotData[index].start).format('YYYY-MM-DD');

                        //let formated_time =  moment(timeSlotData[index].start).format('hh:mm');

                        let formated_date = moment(timeSlotData[index].start).tz(timeZone).format('YYYY-MM-DD');
                        let formated_time = moment(timeSlotData[index].start).tz(timeZone).format('HH:mm');

                        const private_slots = this.slots.map(item => ({...item}))

                        const fieldSlots = JSON.parse(JSON.stringify(private_slots));

                        let foundSlot = fieldSlots.filter(function (slot, i) {
                            if(slot.start == formated_time){ 
                                return slot;
                            }
                        });


                        this.fields.push({
                            date: formated_date,
                            time: formated_time,
                            slots: JSON.parse(JSON.stringify(fieldSlots))
                        });
                    }
                }
            },
            addNewField() {
                this.fields.push({
                    date: '',
                    time: '',
                    slots: JSON.parse(JSON.stringify(this.slots))
                });
            },
            removeField(index) {
                this.fields.splice(index, 1);
            }
        }
    }

</script>
