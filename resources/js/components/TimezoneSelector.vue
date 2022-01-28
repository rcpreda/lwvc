<template>
    <div>
        <div class="relative w-full">
            <button @click="dropdown = !dropdown" class="flex items-center justify-between border text-gray-700 w-full hover:bg-gray-100 px-3 h-10 rounded-3xl focus:outline-none focus:shadow-outline">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                    </svg>
                    <span v-if="selectedTimezone" class="ml-2"> {{ selectedTimezone }} - {{ calculateLocalTime(selectedTimezone) }} </span>
                </div>
                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': dropdown, 'rotate-0': !dropdown}" class="inline w-4 h-4 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            <transition name="fade">
                <div v-show="dropdown" class="absolute w-full z-10">
                    <div class="bg-white rounded-md border shadow-lg">
                        <div class="py-2 px-4">
                            <input type="text" v-model="searchTimezone" v-on:keyup="search()" placeholder="Search Timezone" class="w-full rounded-3xl border-2 border-blue-500 py-1.5 px-4">
                        </div>
                        <div class="flex flex-col p-2 pt-0 mt-2 max-h-40 overflow-auto">
                            <a v-for="(timezone, i) in timezones" :key="i" @click="[ selectedTimezone = timezone, dropdown = false]" class="rounded-lg bg-transparent p-2  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-100 focus:bg-gray-200 focus:outline-none focus:shadow-outline"  :class="selectedTimezone == timezone ? 'bg-blue-600 text-white' : 'text-gray-800'" href="#">
                                <div class="rounded-lg flex justify-between">
                                    <div>{{timezone}}</div>
                                    <div>{{ calculateLocalTime(timezone) }}</div>
                                </div>
                            </a>                                                           
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import momentTimezone from "moment-timezone";

export default {
    data(){
        return {
            dropdown: false,
            timezones: null,
            selectedTimezone: null,
            searchTimezone: null
        }
    },
    methods: {
        momentTimezone() {
            return momentTimezone();
        },
        calculateLocalTime(timezone){
            const jun = momentTimezone(new Date());
            return jun.tz(timezone).format('h:mm a')
        },
        search(){
            this.timezones = momentTimezone.tz.names();
            if(this.searchTimezone.trim().length){
                let matchedTimezones = []
                const searchstring = this.searchTimezone
                for(let i=0; i<this.timezones.length; i++) {
                    if (this.timezones[i].match(new RegExp(searchstring, "i"))){
                        matchedTimezones.push(this.timezones[i])
                    }
                }
                this.timezones = matchedTimezones
            } else{
                this.timezones = momentTimezone.tz.names();
            }
        }
    },
    mounted(){
        this.timezones = momentTimezone.tz.names();
        this.selectedTimezone = momentTimezone.tz.guess()
    }
}
</script>