<template>
    <div>
        <div class="antialiased pt-5 pb-28">
            <div class="w-full text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800">
                <div class="flex flex-col gap-2 max-w-screen-xl px-4 mx-auto md:px-6 lg:px-8">
                    <div class="w-full flex items-center justify-between mb-4">
                        <div class="text-gray-500 text-sm">Last edited 25 January 2022.</div>
                        <a href="/link" class="flex items-center text-sm text-blue-500 gap-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            view live page
                        </a>
                    </div>
                    <div class="w-full bg-white border hover:border-gray-400">
                        <div @click="step1=!step1" class="w-full flex justify-between items-center p-4 cursor-pointer" :class="{'border-b':step1}">
                            <div class="flex gap-2">
                                <div class="rounded-full w-6 h-6 bg-purple-600"></div>
                                <div>
                                    <p>What event is this?</p>
                                    <p class="text-xs text-gray-500">30 min Meeting, No location given</p>
                                </div>
                            </div>
                            <div v-show="step1">
                                <button class="text-gray-600">Cancel</button>
                                <button class="rounded-2xl ml-4 bg-blue-500 px-3 py-1 font-bold text-white">Save & Close</button>
                            </div>
                        </div>
                        <div v-show="step1" class="max-w-lg p-4">
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event Name * </label>
                                <input placeholder="30 min meeting" class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" required/>
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
                                <vue-editor id="editor" v-model="description" :editorToolbar="customToolbar"></vue-editor>
                            </div>
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event link * </label>
                                <div class="text-gray-500 text-sm mb-2">example.com/debarshi</div>
                                <input placeholder="Add a location" class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" required/>
                            </div>
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event color * </label>
                                <div class="flex gap-2">
                                    <div v-for="(color, i) in eventColors" :key="i" class="rounded-full w-8 h-8" :class="color"></div>
                                </div>
                            </div>
                        </div>
                        <div v-show="step1" class="w-full flex justify-end items-center p-4 border-t">
                            <div>
                                <button class="text-gray-600">Cancel</button>
                                <button class="rounded-2xl ml-4 bg-blue-500 font-bold px-3 py-1 text-white">Save & Close</button>
                            </div>
                        </div>
                    </div>
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
                            <div v-show="step2">
                                <button class="text-gray-600">Cancel</button>
                                <button class="rounded-2xl ml-4 bg-blue-500 px-3 py-1 font-bold text-white">Save & Close</button>
                            </div>
                        </div>
                        <div v-show="step2">
                            <div class="border-b">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Date Range </label>
                                    <div class="mb-4 text-gray-500">Set a range of dates when you can accept meetings.</div>
                                    <div class="flex items-center mb-4">
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
                                    <div class="ml-2">into the future</div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" class="cursor-pointer" name="date_range">
                                        <div class="flex ml-4">
                                            <div class="flex-1">Within a date range</div>
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
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                                <div>Custom</div>
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
                        <div v-show="step2" class="w-full flex justify-end items-center p-4 border-t">
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

export default {
    data(){
        return {
            dateRange: null,
            step1: false,
            step2: true,
            description: null,
            customToolbar: [
                ["bold", "italic", "underline"],
                [{ list: "ordered" }, { list: "bullet" }],
                ["link"]
            ],
            eventColors: [ 'bg-purple-600', 'bg-red-600', 'bg-green-600', 'bg-blue-600', 'bg-yellow-600', 'bg-pink-600', 'bg-indigo-600' ],
            dateRangeDropdwon: false,
            durationDropdown: false,
            beforeEventDropdown: false
        }
    },
    components: {
        VueEditor,
        DatePicker 
    },
}
</script>

<style scoped>

</style>