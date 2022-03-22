<template>
    <div>
        <Navbar />
        <div class="antialiased pt-5 pb-28">
            <div class="flex items-center gap-2 max-w-screen-lg px-4 mx-auto justify-center" v-show="isPageLoading">
                <div class="bg-blue-600 p-2  w-4 h-4 rounded-full animate-bounce blue-circle blue-circle-1"></div>
                <div class="bg-blue-600 p-2  w-4 h-4 rounded-full animate-bounce blue-circle blue-circle-2"></div>
                <div class="bg-blue-600 p-2  w-4 h-4 rounded-full animate-bounce blue-circle blue-circle-3"></div>
            </div>
            <div class="w-full text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800" v-show="!isPageLoading">
                <div class="flex justify-between max-w-screen-lg mb-5 px-4 mx-auto md:px-6 lg:px-8">
                    <button @click="goToDashboard" type="button"
                        class="flex gap-1 border items-center border-blue-500 text-blue-500 py-1 px-3 rounded-3xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Back</span>
                    </button>
                    <button v-show="!isDeleteConfirmed" @click="deleteConfirmation" type="button"
                        class="flex gap-1 border items-center border-red-500 text-red-500 py-1 px-3 rounded-3xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete</span>
                    </button>
                    <div class="flex items-start gap-2" v-show="isDeleteConfirmed">
                        <button type="button" @click="deleteConfirmation"
                            class="flex gap-1 border items-center border-gray-500 text-gray-700 py-1 px-3 rounded-3xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Cancel</span>
                        </button>
                        <button @click="deleteEvent" type="button"
                            class="flex gap-1 border items-center border-red-500 text-red-500 py-1 px-3 rounded-3xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Delete this event?</span>
                        </button>
                    </div>
                </div>
                <div class="flex flex-col gap-2 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                    <div class="w-full flex items-center justify-between mb-4">
                        <div class="text-gray-500 text-sm">Last edited {{ lastEditedDate }}.</div>
                        <router-link :to="'/schedule/' + authDetails.username+'/'+step1Data.link" target="_blank"
                            class="flex items-center text-sm text-blue-500 gap-2 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            view live page
                        </router-link>
                    </div>
                    <!-- Step 1 -->
                    <div class="w-full bg-white border hover:border-gray-400">
                        <div @click="step1=!step1" class="w-full flex justify-between items-center p-4 cursor-pointer"
                            :class="{'border-b':step1}">
                            <div class="flex gap-2">
                                <div class="rounded-full w-6 h-6" :style="`background-color:${step1Data.color}`"></div>
                                <div>
                                    <p>What event is this?</p>
                                    <p class="text-xs text-gray-500">{{ step1Data.name }}, Video call</p>
                                </div>
                            </div>
                            <div class="hidden md:flex" v-show="step1">
                                <button @click="step1=!step1" class="text-gray-600 mr-3">Cancel</button>
                                <button @click.stop="updateStep1()" :disabled="step1Processing"
                                    class="rounded-2xl disabled:bg-blue-400 ml-4 bg-blue-500 px-3 py-1 font-bold flex items-center justify-center text-white">
                                    <svg v-show="step1Processing" class="animate-spin mr-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Save & Close
                                </button>
                            </div>
                        </div>
                        <div v-show="step1" class="max-w-lg p-4">
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event Name * </label>
                                <input placeholder="30 min meeting" v-model="step1Data.name" class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :class="{'border-red-500' : validationErrorMessages.name !== null}" type="text" required/>
                                <small class="text-red-500 mx-2" v-show="validationErrorMessages.name !== null">{{ validationErrorMessages.name }}</small>
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
                                <vue-editor id="editor" v-model="step1Data.description" :editorToolbar="customToolbar" :class="{'border border-red-500' : validationErrorMessages.description !== null}"></vue-editor>
                                <small class="text-red-500 mx-2" v-show="validationErrorMessages.description !== null">{{ validationErrorMessages.description }}</small>
                            </div>
                            <div class="mb-4 w-full">
                                <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Event link * </label>
                                <div class="text-gray-500 text-sm mb-2">example.com/debarshi</div>
                                <input placeholder="link" v-model="step1Data.link" class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" :class="{'border-red-500' : validationErrorMessages.link !== null}" type="text" required/>
                                <small class="text-red-500 mx-2" v-show="validationErrorMessages.link !== null">{{ validationErrorMessages.link }}</small>
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
                                <button @click="step1=!step1" class="text-gray-600">Cancel</button>
                                <button @click.stop="updateStep1()" :disabled="step1Processing"
                                    class="rounded-2xl disabled:bg-blue-400 ml-4 bg-blue-500 px-3 py-1 font-bold flex items-center justify-center text-white">
                                    <svg v-show="step1Processing" class="animate-spin mr-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Save & Close
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="w-full bg-white border hover:border-gray-400">
                        <div @click="step2=!step2" class="w-full flex justify-between items-center p-4 cursor-pointer"
                            :class="{'border-b':step2}">
                            <div class="flex gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div>
                                    <p>When can people book this event?</p>
                                    <p class="text-xs text-gray-500">30 min, 60 rolling calendar days</p>
                                </div>
                            </div>
                            <div class="hidden md:block" v-show="step2">
                                <button class="text-gray-600">Cancel</button>
                                <button class="rounded-2xl ml-4 bg-blue-500 px-3 py-1 font-bold text-white" @click.stop="updateStep2()" :disabled="step2Processing">   
                                    <svg v-show="step2Processing" class="animate-spin mr-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Save & Close


                                </button>
                            </div>
                        </div>
                        <div v-show="step2">
                            <div class="border-b">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Date
                                        Range </label>
                                    <div class="mb-4 text-gray-500">Set a range of dates when you can accept meetings.
                                    </div>
                                    <div class="flex flex-col md:flex-row md:items-center mb-4">
                                        <div class="flex flex-1 items-center">
                                            <input type="radio" class="cursor-pointer" name="date_range" v-model="step2Data.checkboxval" :checked="step2Data.checkboxval == 'no_of_days'" value="no_of_days" @change="checkvalue($event)">
                                            <input placeholder="30"
                                                class="appearance-none ml-4 w-16 border rounded-md h-10 px-3 text-gray-700 leading-tight focus:border-blue-400 focus:outline-none focus:shadow-outline"
                                                type="text" required  v-model="step2Data.noofdays.dayscount"/>
                                            <div class="relative ml-2 flex-1">
                                                  <select name="duration" v-model="step2Data.noofdays.type" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                    <option value="" class="rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">Select</option>
                                                  <option value="Calendar days" class="rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" title="Counts every day on the calendar including days you're unavailable" :selected="step2Data.noofdays.type=='Calendar days'">Calendar days</option>
                                                <option value="Business days" class="rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" title="Excludes weekends and only counts Mon - Fri" :selected="step2Data.noofdays.type=='Business days'">Business days</option>
                                            </select>
                                                <!-- <button @click="dateRangeDropdwon = !dateRangeDropdwon"
                                                    class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                    <span>calendar days</span>
                                                    <svg fill="currentColor" viewBox="0 0 20 20"
                                                        :class="{'rotate-180': dateRangeDropdwon, 'rotate-0': !dateRangeDropdwon}"
                                                        class="inline w-4 h-4 transition-transform duration-200 transform">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </button> -->

                                                <!-- <transition name="fade">
                                                    <div v-show="dateRangeDropdwon" class="absolute w-full z-10">
                                                        <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                            <div class="grid grid-cols-1 gap-1">
                                                                <a class="rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                    href="javascript:void(0)">
                                                                    <div class="text-gray-800 rounded-lg">
                                                                        <div>calendar days</div>
                                                                        <div class="text-gray-400 text-xs mt-2" >Counts
                                                                            every day on the calendar including days
                                                                            you're unavailable</div>
                                                                    </div>
                                                                </a>
                                                                <a class="rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                    href="javascript:void(0)">
                                                                    <div class="text-gray-800 rounded-lg">
                                                                        <div>business days</div>
                                                                        <div class="text-gray-400 text-xs mt-2">Excludes
                                                                            weekends and only counts Mon - Fri</div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </transition> -->
                                            </div>
                                            
                                        </div>
                                        <div class="ml-2 text-right">into the future</div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" class="cursor-pointer" name="date_range" v-model="step2Data.checkboxval" :checked="step2Data.checkboxval == 'daterange'" value="daterange" @change="checkvalue($event)">
                                        <div class="flex flex-1 ml-4 gap-2 items-center">
                                            <div class="">Within a date range</div>
                                            <div class="flex-1">
                                                <date-picker  
                                               v-model="dateRange" type="date" range placeholder="Select date range"
                                                ></date-picker>
                                            </div>
                                        </div>
                                    </div>
                                    <small class="text-red-500 mx-2" v-show="validationErrorMessages.checkboxval !== null">{{ validationErrorMessages.checkboxval }}</small>
                                </div>
                            </div>
                            <div class="border-b">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Duration
                                    </label>
                                    <div class="mb-4 text-gray-500">Define how long your event will be. It can be as
                                        long as 12 hours.</div>
                                    <div class="flex items-center mb-4">
                                        <div class="relative flex-1">

                                             <select name="duration" v-model="step2Data.duration" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                  <option value="" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">Select</option>
                                                <option value="15 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">15 min</option>
                                                <option value="30 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">30 min</option>
                                                <option value="45 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">45 min</option>
                                                <option value="60 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">60 min</option>
                                            </select>


                                            <!-- <button @click="durationDropdown = !durationDropdown"
                                                class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                <span>15 min</span>
                                                <svg fill="currentColor" viewBox="0 0 20 20"
                                                    :class="{'rotate-180': durationDropdown, 'rotate-0': !durationDropdown}"
                                                    class="inline w-4 h-4 transition-transform duration-200 transform">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button> -->
                                            <!-- <transition name="fade">
                                                <div v-show="durationDropdown" class="absolute w-full z-10">
                                                    <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                        <div class="grid grid-cols-1 gap-1">
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#">
                                                                <div>15 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#">
                                                                <div>30 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#">
                                                                <div>45 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#">
                                                                <div>60 min</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </transition> -->
                                        </div>
                                    </div>
                                     <small class="text-red-500 mx-2" v-show="validationErrorMessages.duration !== null">{{ validationErrorMessages.duration }}</small>
                                </div>
                            </div>
                            <div class="border-b">

                                <div class="viewbuttons gap-2 mt-5">
                                    

                                    <button class="" type="button" @click="changeView('list')"><i class="fas fa-list"></i> List view </button>
                                    <button class="" type="button" @click="changeView('calendar')"><i class="fas fa-calendar"></i> Calendar view </button>

                                </div>

                                <div v-show="isListView">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Weekly
                                        Hours </label>
                                    <div class="mb-4 text-gray-500">To override your hours on specific dates, update
                                        your schedule under Availability.</div>
                                    <div class="mb-4 border rounded-md">
                                       

                            <div class="px-5 pt-5 w-full" >
                           <!--  <div class="font-medium">Set your weekly hours</div> -->
                            <div class="mt-5 w-full md:w-6/12 divide-y">
                                <div v-for="(item, i) in Object.keys(availability)" :key="i" class="flex flex-col md:flex-row text-sm gap-4 py-4 w-full ">
                                    <div class="my-3 flex-1">
                                        <div class="flex items-center gap-2" style="margin-top: 8px; width: 20px;">
                                            <input type="checkbox" class="cursor-pointer" 
                                            :id="item"  
                                            @click='check(item,$event)'
                                            v-model="availability[item].length>0?true:false"
                                            :checked="availability[item].length>0"
                                            >
                                            <span class="font-medium">{{ item.substring(0,3).toUpperCase() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 gap-2 justify-between" v-if="availability[item].length>0">
                                        <div>
                                            <div v-for="(sch, i) in availability[item]" :key="i">
                                                <div class="flex gap-2 my-2 items-center" style="width:350px; margin-left: 40px;">
                                                    <vue-timepicker v-model="sch.open" input-class="rounded outline-none" format="HH:mm" ></vue-timepicker>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <vue-timepicker v-model="sch.close" input-class="rounded outline-none" format="HH:mm"></vue-timepicker>


                                                    <a href="javascript:void(0);" @click="removeSundayvalue(item,i)"><i class="fa-solid fa-trash-can" style="margin-left: 10px;"></i></a>

                                                <div class="timediv">
                                                <a
                                                href="javascript:void(0);"
                                                @click="
                                                addSundayvalue(
                                                item,i
                                                )
                                                "
                                                v-show="
                                                i == 0

                                                "
                                                >
                                                <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="showdivicon"  v-show="
                                                i == 0

                                                ">
                                                <a
                                                href="javascript:void(0);"
                                                @click="showDropdown(item,$event)"
                                                >
                                                <i class="fa-regular fa-copy"></i>
                                                </a>
                                                    <div  class="multiselect" v-if="selectedValues[item][0].show">
                                            <ul class="px-2 py-2 bcolor" style="text-align: left;">
                                            <li class="px-1 py-1"><p>Copy Items to</p></li>
                                            <li
                                            class="px-1 py-1 dissty"
                                            v-for="(option, index) in options"
                                            :key="index"
                                            >

                                            <label :for="index">{{ option.value.charAt(0).toUpperCase() + option.value.slice(1)  }}

                                                 <input style="float: right;"
                                            class="inputstyle"
                                            type="checkbox"
                                            :id="index"
                                            :value="option.value"
                                            :checked="selectedValues[item][0].selectedvalue.includes(option.value)"
                                            :disabled="option.value==item"
                                            @click="onCheck(option.value,$event,item)"
                                            />

                                            </label>
                                           

                                            </li>

                                            <li class="px-1 py-1 butsty">
                                            <button class="applybtn" @click="onApply(item)">Apply</button>
                                            </li>
                                            </ul>
                                            </div>

                                       


                                        </div>
                                        </div>
                                                

                                                </div>

                                

                                            </div>


                                              
                                        </div>
                                    </div>

                                    <div class="flex flex-1 gap-2 justify-between" v-if="availability[item].length==0">
                                        <div>
                                            <div >
                                                <div class="flex gap-4 my-2 items-center" >
                                                    <p style="margin-right:187px;margin-left:41px">Unavailable</p>

                                                <div class="timediv">
                                                <a
                                                
                                                href="javascript:void(0);"
                                                @click="
                                                addSundayvalue(
                                                item,0
                                                )
                                                "
                                               
                                                >
                                                <i class="fa fa-plus"></i>
                                                </a>
                                                 <a
                                                href="javascript:void(0);"
                                                @click="showDropdown(item,$event)"
                                                >
                                                <i class="fa-regular fa-copy"></i>
                                                </a>
                                                        <div  class="multiselect" v-if="selectedValues[item][0].show">
                                            <ul class="px-2 py-2 bcolor">
                                            <li class="px-1 py-1"><p>Copy Items to</p></li>
                                            <li
                                            class="px-1 py-1 dissty"
                                            v-for="(option, index) in options"
                                            :key="index"
                                            >

                                            <label :for="index">{{ option.value.charAt(0).toUpperCase() + option.value.slice(1)  }}</label>
                                            <input
                                            class="inputstyle"
                                            type="checkbox"
                                            :id="index"
                                            :value="option.value"
                                            :checked="selectedValues[item][0].selectedvalue.includes(option.value)"
                                            @click="onCheck(option.value,$event,item)"
                                            />

                                            </li>

                                            <li class="px-1 py-1 butsty">
                                            <button class="applybtn" @click="onApply(item)">Apply</button>
                                            </li>
                                            </ul>
                                            </div>
                                        
                                               
                                   

                                                
                                        </div>

                                                

                                                </div>
                                        

                                            </div>



                                            </div>


                                              
                                        </div>
                                    </div>
                                      
                                  
                                </div>
                            </div>


                             

                                    </div>
                                </div>
                            </div>

                            <div v-show="isCalendarView">
                                <CalendarView :availabledata="availability"></CalendarView>
                            </div>

                                
                            </div>
                            <div class="">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2"> Want to add time before
                                        or after your events? </label>
                                    <div class="mb-4 text-gray-500">Give yourself some buffer time to prepare for or
                                        wrap up from booked Calendly events.</div>
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" class="cursor-pointer" name="date_range" v-model="step2Data.isCheckBeforeEvent" @click="beforeEvent()" :checked="step2Data.isCheckBeforeEvent==true">
                                        <div class="ml-4">Before event</div>
                                        <div class="relative ml-2 flex-1">
                                            <select name="beforeevent" v-model="step2Data.beforeevent" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline" :disabled="step2Data.isCheckBeforeEvent== false">
                                                  <option value='null' class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :selected="step2Data.beforeevent==null">Select</option>
                                                <option value="5 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :selected="step2Data.beforeevent=='5 min'">5 min</option>
                                                <option value="10 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :selected="step2Data.beforeevent=='10 min'">10 min</option>
                                                <option value="15 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :selected="step2Data.beforeevent=='15 min'">15 min</option>
                                                <option value="20 min" class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline" :selected="step2Data.beforeevent=='20 min'">20 min</option>
                                            </select>
                                            <!--<button @click="beforeEventDropdown = !beforeEventDropdown"
                                                class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                <span>15 min</span>
                                                <svg fill="currentColor" viewBox="0 0 20 20"
                                                    :class="{'rotate-180': beforeEventDropdown, 'rotate-0': !beforeEventDropdown}"
                                                    class="inline w-4 h-4 transition-transform duration-200 transform">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>-->
                                            <!--<transition name="fade">
                                                <div v-show="beforeEventDropdown" class="absolute w-full z-10">
                                                    <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                        <div class="grid grid-cols-1 gap-1">

                                                            <select class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <option value="">5 min </option>
                                                                <option value="">5 min </option>
                                                                <option value="">5 min </option>
                                                                <option value="">5 min </option>
                                                            </select>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#" >
                                                                <div>5 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#">
                                                                <div>10 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#">
                                                                <div>15 min</div>
                                                            </a>
                                                            <a class="rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                                                                href="#">
                                                                <div>20 min</div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </transition>-->
                                        </div>
                                    </div>

                                     <small class="text-red-500 mx-2" v-show="validationErrorMessages.beforeevent !== null">{{ validationErrorMessages.beforeevent }}</small>
                                </div>
                            </div>
                            </div>
                        <div v-show="step2" class="w-full flex justify-center md:justify-end items-center p-4 border-t">
                            <div>
                                <button class="text-gray-600">Cancel</button>
                                <button class="rounded-2xl ml-4 bg-blue-500 font-bold px-3 py-1 text-white" @click.stop="updateStep2()" :disabled="step2Processing">
                                     <svg v-show="step2Processing" class="animate-spin mr-2 h-4 w-4 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Save & Close

                                   </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        VueEditor
    } from "vue2-editor";
    import moment from "moment";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import Navbar from '../../components/Navbar.vue'
    import CalendarView from '../../components/CalendarView.vue'
    import VueTimepicker from 'vue2-timepicker'
    import 'vue2-timepicker/dist/VueTimepicker.css'

    export default {
        data() {
            return {
                dateRange: null,
                isListView:true,
                isCalendarView:false,
                authDetails:{},
                step1Data: {
                    id: null,
                    name: "30 min Meeting",
                    description: null,
                    link: null,
                    color: '#c94f16',
                },
                step2Data:{
                    id:null,
                    user_id:null,
                    event_id:null,
                    checkboxval:"",
                    beforeevent:"",
                    duration:"",
                    isCheckBeforeEvent:false,
                    noofdays:{

                        type:'',
                        dayscount:'',
                    },
                    //dateRange:[new Date(2019, 7, 1), new Date(2019, 7, 30)],


                    

                },

                step1Processing: false,
                step2Processing: false,
               
                step1: false,
                step2: false,
                customToolbar: [
                    ["bold", "italic", "underline"],
                    [{
                        list: "ordered"
                    }, {
                        list: "bullet"
                    }],
                    ["link"]
                ],
                eventColors: ['#c94f16', '#c9a316', '#70c916', '#16c3c9', '#1658c9', '#4916c9', '#8e16c9', '#c91685'],
                dateRangeDropdwon: false,
                durationDropdown: false,
                beforeEventDropdown: false,
                isDeleteConfirmed: false,
                lastEditedDate: null,
                isPageLoading: true,
                validationErrorMessages: {
                    name: null,
                    description: null,
                    link: null,
                    checkboxval: null,
                    beforeevent:null,
                    duration:null,
                },
            events: null,
            isCheck:false,
            show:false,
            showdiv:false,
            showmaindiv:true,
            events:[],
                availability: {
                sunday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                monday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                tuesday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                wednesday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                thursday: [
                    {
                        open: '',
                        close: '',
                    }
                ],
                friday: [
                    {
                        open: '',
                        close: '',
                    },
                ],
                saturday: [
                    {
                        open: '',
                        close: '',
                    }
                ]
            },
            selectedValues: { 
            sunday:[

               { 
                show:false,
                isCheck:false,
                selectedvalue:
                [
                    "sunday"
                ],

                }
                    
            ],
              monday:[

              {
                
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "monday"
                ] 
                }
            ],
            tuesday:[
                {
                
                show:false,
                isCheck:false,
                selectedvalue:
                [
                    "tuesday"
                ] 
                }
            ],
            wednesday:[
               {
                
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "wednesday"
                ] 
                }
            ],
            thursday:[
               {
                
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "thursday"
                ] 
                }
            ],
            friday:[
                {
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "friday"
                ] 
                }
            ],
            
            saturday:[
                {
                 show:false,
                 isCheck:false,
                selectedvalue:
                [
                    "saturday"
                ] 
                }
            ]
            },
             options: [
                {
                    text:'SUN',
                    value:'sunday',
                },
                {
                    text:'MON',
                    value:'monday',
                },
                {
                    text:'TUE',
                    value:'tuesday',
                },
                {
                    text:'WED',
                    value:'wednesday',
                },
                {
                    text:'THU',
                    value:'thursday',
                },
                {
                    text:'FRI',
                    value:'friday',
                },
                {
                    text:'SAT',
                    value:'saturday',
                }
            ],
        }
        },
        components: {
            VueEditor,
            DatePicker,
            Navbar,
            VueTimepicker,
            CalendarView
        },
        methods: {
            updateStep1() {
                this.step1Processing = true
                //step 1. validations
                if(this.step1Data.name === "") {
                    this.validationErrorMessages.name = "Event name required";
                } else {
                    this.validationErrorMessages.name = null;
                }
                if(this.step1Data.description === "" || this.step1Data.description === null) {
                    this.validationErrorMessages.description = "Event description required";
                } else {
                    this.validationErrorMessages.description = null;
                }
                if(this.step1Data.link === "" || this.step1Data.link === null) {
                    this.validationErrorMessages.link = "Event link required";
                } else {
                    this.validationErrorMessages.link = null;
                }

                this.$axios.post(`/api/events/${this.step1Data.id}`, this.step1Data).then(res => {
                    this.step1Data.id = res.data.data.id
                    this.step1Processing = false
                    this.step1 = false
                    this.$dtoast.pop({
                        preset: "success",
                        heading: `Success!`,
                        content: `Event updated!`,
                    });
                }).catch(() => {
                    this.step1Processing = false
                    this.$dtoast.pop({
                        preset: "error",
                        heading: `Error!`,
                        content: `Something when wrong, please try again`,
                    });
                })

            },

              updateStep2() {
               // alert();
                 this.step2Processing = true
                //step 2. validations

                // console.log(this.step2Data.checkboxval);
                if(this.step2Data.checkboxval === "") {
                    //console.log('1st');
                    this.validationErrorMessages.checkboxval = "Check atleast one daterange checkbox";
                    this.step2Processing = false
                }else if(this.step2Data.checkboxval === "no_of_days" && (this.step2Data.noofdays.dayscount=='' || this.step2Data.noofdays.type=='')) {
                    this.validationErrorMessages.checkboxval = "No of days and days category is required";
                    //console.log('2nd');
                    this.step2Processing = false
                }else if(this.step2Data.checkboxval === "daterange" && this.dateRange==null){

                    this.validationErrorMessages.checkboxval = "Date Range is required";
                    //console.log('3rd');
                    this.step2Processing = false

                }else{
                    this.validationErrorMessages.checkboxval = null;
                }
                if(this.step2Data.duration === ""){

                    this.validationErrorMessages.duration = "Duration is required";
                     this.step2Processing = false

                }else{
                        
                        this.validationErrorMessages.duration=null;                    
                }

                 if(this.step2Data.isCheckBeforeEvent === true && this.step2Data.beforeevent==null){

                    this.validationErrorMessages.beforeevent = "Before event is required";
                     this.step2Processing = false

                }else{
                    this.validationErrorMessages.beforeevent = null;
                }

                //console.log(this.validationErrorMessages);
                // else {
                //     this.validationErrorMessages.name = null;
                // }
                // if(this.step1Data.description === "" || this.step1Data.description === null) {
                //     this.validationErrorMessages.description = "Event description required";
                // } else {
                //     this.validationErrorMessages.description = null;
                // }
                // if(this.step1Data.link === "" || this.step1Data.link === null) {
                //     this.validationErrorMessages.link = "Event link required";
                // } else {
                //     this.validationErrorMessages.link = null;
                // }

                var postdata={

                    step2:this.step2Data,
                    availabledates:this.availability,
                    dateRange:this.dateRange,
                };

                if(this.step2Processing==true){

                    this.$axios.post(`/api/eventschedule`, postdata).then(res => {

                    // console.log(res);
                    this.step2Data.id = res.data.data.id
                    this.step2Processing = false
                    this.step2 = false

                    if(this.step2Data.checkboxval === "daterange"){
                        this.step2Data.noofdays.type="";
                        this.step2Data.noofdays.dayscount="";

                    }else{
                        this.dateRange = null;

                    }
                    this.$dtoast.pop({
                        preset: "success",
                        heading: `Success!`,
                        content: `Event Schedule updated!`,
                     });
                }).catch(() => {
                    // console.log('catch');
                    this.step2Processing = false
                    this.$dtoast.pop({
                        preset: "error",
                        heading: `Error!`,
                        content: `Something when wrong, please try again`,
                    });
                })

                }

                

            },


            addSundayvalue(index,intervalindex) {

            //console.log(index+'--'+intervalindex);
            // let item=index;
             // console.log(index);

            //console.log(this.availability.item);
            const prevData=this.availability[index].slice(-1)[0];

            // console.log(prevData);
            let prev_start_time="";
            let prev_end_time="";

            if(!prevData){
                    prev_start_time="09:00";
                    prev_end_time="11:00";

            }else{

                    prev_start_time=prevData['open'];
                    prev_end_time=prevData['close'];
            }


            this.availability[index].push({
                open: prev_start_time,
                close: prev_end_time,

            });
        },
          removeSundayvalue(index,intervalindex) {

            //console.log(this.availability[index]);
            this.availability[index].splice(intervalindex, 1);
            this.isCheck = false;
        },
         check(index,event) {

            this.selectedValues[index][0].isCheck = !this.selectedValues[index][0].isCheck;

            if(event.target.checked){

                if(!this.availability[index] || this.availability[index].length<1)
                {
                        this.availability[index].push({
                        open: "09:00",
                        close: "11:00",

                        });
                }


            }else{

                this.availability[index].splice(0, this.availability[index].length);
            }

        },
          showDropdown(index,event) {

        this.selectedValues[index][0].show = !this.selectedValues[index][0].show;
        // console.log(this.selectedValues[index]);

        },
          onCheck(val,event,item) {

            var selectedindex;

            if(event.target.checked){
                //console.log('checked');
                 this.selectedValues[item][0].selectedvalue.push(val);


            }else{
                 //console.log('unchecked');
                this.selectedValues[item][0].selectedvalue.splice(this.selectedValues[item][0].selectedvalue.indexOf(val), 1);

            }
        // console.log(this.selectedValues[item]);
        },
          onApply(indexval){

            //console.log(indexval);
             //console.log(this.availableDates);
            this.selectedValues[indexval][0].show = false;


           this.selectedValues[indexval][0].selectedvalue.forEach((value,index )=>{

            if(indexval!=value){

                this.availability[value]=this.availability[indexval].slice();
            }


           });

       },

            
            goToDashboard() {
                this.$router.push('/');
            },
            deleteConfirmation() {
                if (this.isDeleteConfirmed) {
                    this.isDeleteConfirmed = false;
                } else {
                    this.isDeleteConfirmed = true;
                }
            },
            deleteEvent() {
                this.$axios.delete(`/api/events/${this.step1Data.id}`)
                    .then(() => {
                        this.$dtoast.pop({
                            preset: "success",
                            heading: `Success!`,
                            content: `Event deleted!`,
                        });
                        this.$router.push('/');
                    }).catch(() => {
                        this.$dtoast.pop({
                            preset: "error",
                            heading: `Error!`,
                            content: `Something when wrong, please try again!`,
                        });
                    });
            },
            beforeEvent(){

               this.step2Data.isCheckBeforeEvent=!this.step2Data.isCheckBeforeEvent;
               if(this.step2Data.isCheckBeforeEvent==false){
                this.step2Data.beforeevent = null;
               }

               // console.log(this.step2Data.isCheckBeforeEvent);

            },
            checkvalue(event){

                //alert(event.target.value);
                this.step2Data.checkboxval = event.target.value;
            },
            changeView(viewType){

                if(viewType=='list'){
                    this.isCalendarView = false;
                    this.isListView = true;
                }
                if(viewType=='calendar'){
                    this.isCalendarView = true;
                    this.isListView = false;
                }
            }
        },
        mounted() {

        
            let authdetails =  localStorage.getItem('auth-user');
            this.authDetails = JSON.parse(authdetails);
            // console.log(JSON.parse(this.authDetails).username);

        // var x = 30; //minutes interval
        // var times = []; // time array
        // var tt = 0; // start time
        // var ap = ['AM', 'PM']; // AM-PM

        // //loop to increment the time and push results in array
        // for (var i=0;tt<24*60; i++) {
        // var hh = Math.floor(tt/60); // getting hours of day in 0-24 format
        // var mm = (tt%60); // getting minutes of the hour in 0-55 format
        // times[i] = ("0" + (hh % 12)).slice(-2) + ':' + ("0" + mm).slice(-2) + ap[Math.floor(hh/12)];

        //  // pushing data in array in [00:00 - 12:00 AM/PM format]
        // tt = tt + x;
        // }

        // console.log("timeinterval",times);

             
            this.isPageLoading = true;
            this.$axios.get(`/api/events/${this.$route.params.id}`)
                .then(res => {

                    // console.log(res.data);
                    this.step1Data.id = res.data.data.id;
                    this.step1Data.name = res.data.data.name;
                    this.step1Data.description = res.data.data.description;
                    this.step1Data.link = res.data.data.link;
                    this.step1Data.color = res.data.data.color;
                    this.lastEditedDate = res.data.data.updated_at;
                    this.isPageLoading = false;

                    this.step2Data.event_id = res.data.data.id;
                     this.step2Data.user_id = res.data.data.user_id;

if(res.data.data.eventschedule!=null){

     this.step2Data.id = res.data.data.eventschedule.id;
                      
                      this.step2Data.checkboxval = res.data.data.eventschedule.checked_type;
                      this.step2Data.beforeevent = res.data.data.eventschedule.before_event;
                      // console.log('beforeevent');
                      // console.log(this.step2Data.beforeevent);

                      if(this.step2Data.beforeevent!=null){

                        this.step2Data.isCheckBeforeEvent = true;
                      }

                      //alert();
                      this.step2Data.duration = res.data.data.eventschedule.duration;
                     

                      if(res.data.data.eventschedule.checked_type=='daterange'){
                        //this.dateRange = JSON.parse(res.data.data.eventschedule.date_range);
                        var daterange =JSON.parse( res.data.data.eventschedule.date_range);
                        // console.log('fullyear');
                        // console.log(daterange[0]);
                        var start_date = new Date(daterange[0]);
                        var start_date_year = start_date.getFullYear();
                        var start_date_month = start_date.getMonth();
                        var start_date_day = start_date.getDate();

                        var end_date = new Date(daterange[1]);
                        var end_date_year = end_date.getFullYear();
                        var end_date_month = end_date.getMonth();
                        var end_date_day = end_date.getDate();
                       // console.log(dateaval.getDate());
                       this.dateRange = [new Date(start_date_year,start_date_month,start_date_day),new Date(end_date_year,end_date_month,end_date_day)];
                    }else{
                        this.step2Data.noofdays = JSON.parse(res.data.data.eventschedule.date_range);
                    }
                      
                      
                      this.availability = JSON.parse(res.data.data.eventschedule.availabledates);


}

if(res.data.data.defaultavailability!=null){

    this.availability = JSON.parse(res.data.data.defaultavailability);
}
                       
                      // console.log(this.step2Data.dateRange);

                }).catch(() => {
                    this.$dtoast.pop({
                        preset: "error",
                        heading: `Error!`,
                        content: `Something when wrong, redirecting to home...`,
                    });
                    this.isPageLoading = false;
                    window.setTimeout(() => {
                        this.$router.push('/');
                    }, 2000);
                });
        },
    }

</script>

<style scoped>
    .mx-datepicker-range {
        width: 100% !important;
    }
	.blue-circle-1{
		animation-delay: 0.1s;
	}
	.blue-circle-2{
		animation-delay: 0.3s;
	}
	.blue-circle-3{
		animation-delay: 0.5s;
	}
</style>
