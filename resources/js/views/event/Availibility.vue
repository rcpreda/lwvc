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
                        <div class="flex justify-between px-5">
                            <div>
                                <div class="font-medium">Working hours</div>
                                <div class="text-sm flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    default schedule
                                </div>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex mt-5 gap-4 px-5 pb-5">
                            <div class="flex flex-col">
                                <div>ACTIVE ON</div>

                            </div>
                            <div class="flex flex-col">
                                <div>TIME ZONE</div>
                                
                            </div>
                        </div>
                        <hr>
                        <div class="px-5 pt-5">
                            <div class="font-medium">Set your weekly hours</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar.vue'

export default {
    data(){
        return {
           events: null,
        }
    },
    components: {
        Navbar
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