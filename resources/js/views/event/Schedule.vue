<template>
    <div>
        <div class="antialiased bg-gray-50 min-h-screen">
            <div class="w-full text-gray-700 bg-white shadow-sm p-4">
                <div class="flex max-w-screen-lg px-4 mx-auto items-center justify-between md:px-6 lg:px-8">
                    <div class="flex flex-row items-center justify-between">
                        <a href="/" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">LOGO HERE</a>
                    </div>
                    <nav class="pb-0 flex justify-end gap-2">
                        <button class="flex rounded-full items-center justify-center bg-gray-600 text-white h-8 w-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                        <button class="flex rounded-full items-center justify-center bg-blue-600 text-white h-8 w-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
            <div class="w-full">
                <div class="flex max-w-screen-lg p-8 mx-auto items-center justify-between">
                    <div id="container" class="w-full flex flex-col md:flex-row border rounded-md bg-white">
                        <div class="w-full md:w-4/12 font-medium border-r p-5">
                            <div class="text-gray-500">Debarshi Das</div>
                            <div class="text-2xl font-bold text-gray-700">30 Minute Meeting</div>
                            <div class="flex items-center gap-2 text-gray-700 mt-4">
                                <div class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="flex-1">15 min</div>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <div class="w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                    </svg>
                                </div>
                                <div class="flex-1">Video conferencing details provided upon confirmation.</div>
                            </div>
                            <div class="mt-4 text-gray-600 text-sm">Meeting details here</div>
                        </div>
                        <div class="w-full md:w-8/12">
                            <div class="flex flex-col md:flex-row w-full h-full">
                                <div class="w-full md:w-8/12 p-5">
                                    <div class="mb-6 text-xl font-medium text-gray-700">Select a Date & Time</div>
                                    <vc-date-picker
                                        v-model="selectedDate"
                                        is-expanded 
                                        title-position="left"
                                        :available-dates="[ 
                                            new Date('2022-01-23'),
                                            new Date('2022-01-24'),
                                        ]"
                                        :locale="{ masks: { weekdays: 'WWW' } }"
                                    >
                                    </vc-date-picker>
                                    <TimezoneSelector class="mt-4"/>
                                </div>
                                <transition name="fade">
                                    <div v-if="selectedDate" class="w-full md:w-4/12 h-full pt-5 flex flex-col">
                                        <div class="mb-5 px-5">{{ formattedSelectedDate }}</div>
                                        <div class="overflow-auto px-5 py-2">
                                        <div v-for="i in 10" :key="i" @click="activeTime = i" class="flex gap-2 mb-3">
                                                <div v-if="i!=activeTime" class="ring-1 w-full cursor-pointer hover:ring-2 ring-blue-500 ring-offset-0 text-blue-600 font-medium py-3 rounded-md text-center">
                                                    12:00 am
                                                </div>
                                                <div v-if="i==activeTime" class="w-6/12 py-3 cursor-pointer bg-gray-600 text-white rounded-md text-center">2:30 am</div>
                                                <div v-if="i==activeTime" @click="$router.push({ path: '/schedule/confirm' })" class="w-6/12 py-3 cursor-pointer bg-blue-600 hover:bg-blue-400 text-white rounded-md text-center">Confirm</div>
                                        </div>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TimezoneSelector from '../../components/TimezoneSelector.vue'
import moment from "moment";
export default {
    name: 'EventLink',
    data(){
        return {
            selectedDate: null,
            showTimeSlots: false,
            activeTime: null
        }
    },
    computed: {
        formattedSelectedDate(){
            return moment(this.selectedDate).format('dddd, MMMM DD')
        }
    },
    components: {
        TimezoneSelector
    },
    methods: {
        moment() {
            return moment();
        },
    }
}
</script>

<style scoped>
    #container{
        min-height: 600px;
    }
</style>