<template>
    <div>
        <Navbar/>
        <div class="antialiased pt-5 pb-28">
            <div class="w-full text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800">
                <div class="flex flex-col gap-2 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                    <div class="w-full flex items-center justify-between mb-4">
                        <div class="text-gray-500 text-sm">Last edited 25 January 2022.</div>
                        <a href="/schedule" target="blank" class="flex items-center text-sm text-blue-500 gap-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            view live page
                        </a>
                    </div>
                    <!-- Step 1 -->
                    <div class="w-full bg-white border hover:border-gray-400">
                        <div @click="step1=!step1" class="w-full flex justify-between items-center p-4 cursor-pointer" :class="{'border-b':step1}">
                            <div class="flex gap-2">
                                <div class="rounded-full w-6 h-6" :style="`background-color:${step1Data.color}`"></div>
                                <div>
                                    <p>What event is this?</p>
                                    <p class="text-xs text-gray-500">30 min Meeting, Video call</p>
                                </div>
                            </div>
                            <div class="hidden md:flex" v-show="step1">
                                <button class="text-gray-600">Cancel</button>
                                <button @click.stop="saveStep1()" :disabled="step1Processing" class="rounded-2xl disabled:bg-blue-400 ml-4 bg-blue-500 px-3 py-1 font-bold flex items-center justify-center text-white">
                                    <svg v-show="step1Processing" class="animate-spin mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Save & Close
                                </button>
                            </div>
                        </div>
                        <div v-show="step1" class="max-w-lg p-4">
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event Name * </label>
                                <input placeholder="30 min meeting" v-model="step1Data.name" class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" required/>
                            </div>
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Location * </label>
                                <div class="flex items-center gap-2">
                                    <div class="rounded-full bg-green-500 p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                        </svg>
                                    </div>
                                    <div>
                                        Video Call
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Description * </label>
                                <vue-editor id="editor" v-model="step1Data.description" :editorToolbar="customToolbar"></vue-editor>
                            </div>
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event link * </label>
                                <div class="text-gray-500 text-sm mb-2">example.com/debarshi</div>
                                <input placeholder="link" v-model="step1Data.link" class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" required/>
                            </div>
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event color * </label>
                                <div class="flex gap-2">
                                    <div v-for="(color, i) in eventColors" :key="i" @click="step1Data.color = color" class="rounded-full cursor-pointer w-8 h-8 flex items-center justify-center" :style="`background-color:${color}`">
                                        <svg v-if="color==step1Data.color" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-show="step1" class="w-full flex justify-center md:justify-end items-center p-4 border-t">
                            <div class="flex">
                                <button class="text-gray-600">Cancel</button>
                                <button @click.stop="saveStep1()" :disabled="step1Processing" class="rounded-2xl disabled:bg-blue-400 ml-4 bg-blue-500 px-3 py-1 font-bold flex items-center justify-center text-white">
                                    <svg v-show="step1Processing" class="animate-spin mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Save & Close
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="w-full bg-white border hover:border-gray-400">
                        <div @click="step2=!step2" class="w-full flex justify-between items-center p-4 cursor-pointer" :class="{'border-b':step2}">
                            <div class="flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                <div>
                                    <p>When can people book this event?</p>
                                    <p class="text-xs text-gray-500">30 min, 60 rolling calendar days</p>
                                </div>
                            </div>
                            <div class="hidden md:block" v-show="step2">
                                <button class="text-gray-600">Cancel</button>
                                <button class="rounded-2xl ml-4 bg-blue-500 px-3 py-1 font-bold text-white">Save & Close</button>
                            </div>
                        </div>
                        <div v-show="step2">
                            <div class="border-b">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Date Range </label>
                                    <div class="mb-4 text-gray-500">Set a range of dates when you can accept meetings.</div>
                                    <div class="flex flex-col md:flex-row md:items-center mb-4">
                                        <div class="flex flex-1 items-center">
                                            <input type="radio" class="cursor-pointer" name="date_range">
                                            <input placeholder="30" class="appearance-none ml-4 w-16 border rounded-md h-10 px-3 text-gray-700 leading-tight focus:border-blue-400 focus:outline-none focus:shadow-outline" type="text" required/>
                                            <div class="relative ml-2 flex-1">
                                                <button @click="dateRangeDropdwon = !dateRangeDropdwon" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                    <span>calendar days</span>
                                                    <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': dateRangeDropdwon, 'rotate-0': !dateRangeDropdwon}" class="inline w-4 h-4 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                                <transition name="fade">
                                                    <div v-show="dateRangeDropdwon" class="absolute w-full z-10">
                                                        <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                            <div class="grid grid-cols-1 gap-1">
                                                                <a class="rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                    <div class="text-gray-800 rounded-lg">
                                                                        <div>calendar days</div>
                                                                        <div class="text-gray-400 text-xs mt-2">Counts every day on the calendar including days you're unavailable</div>
                                                                    </div>
                                                                </a>    
                                                                <a class="rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                    <div class="text-gray-800 rounded-lg">
                                                                        <div>business days</div>
                                                                        <div class="text-gray-400 text-xs mt-2">Excludes weekends and only counts Mon - Fri</div>
                                                                    </div>
                                                                </a>                                                       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                        <div class="ml-2 text-right">into the future</div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" class="cursor-pointer" name="date_range">
                                        <div class="flex flex-1 ml-4 gap-2 items-center">
                                            <div class="">Within a date range</div>
                                            <div class="flex-1">
                                                <date-picker v-model="dateRange" range></date-picker>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="border-b">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Duration </label>
                                    <div class="mb-4 text-gray-500">Define how long your event will be. It can be as long as 12 hours.</div>
                                    <div class="flex items-center mb-4">
                                        <div class="relative flex-1">
                                            <button @click="durationDropdown = !durationDropdown" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                <span>15 min</span>
                                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': durationDropdown, 'rotate-0': !durationDropdown}" class="inline w-4 h-4 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                            <transition name="fade">
                                                <div v-show="durationDropdown" class="absolute w-full z-10">
                                                    <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                        <div class="grid grid-cols-1 gap-1">
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>15 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>30 min</div>
                                                            </a>   
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>45 min</div>
                                                            </a>    
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>60 min</div>
                                                            </a>                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </transition>
                                        </div> 
                                    </div>
                                </div>  
                            </div>   
                            <div class="border-b">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Weekly Hours </label>
                                    <div class="mb-4 text-gray-500">To override your hours on specific dates, update your schedule under Availability.</div>
                                    <div class="mb-4 border rounded-md">
                                        <table class="w-full">
                                            <tbody class="text-sm font-normal text-gray-700">
                                                <tr>
                                                    <td class="px-4 py-4">SUN</td>
                                                    <td class="px-4 py-4 text-gray-400">Unavailable</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-4">MON</td>
                                                    <td class="px-4 py-4 text-gray-400">9:00 am – 5:00 pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-4">TUE</td>
                                                    <td class="px-4 py-4 text-gray-400">9:00 am – 5:00 pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-4">WED</td>
                                                    <td class="px-4 py-4 text-gray-400">9:00 am – 5:00 pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-4">THU</td>
                                                    <td class="px-4 py-4 text-gray-400">9:00 am – 5:00 pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-4">FRI</td>
                                                    <td class="px-4 py-4 text-gray-400">9:00 am – 5:00 pm</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-4 py-4">SAT</td>
                                                    <td class="px-4 py-4 text-gray-400">Unavailable</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                            </div>  
                            <div class="">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2"> Want to add time before or after your events? </label>
                                    <div class="mb-4 text-gray-500">Give yourself some buffer time to prepare for or wrap up from booked Calendly events.</div>
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" class="cursor-pointer" name="date_range">
                                        <div class="ml-4">Before event</div>
                                        <div class="relative ml-2 flex-1">
                                            <button @click="beforeEventDropdown = !beforeEventDropdown" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                <span>15 min</span>
                                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': beforeEventDropdown, 'rotate-0': !beforeEventDropdown}" class="inline w-4 h-4 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                            <transition name="fade">
                                                <div v-show="beforeEventDropdown" class="absolute w-full z-10">
                                                    <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                        <div class="grid grid-cols-1 gap-1">
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>5 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>10 min</div>
                                                            </a>   
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>15 min</div>
                                                            </a>    
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>20 min</div>
                                                            </a>                             
                                                        </div>
                                                    </div>
                                                </div>
                                            </transition>
                                        </div> 
                                    </div>
                                </div>  
                            </div>                 
                        </div>
                        <div v-show="step2" class="w-full flex justify-center md:justify-end items-center p-4 border-t">
                            <div>
                                <button class="text-gray-600">Cancel</button>
                                <button class="rounded-2xl ml-4 bg-blue-500 font-bold px-3 py-1 text-white">Save & Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import Navbar from '../../components/Navbar.vue'

export default {
    data(){
        return {
            step1Data: {
                id: null,
                name: null,
                description: null,
                link: null,
                color: '#c94f16',
            },
            step1Processing: false,
            dateRange: null,
            step1: false,
            step2: false,
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["link"]
            ],
            eventColors: [ '#c94f16', '#c9a316', '#70c916', '#16c3c9', '#1658c9', '#4916c9', '#8e16c9', '#c91685' ],
            dateRangeDropdwon: false,
            durationDropdown: false,
            beforeEventDropdown: false
        }
    },
    components: {
        VueEditor,
        DatePicker,
        Navbar
    },
    methods: {
        saveStep1(){
            this.step1Processing = true
            this.$axios.post(`/api/events/${this.step1Data.id ? this.step1Data.id : ''}`, this.step1Data).then(res => {
                console.log(res)
                this.step1Data.id = res.data.data.id
                this.step1Processing = false
            }).catch(err => {
                console.log(err)
                this.step1Processing = false
            })
        },
    }
}
</script>

<style scoped>
    .mx-datepicker-range {
        width: 100% !important;
    }
</style>