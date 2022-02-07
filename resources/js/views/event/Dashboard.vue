<template>
    <div>
        <Navbar/>
        <div class="w-full bg-white border-t shadow-lg">
            <div class="flex gap-10 max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8">
                <a href="" class="hover:border-gray-300 border-blue-500 border-b-4 py-4">Event Types</a>
                <a href="" class="hover:border-gray-300 border-white border-b-4 py-4">Scheduled Events</a>
            </div>
        </div>
        <div class="antialiased pt-5 pb-28">
            <div class="w-full text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800">
                <div class="max-w-screen-lg px-4 mx-auto md:px-6 lg:px-8 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    <input type="text" placeholder="Filter" class="bg-gray-50 outline-none flex-1">
                </div>
                <div class="max-w-screen-lg mt-4 px-4 mx-auto md:px-6 lg:px-8">
                    <div class="border-b-2 py-4 flex justify-between gap-2">
                        <div class="flex items-center gap-2 text-sm">
                            <div>
                                <div class="w-10 h-10 bg-blue-500 font-medium text-xl rounded-full flex justify-center text-white items-center">A</div>
                            </div>
                            <div class="flex flex-col">
                                <div>Rishi</div>
                                <div class="text-blue-500">example.com/debarshi</div>
                            </div>
                        </div>
                        <div>
                            <button @click="$router.push('/create')" class="flex gap-2 border items-center border-blue-500 text-blue-500 py-1 px-3 rounded-3xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Create new event</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="max-w-screen-lg mt-4 px-4 mx-auto md:px-6 lg:px-8 grid grid-cols-3 gap-4">
                    <div v-for="event in events" :key="event.id" class="shadow-lg rounded border-t-8" :style="`border-color:${event.color}`">
                        <div class="p-4 h-44">
                            <div class="font-medium text-lg">{{ event.name }}</div>
                            <div class="text-sm py-2 truncate" v-html="event.description"></div>
                            <a class="text-sm my-2 cursor-pointer text-blue-500 hover:border-b border-blue-500">view booking page</a>
                        </div>
                        <div class="p-4 flex border-t">
                            <div class="flex text-sm text-blue-500 items-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span>Copy Link</span>
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