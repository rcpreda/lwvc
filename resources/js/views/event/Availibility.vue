<template>
    <div>
        <Navbar/>
        <div class="w-full bg-white border-t shadow-lg">
            <div class="flex gap-10 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                <span class="py-4 text-lg">Set your availability</span>
            </div>
        </div>
        <div class="antialiased pt-5 pb-28">
            <div class="w-full text-gray-700">
                <div class="max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                   <div class="text-sm w-full">Choose a schedule below to edit or create a new one that you can apply to your event types</div>
                   <div class="w-full mt-5 font-medium">SCHEDULE</div>
                   <div class="flex mt-5 gap-4">
                       <button class="px-3 py-2 bg-white border border-gray-300 rounded flex items-center gap-2 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Working hours
                        </button>
                        <button class="px-3 py-2 border border-gray-500 rounded-3xl flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New schedule
                        </button>
                   </div>
                </div>
            </div>
            <div class="w-full text-gray-700 mt-5">
                <div class="max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                    <div class="border bg-white rounded py-5">
                        <div class="flex justify-between px-5 pb-5">
                            <div>
                                <div class="font-medium">Working hours</div>
                                <div class="text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    default schedule
                                </div>
                            </div>
                            <div class="flex text-sm text-blue-500 gap-3">
                                <a href="#">Edit</a>
                                <a href="#">Default</a>
                                <a href="#">Delete</a>
                            </div>
                        </div>
                        <hr>
                        <div class="px-5 pt-5 w-full">
                            <div class="font-medium">Set your weekly hours</div>
                            <div class="mt-5 w-full md:w-6/12 divide-y">
                                <div v-for="(item, i) in Object.keys(availability)" :key="i" class="flex flex-col md:flex-row text-sm gap-4 py-4 w-full ">
                                    <div class="my-3 flex-1">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" class="cursor-pointer">
                                            <span class="font-medium">{{ item.toUpperCase() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-1 gap-2 justify-between">
                                        <div>
                                            <div v-for="(sch, i) in availability[item]" :key="i">
                                                <div class="flex gap-2 my-2 items-center">
                                                    <vue-timepicker v-model="sch.open" input-class="rounded outline-none" format="hh:mm a"></vue-timepicker>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    <vue-timepicker v-model="sch.close" input-class="rounded outline-none" format="hh:mm a"></vue-timepicker>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button @click="saveSchedule()" class="bg-blue-500 text-white px-5 py-1 rounded">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar.vue'
import VueTimepicker from 'vue2-timepicker'
import 'vue2-timepicker/dist/VueTimepicker.css'
export default {
    data(){
        return {
            events: null,
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
            }
        }
    },
    components: {
        Navbar,
        VueTimepicker
    },
    methods: {
        saveSchedule(){
            this.$axios.post('/api/schedule', {
                // availability: JSON.stringify(this.availability)
                availability: this.availability
            }).then((res) => {
                console.log(res)
            })
        }
    },
    mounted() {
        this.$axios.get(`/api/events`).then( res => {
            this.events = res.data.data
        })
    },
}
</script>

<style scoped>
    .mx-datepicker-range {
        width: 100% !important;
    }
</style>