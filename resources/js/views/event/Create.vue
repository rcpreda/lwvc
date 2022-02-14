<template>
    <div>
        <Navbar/>
        <div class="antialiased pt-5 pb-28">
            <div class="w-full text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800">
                <div class="max-w-screen-lg mb-5 px-4 mx-auto md:px-6 lg:px-8">
                    <button @click="goToDashboard" type="button" class="flex gap-1 border items-center border-blue-500 text-blue-500 py-1 px-3 rounded-3xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>Back</span>
                    </button>
                </div>
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
                                    <p class="text-xs text-gray-500">{{ step1Data.name }}, Video call</p>
                                </div>
                            </div>
                            <div class="hidden md:flex" v-show="step1">
                                <button @click="step1=!step1" class="text-gray-600 mr-3">Cancel</button>
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
                                <button @click.stop="saveStep2()" :disabled="step2Processing" class="rounded-2xl ml-4 bg-blue-500 px-3 py-1 font-bold text-white">Save & Close</button>
                            </div>
                        </div>
                        <div v-show="step2">
                            <div class="border-b">
                                <div class="mb-4 max-w-lg p-4">
                                    <label class="block text-gray-700 text-sm font-medium mb-2" for="username"> Date Range </label>
                                    <div class="mb-4 text-gray-500">Set a range of dates when you can accept meetings.</div>
                                    <div class="flex flex-col md:flex-row md:items-center mb-4">
                                        <div class="flex flex-1 items-center">
                                            <input @click="onRangeChange('recurrent')" type="radio" class="cursor-pointer" name="date_range">
                                            <input placeholder="30"
                                            v-model="recurrentMinute"
                                            class="appearance-none ml-4 w-16 border rounded-md h-10 px-3 text-gray-700 leading-tight focus:border-blue-400 focus:outline-none focus:shadow-outline" type="text" required/>
                                            <div class="relative ml-2 flex-1">
                                                <button @click="dateRangeDropdwon = !dateRangeDropdwon" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                    <span>{{ recurrentType }}</span>
                                                    <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': dateRangeDropdwon, 'rotate-0': !dateRangeDropdwon}" class="inline w-4 h-4 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                </button>
                                                <transition name="fade">
                                                    <div v-show="dateRangeDropdwon" class="absolute w-full z-10">
                                                        <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                            <div class="grid grid-cols-1 gap-1">
                                                                <div @click="changeRecurrentType('calendar days')" class="rounded-lg bg-transparent p-2 cursor-pointer hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                    <div class="text-gray-800 rounded-lg">
                                                                        <div>calendar days</div>
                                                                        <div class="text-gray-400 text-xs mt-2">Counts every day on the calendar including days you're unavailable</div>
                                                                    </div>
                                                                </div>
                                                                <div @click="changeRecurrentType('business days')"  class="rounded-lg bg-transparent p-2 cursor-pointer hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                    <div class="text-gray-800 rounded-lg">
                                                                        <div>business days</div>
                                                                        <div class="text-gray-400 text-xs mt-2">Excludes weekends and only counts Mon - Fri</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </transition>
                                            </div>
                                        </div>
                                        <div class="ml-2 text-right">into the future</div>
                                    </div>
                                    <div class="flex items-center">
                                        <input @click="onRangeChange('date range')" type="radio" class="cursor-pointer" name="date_range">
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
                                                <span>{{ step2Data.duration }} min</span>
                                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': durationDropdown, 'rotate-0': !durationDropdown}" class="inline w-4 h-4 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                            <transition name="fade">
                                                <div v-show="durationDropdown" class="absolute w-full z-10">
                                                    <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                        <div class="grid grid-cols-1 gap-1">
                                                            <div @click="changeDuration(15)" class="cursor-pointer rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>15 min</div>
                                                            </div>
                                                            <div @click="changeDuration(30)" class="cursor-pointer rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>30 min</div>
                                                            </div>
                                                            <div @click="changeDuration(45)" class="cursor-pointer rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>45 min</div>
                                                            </div>
                                                            <div @click="changeDuration(60)" class="cursor-pointer rounded-md p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>60 min</div>
                                                            </div>
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
                                                <!-- Sunday -->
                                                <tr>
                                                    <td class="px-4 py-4 align-top">
                                                        <label class="inline-flex items-center mt-3">
                                                            <input type="checkbox"
                                                                class="cursor-pointer"
                                                                v-model="startEndWeekClock.sun.status"
                                                                @click="setCheckBox(startEndWeekClock.sun)"/>
                                                                <span class="ml-3 text-gray-700 font-bold">SUN</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-4" v-if="startEndWeekClock.sun.data.length > 0">
                                                        <div class="flex items-center gap-3 px-2 py-1" v-for="(sun, index) in startEndWeekClock.sun.data" :key="index">
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.sun.data[index].start" />
                                                            </div>
                                                            -
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.sun.data[index].end" />
                                                            </div>
                                                            <button @click="deleteStartEndWeekClock(startEndWeekClock.sun, index)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 align-middle" v-else>
                                                        Unavailable
                                                    </td>
                                                    <td class="px-4 py-4 align-top">
                                                        <div class="flex items-center gap-3 px-2 py-1">
                                                            <button @click="addStartEndWeekClock(startEndWeekClock.sun)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                            <div class="relative">
                                                                <button @click="setSelectedDay('sun')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <div v-show="selectedDay === 'sun'"
                                                                    class="absolute left-0 pt-2 mt-2 bg-white rounded-md shadow-md overflow-scroll w-40 z-20">
                                                                    <small class="text-xs px-4 py-2">COPY TIMES
                                                                        TO...</small>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3 ">
                                                                        <label for="sundayCheckbox">
                                                                            Sunday
                                                                        </label>
                                                                        <input id="sundayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sun" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="mondayCheckbox">
                                                                            Monday
                                                                        </label>
                                                                        <input id="mondayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.mon" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="tuesdayCheckbox">
                                                                            Tuesday
                                                                        </label>
                                                                        <input id="tuesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.tue" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="wednesdayCheckbox">
                                                                            Wednesday
                                                                        </label>
                                                                        <input id="wednesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.wed" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="thursdayCheckbox">
                                                                            Thursday
                                                                        </label>
                                                                        <input id="thursdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.thu" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="fridayCheckbox">
                                                                            Friday
                                                                        </label>
                                                                        <input id="fridayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.fri" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="saturdayCheckbox">
                                                                            Saturday
                                                                        </label>
                                                                        <input id="saturdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sat" />
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center justify-center px-3 mt-5">
                                                                        <button @click="applyDuplicateTime('sun')"
                                                                            class="rounded-2xl ml-4 bg-blue-700 px-3 py-1 text-white w-full">Apply</button>
                                                                    </div>
                                                                </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Monday -->
                                                <tr>
                                                    <td class="px-4 py-4 align-top">
                                                        <label class="inline-flex items-center mt-3">
                                                            <input type="checkbox"
                                                                class="cursor-pointer"
                                                                v-model="startEndWeekClock.mon.status"
                                                                v-on:click="setCheckBox(startEndWeekClock.mon)"/>
                                                                <span class="ml-3 text-gray-700 font-bold">MON</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-4" v-show="startEndWeekClock.mon.data.length > 0">
                                                        <div class="flex items-center gap-3 px-2 py-1" v-for="(mon, index) in startEndWeekClock.mon.data" :key="index">
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.mon.data[index].start" />
                                                            </div>
                                                            -
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.mon.data[index].end" />

                                                            </div>
                                                            <button @click="deleteStartEndWeekClock(startEndWeekClock.mon, index)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 align-middle" v-show="startEndWeekClock.mon.data.length < 1">
                                                        Unavailable
                                                    </td>
                                                    <td class="px-4 py-4 align-top">
                                                        <div class="flex items-center gap-3 px-2 py-1">
                                                            <button @click="addStartEndWeekClock(startEndWeekClock.mon)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                            <div class="relative">
                                                                <button @click="setSelectedDay('mon')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <div v-show="selectedDay === 'mon'"
                                                                    class="absolute left-0 pt-2 mt-2 bg-white rounded-md shadow-md overflow-scroll w-40 z-20">
                                                                    <small class="text-xs px-4 py-2">COPY TIMES
                                                                        TO...</small>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="sundayCheckbox">
                                                                            Sunday
                                                                        </label>
                                                                        <input id="sundayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sun" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="mondayCheckbox">
                                                                            Monday
                                                                        </label>
                                                                        <input id="mondayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.mon" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="tuesdayCheckbox">
                                                                            Tuesday
                                                                        </label>
                                                                        <input id="tuesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.tue" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="wednesdayCheckbox">
                                                                            Wednesday
                                                                        </label>
                                                                        <input id="wednesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.wed" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="thursdayCheckbox">
                                                                            Thursday
                                                                        </label>
                                                                        <input id="thursdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.thu" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="fridayCheckbox">
                                                                            Friday
                                                                        </label>
                                                                        <input id="fridayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.fri" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="saturdayCheckbox">
                                                                            Saturday
                                                                        </label>
                                                                        <input id="saturdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sat" />
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center justify-center px-3 mt-5">
                                                                        <button @click="applyDuplicateTime('mon')"
                                                                            class="rounded-2xl ml-4 bg-blue-700 px-3 py-1 text-white w-full">Apply</button>
                                                                    </div>
                                                                </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Tuesday -->
                                                <tr>
                                                    <td class="px-4 py-4 align-top">
                                                        <label class="inline-flex items-center mt-3">
                                                            <input type="checkbox"
                                                                class="cursor-pointer"
                                                                v-model="startEndWeekClock.tue.status"
                                                                v-on:click="setCheckBox(startEndWeekClock.tue)"/>
                                                                <span class="ml-3 text-gray-700 font-bold">TUE</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-4" v-show="startEndWeekClock.tue.data.length > 0">
                                                        <div class="flex items-center gap-3 px-2 py-1" v-for="(tue, index) in startEndWeekClock.tue.data" :key="index">
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.tue.data[index].start" />
                                                            </div>
                                                            -
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.tue.data[index].end" />

                                                            </div>
                                                            <button @click="deleteStartEndWeekClock(startEndWeekClock.tue, index)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 align-middle" v-show="startEndWeekClock.tue.data.length < 1">
                                                        Unavailable
                                                    </td>
                                                    <td class="px-4 py-4 align-top">
                                                        <div class="flex items-center gap-3 px-2 py-1">
                                                            <button @click="addStartEndWeekClock(startEndWeekClock.tue)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                            <div class="relative">
                                                                <button @click="setSelectedDay('tue')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <div v-show="selectedDay === 'tue'"
                                                                    class="absolute left-0 pt-2 mt-2 bg-white rounded-md shadow-md overflow-scroll w-40 z-20">
                                                                    <small class="text-xs px-4 py-2">COPY TIMES
                                                                        TO...</small>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="sundayCheckbox">
                                                                            Sunday
                                                                        </label>
                                                                        <input id="sundayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sun" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="mondayCheckbox">
                                                                            Monday
                                                                        </label>
                                                                        <input id="mondayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.mon" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="tuesdayCheckbox">
                                                                            Tuesday
                                                                        </label>
                                                                        <input id="tuesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.tue" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="wednesdayCheckbox">
                                                                            Wednesday
                                                                        </label>
                                                                        <input id="wednesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.wed" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="thursdayCheckbox">
                                                                            Thursday
                                                                        </label>
                                                                        <input id="thursdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.thu" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="fridayCheckbox">
                                                                            Friday
                                                                        </label>
                                                                        <input id="fridayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.fri" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="saturdayCheckbox">
                                                                            Saturday
                                                                        </label>
                                                                        <input id="saturdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sat" />
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center justify-center px-3 mt-5">
                                                                        <button @click="applyDuplicateTime('tue')"
                                                                            class="rounded-2xl ml-4 bg-blue-700 px-3 py-1 text-white w-full">Apply</button>
                                                                    </div>
                                                                </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Wednesday -->
                                                <tr>
                                                    <td class="px-4 py-4 align-top">
                                                        <label class="inline-flex items-center mt-3">
                                                            <input type="checkbox"
                                                                class="cursor-pointer"
                                                                v-model="startEndWeekClock.wed.status"
                                                                v-on:click="setCheckBox(startEndWeekClock.wed)"/>
                                                                <span class="ml-3 text-gray-700 font-bold">WED</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-4" v-show="startEndWeekClock.wed.data.length > 0">
                                                        <div class="flex items-center gap-3 px-2 py-1" v-for="(wed, index) in startEndWeekClock.wed.data" :key="index">
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.wed.data[index].start" />
                                                            </div>
                                                            -
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.wed.data[index].end" />

                                                            </div>
                                                            <button @click="deleteStartEndWeekClock(startEndWeekClock.wed, index)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 align-middle" v-show="startEndWeekClock.wed.data.length < 1">
                                                        Unavailable
                                                    </td>
                                                    <td class="px-4 py-4 align-top">
                                                        <div class="flex items-center gap-3 px-2 py-1">
                                                            <button @click="addStartEndWeekClock(startEndWeekClock.wed)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                            <div class="relative">
                                                                <button @click="setSelectedDay('wed')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <div v-show="selectedDay === 'wed'"
                                                                    class="absolute left-0 pt-2 mt-2 bg-white rounded-md shadow-md overflow-scroll w-40 z-20">
                                                                    <small class="text-xs px-4 py-2">COPY TIMES
                                                                        TO...</small>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="sundayCheckbox">
                                                                            Sunday
                                                                        </label>
                                                                        <input id="sundayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sun" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="mondayCheckbox">
                                                                            Monday
                                                                        </label>
                                                                        <input id="mondayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.mon" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="tuesdayCheckbox">
                                                                            Tuesday
                                                                        </label>
                                                                        <input id="tuesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.tue" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="wednesdayCheckbox">
                                                                            Wednesday
                                                                        </label>
                                                                        <input id="wednesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.wed" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="thursdayCheckbox">
                                                                            Thursday
                                                                        </label>
                                                                        <input id="thursdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.thu" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="fridayCheckbox">
                                                                            Friday
                                                                        </label>
                                                                        <input id="fridayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.fri" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="saturdayCheckbox">
                                                                            Saturday
                                                                        </label>
                                                                        <input id="saturdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sat" />
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center justify-center px-3 mt-5">
                                                                        <button @click="applyDuplicateTime('wed')"
                                                                            class="rounded-2xl ml-4 bg-blue-700 px-3 py-1 text-white w-full">Apply</button>
                                                                    </div>
                                                                </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Thursday -->
                                                <tr>
                                                    <td class="px-4 py-4 align-top">
                                                        <label class="inline-flex items-center mt-3">
                                                            <input type="checkbox"
                                                                class="cursor-pointer"
                                                                v-model="startEndWeekClock.thu.status"
                                                                v-on:click="setCheckBox(startEndWeekClock.thu)"/>
                                                                <span class="ml-3 text-gray-700 font-bold">THU</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-4" v-show="startEndWeekClock.thu.data.length > 0">
                                                        <div class="flex items-center gap-3 px-2 py-1" v-for="(thu, index) in startEndWeekClock.thu.data" :key="index">
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.thu.data[index].start" />
                                                            </div>
                                                            -
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.thu.data[index].end" />

                                                            </div>
                                                            <button @click="deleteStartEndWeekClock(startEndWeekClock.thu, index)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 align-middle" v-show="startEndWeekClock.thu.data.length < 1">
                                                        Unavailable
                                                    </td>
                                                    <td class="px-4 py-4 align-top">
                                                        <div class="flex items-center gap-3 px-2 py-1">
                                                            <button @click="addStartEndWeekClock(startEndWeekClock.thu)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                            <div class="relative">
                                                                <button @click="setSelectedDay('thu')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <div v-show="selectedDay === 'thu'"
                                                                    class="absolute left-0 pt-2 mt-2 bg-white rounded-md shadow-md overflow-scroll w-40 z-20">
                                                                    <small class="text-xs px-4 py-2">COPY TIMES
                                                                        TO...</small>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="sundayCheckbox">
                                                                            Sunday
                                                                        </label>
                                                                        <input id="sundayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sun" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="mondayCheckbox">
                                                                            Monday
                                                                        </label>
                                                                        <input id="mondayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.mon" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="tuesdayCheckbox">
                                                                            Tuesday
                                                                        </label>
                                                                        <input id="tuesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.tue" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="wednesdayCheckbox">
                                                                            Wednesday
                                                                        </label>
                                                                        <input id="wednesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.wed" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="thursdayCheckbox">
                                                                            Thursday
                                                                        </label>
                                                                        <input id="thursdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.thu" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="fridayCheckbox">
                                                                            Friday
                                                                        </label>
                                                                        <input id="fridayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.fri" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="saturdayCheckbox">
                                                                            Saturday
                                                                        </label>
                                                                        <input id="saturdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sat" />
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center justify-center px-3 mt-5">
                                                                        <button @click="applyDuplicateTime('thu')"
                                                                            class="rounded-2xl ml-4 bg-blue-700 px-3 py-1 text-white w-full">Apply</button>
                                                                    </div>
                                                                </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Friday -->
                                                <tr>
                                                    <td class="px-4 py-4 align-top">
                                                        <label class="inline-flex items-center mt-3">
                                                            <input type="checkbox"
                                                                class="cursor-pointer"
                                                                v-model="startEndWeekClock.fri.status"
                                                                v-on:click="setCheckBox(startEndWeekClock.fri)"/>
                                                                <span class="ml-3 text-gray-700 font-bold">FRI</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-4" v-show="startEndWeekClock.fri.data.length > 0">
                                                        <div class="flex items-center gap-3 px-2 py-1" v-for="(fri, index) in startEndWeekClock.fri.data" :key="index">
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.fri.data[index].start" />
                                                            </div>
                                                            -
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.fri.data[index].end" />

                                                            </div>
                                                            <button @click="deleteStartEndWeekClock(startEndWeekClock.fri, index)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 align-middle" v-show="startEndWeekClock.fri.data.length < 1">
                                                        Unavailable
                                                    </td>
                                                    <td class="px-4 py-4 align-top">
                                                        <div class="flex items-center gap-3 px-2 py-1">
                                                            <button @click="addStartEndWeekClock(startEndWeekClock.fri)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                            <div class="relative">
                                                                <button @click="setSelectedDay('fri')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <div v-show="selectedDay === 'fri'"
                                                                    class="absolute left-0 pt-2 mt-2 bg-white rounded-md shadow-md overflow-scroll w-40 z-20">
                                                                    <small class="text-xs px-4 py-2">COPY TIMES
                                                                        TO...</small>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="sundayCheckbox">
                                                                            Sunday
                                                                        </label>
                                                                        <input id="sundayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sun" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="mondayCheckbox">
                                                                            Monday
                                                                        </label>
                                                                        <input id="mondayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.mon" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="tuesdayCheckbox">
                                                                            Tuesday
                                                                        </label>
                                                                        <input id="tuesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.tue" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="wednesdayCheckbox">
                                                                            Wednesday
                                                                        </label>
                                                                        <input id="wednesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.wed" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="thursdayCheckbox">
                                                                            Thursday
                                                                        </label>
                                                                        <input id="thursdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.thu" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="fridayCheckbox">
                                                                            Friday
                                                                        </label>
                                                                        <input id="fridayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.fri" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="saturdayCheckbox">
                                                                            Saturday
                                                                        </label>
                                                                        <input id="saturdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sat" />
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center justify-center px-3 mt-5">
                                                                        <button @click="applyDuplicateTime('fri')"
                                                                            class="rounded-2xl ml-4 bg-blue-700 px-3 py-1 text-white w-full">Apply</button>
                                                                    </div>
                                                                </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Saturday -->
                                                <tr>
                                                    <td class="px-4 py-4 align-top">
                                                        <label class="inline-flex items-center mt-3">
                                                            <input type="checkbox"
                                                                class="cursor-pointer"
                                                                v-model="startEndWeekClock.sat.status"
                                                                v-on:click="setCheckBox(startEndWeekClock.sat)"/>
                                                                <span class="ml-3 text-gray-700 font-bold">SAT</span>
                                                        </label>
                                                    </td>
                                                    <td class="px-4 py-4" v-show="startEndWeekClock.sat.data.length > 0">
                                                        <div class="flex items-center gap-3 px-2 py-1" v-for="(sat, index) in startEndWeekClock.sat.data" :key="index">
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.sat.data[index].start" />
                                                            </div>
                                                            -
                                                            <div class="relative">
                                                                <input
                                                                    class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"
                                                                    type="text"
                                                                    v-model="startEndWeekClock.sat.data[index].end" />

                                                            </div>
                                                            <button @click="deleteStartEndWeekClock(startEndWeekClock.sat, index)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-4 align-middle" v-show="startEndWeekClock.sat.data.length < 1">
                                                        Unavailable
                                                    </td>
                                                    <td class="px-4 py-4 align-top">
                                                        <div class="flex items-center gap-3 px-2 py-1">
                                                            <button @click="addStartEndWeekClock(startEndWeekClock.sat)">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                                </svg>
                                                            </button>
                                                            <div class="relative z-10">
                                                                <button @click="setSelectedDay('sat')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="h-8 w-8 p-1 hover:bg-gray-200 hover:cursor-pointer hover:rounded"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                                    </svg>
                                                                    <div v-show="selectedDay === 'sat'"
                                                                    class="absolute left-0 pt-2 mt-2 bg-white rounded-md shadow-md overflow-scroll w-40 z-20">
                                                                    <small class="text-xs px-4 py-2">COPY TIMES
                                                                        TO...</small>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="sundayCheckbox">
                                                                            Sunday
                                                                        </label>
                                                                        <input id="sundayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sun" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="mondayCheckbox">
                                                                            Monday
                                                                        </label>
                                                                        <input id="mondayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.mon" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="tuesdayCheckbox">
                                                                            Tuesday
                                                                        </label>
                                                                        <input id="tuesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.tue" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="wednesdayCheckbox">
                                                                            Wednesday
                                                                        </label>
                                                                        <input id="wednesdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.wed" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="thursdayCheckbox">
                                                                            Thursday
                                                                        </label>
                                                                        <input id="thursdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.thu" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="fridayCheckbox">
                                                                            Friday
                                                                        </label>
                                                                        <input id="fridayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.fri" />
                                                                    </div>
                                                                    <div
                                                                        class="flex justify-between items-center px-3 mt-3">
                                                                        <label for="saturdayCheckbox">
                                                                            Saturday
                                                                        </label>
                                                                        <input id="saturdayCheckbox" type="checkbox"
                                                                            class="cursor-pointer"
                                                                            v-model="duplicateTime.sat" />
                                                                    </div>
                                                                    <div
                                                                        class="flex items-center justify-center px-3 mt-5">
                                                                        <button @click="applyDuplicateTime('sat')"
                                                                            class="rounded-2xl ml-4 bg-blue-700 px-3 py-1 text-white w-full">Apply</button>
                                                                    </div>
                                                                </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
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
                                        <input type="checkbox" class="cursor-pointer" name="date_range" v-model="isBeforeEvent">
                                        <div class="ml-4">Before event</div>
                                        <div class="relative ml-2 flex-1">
                                            <button @click="beforeEventDropdown = !beforeEventDropdown" class="flex items-center justify-between border text-gray-700 w-full px-3 h-10 rounded-md focus:outline-none focus:shadow-outline">
                                                <span>{{ beforeEventTime }} min</span>
                                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': beforeEventDropdown, 'rotate-0': !beforeEventDropdown}" class="inline w-4 h-4 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                            <transition name="fade">
                                                <div v-show="beforeEventDropdown" class="absolute w-full z-10">
                                                    <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                                        <div class="grid grid-cols-1 gap-1">
                                                            <div @click="changeBeforeEventTime(5)" class="rounded-md p-2 hover:text-gray-900 cursor-pointer focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>5 min</div>
                                                            </div>
                                                            <div @click="changeBeforeEventTime(10)"  class="rounded-md p-2 hover:text-gray-900 cursor-pointer focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>10 min</div>
                                                            </div>
                                                            <div @click="changeBeforeEventTime(15)"  class="rounded-md p-2 hover:text-gray-900 cursor-pointer focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>15 min</div>
                                                            </div>
                                                            <div  @click="changeBeforeEventTime(20)" class="rounded-md p-2 hover:text-gray-900 cursor-pointer focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                                <div>20 min</div>
                                                            </div>
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
                                <button @click.stop="saveStep2()" :disabled="step2Processing" class="rounded-2xl ml-4 bg-blue-500 font-bold px-3 py-1 text-white">Save & Close</button>
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
                name: "30 min Meeting",
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
            beforeEventDropdown: false,
            validationErrorMessages: {
                name: null,
                description: null,
                link: null,
            },
            startEndWeekClock: {
                sun: {
                    status: false,
                    name: 'sunday',
                    data: []
                },
                mon: {
                    status: true,
                    name: 'monday',
                    data: [{
                        start: "09:00",
                        end: "17:00",
                    }]
                },
                tue: {
                    status: true,
                    name: 'tuesday',
                    data: [{
                        start: "09:00",
                        end: "17:00",
                    }]
                },
                wed: {
                    status: true,
                    name: 'wednesday',
                    data: [{
                        start: "09:00",
                        end: "17:00",
                    }]
                },
                thu: {
                    status: true,
                    name: 'thursday',
                    data: [{
                        start: "09:00",
                        end: "17:00",
                    }]
                },
                fri: {
                    status: true,
                    name: 'friday',
                    data: [{
                        start: "09:00",
                        end: "17:00",
                    }]
                },
                sat: {
                    status: false,
                    name: 'saturday',
                    data: []
                }
            },
            duplicateTime: {
                sun: false,
                mon: false,
                tue: false,
                wed: false,
                thu: false,
                fri: false,
                sat: false,
            },
            selectedDay: "",
            recurrentType: 'calendar day',
            step2Data: {
                dateRange:{
                    type: null,
                    data: {}
                },
                duration: 15,
                availableDates: [],
                beforeEvent: {}
            },
            step2Processing: false,
            recurrentMinute: null,
            isBeforeEvent: false,
            beforeEventTime: 15,
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

            //submit data
            this.$axios.post(`/api/events/${this.step1Data.id ? this.step1Data.id : ''}`, this.step1Data)
            .then(res => {
                this.step1Data.id = res.data.data.id
                this.step1Processing = false
                this.step1 = false
                this.$dtoast.pop({
                    preset: "success",
                    heading: `Success!`,
                    content: `Event added!`,
                });
                // redirect to event show after creating event
                this.$router.push(`/event/show/${this.step1Data.id}`);
            }).catch(() => {
                this.step1Processing = false;
                this.$dtoast.pop({
                    preset: "error",
                    heading: `Error!`,
                    content: `Something when wrong, please try again!`,
                });
            });
        },
        goToDashboard(){
            this.$router.push('/');
        },
        setSelectedDay(day) {
            if(this.selectedDay !== "") {
                this.selectedDay = "";
                this.duplicateTime[day] = false;
            } else {
                this.duplicateTime[day] = true;
                this.selectedDay = day;
            }
        },
        clearSelectedDay() {
            this.selectedDay = "";
        },
        deleteStartEndWeekClock(day, index) {
            var clock = day.data;
            if (index > -1) {
                clock.splice(index, 1);
            }
            if (day.status === true && day.data.length < 1) {
                day.status = false;
            }
        },
        addStartEndWeekClock(day) {
            var clock = day.data;
            if (day.status === false) {
                day.status = true;
            }
            clock.push({
                start: "09:00",
                end: "17:00"
            });
        },
        setCheckBox(day) {
            if(day.status === false) {
                day.data.push({
                    start: "09:00",
                    end: "17:00",
                });
                day.status = true;
            } else {
                day.data = [];
                day.status = false;
            }
        },
        applyDuplicateTime(day) {
            var baseTime =  this.startEndWeekClock[day].data; //[...this.startEndWeekClock[day].data];
            if(this.duplicateTime.sun === true) {
                this.startEndWeekClock.sun.data =  this.copyArray(baseTime);
                this.duplicateTime.sun = false;
                if (this.startEndWeekClock.sun.data.length < 0) {
                    this.startEndWeekClock.sun.status = false;
                }
            }
            if(this.duplicateTime.mon === true) {
                this.startEndWeekClock.mon.data =  this.copyArray(baseTime);
                this.duplicateTime.mon = false;
                if (this.startEndWeekClock.mon.data.length < 0) {
                    this.startEndWeekClock.mon.status = false;
                }
            }
            if(this.duplicateTime.tue === true) {
                this.startEndWeekClock.tue.data =  this.copyArray(baseTime);
                this.duplicateTime.tue = false;
                if (this.startEndWeekClock.tue.data.length < 0) {
                    this.startEndWeekClock.tue.status = false;
                }
            }
            if(this.duplicateTime.wed === true) {
                this.startEndWeekClock.wed.data =  this.copyArray(baseTime);
                this.duplicateTime.wed = false;
                if (this.startEndWeekClock.wed.data.length < 0) {
                    this.startEndWeekClock.wed.status = false;
                }
            }
            if(this.duplicateTime.thu === true) {
                this.startEndWeekClock.thu.data =  this.copyArray(baseTime);
                this.duplicateTime.thu = false;
                if (this.startEndWeekClock.thu.data.length < 0) {
                    this.startEndWeekClock.thu.status = false;
                }
            }
            if(this.duplicateTime.fri === true) {
                this.startEndWeekClock.fri.data =  this.copyArray(baseTime);
                this.duplicateTime.fri = false;
                if (this.startEndWeekClock.fri.data.length < 0) {
                    this.startEndWeekClock.fri.status = false;
                }
            }
            if(this.duplicateTime.sat === true) {
                this.startEndWeekClock.sat.data =  this.copyArray(baseTime);
                this.duplicateTime.sat = false;
                if (this.startEndWeekClock.sat.data.length < 0) {
                    this.startEndWeekClock.sat.status = false;
                }
            }
            this.selectedDay = "";
        },
        copyArray(o) {
            var output, v, key;
            output = Array.isArray(o) ? [] : {};
            for (key in o) {
                v = o[key];
                output[key] = typeof v === "object" ? this.copyArray(v) : v;
            }
            return output;
        },
        onRangeChange(type) {
            this.step2Data.dateRange.type = type;
        },
        saveStep2() {
            var availableDates = [];
            Object.entries(this.startEndWeekClock)
                .filter(([key, value]) => `${key}` [value] !== 'undefined')
                .map(([key, value]) => {
                    if (value.status) {
                        var startEndTime = [];
                        for (var i = 0; i < value.data.length; i++) {
                            var time = {
                                from: value.data[i].start,
                                to: value.data[i].end,
                            }
                            startEndTime.push(time);
                        }
                        var data = {
                            type: 'weekday',
                            weekday: value.name,
                            intervals: startEndTime,
                        }
                        availableDates.push(data);
                    }
                });
            // check recurrent or date range
            if(this.step2Data.dateRange.type === "recurrent" ) {
                this.step2Data.dateRange.data = {
                    from: this.recurrentMinute,
                    top: this.recurrentType
                }
            } else {
                this.step2Data.dateRange.data = {
                    from: this.dateRange[0],
                    to: this.dateRange[1]
                }
            }

            this.step2Data.availableDates = availableDates;
            this.step2Data.beforeEvent = this.beforeEventTime;

            console.log(this.step2Data);
        },
        changeRecurrentType(type) {
            this.recurrentType = type;
            this.dateRangeDropdwon = false;
        },
        changeBeforeEventTime(time) {
            this.beforeEventTime = time;
            this.beforeEventDropdown = false;
        },
        changeDuration(min) {
            this.step2Data.duration = min;
            this.durationDropdown = false;
        }
    }
}
</script>

<style scoped>
    .mx-datepicker-range {
        width: 100% !important;
    }
</style>
