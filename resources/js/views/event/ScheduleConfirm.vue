<template>
    <div>
        <div class="antialiased bg-gray-50 min-h-screen">
            <div class="w-full text-gray-700 bg-white shadow-sm">
                <div class="flex flex-col max-w-screen-lg px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
                    <div class="flex flex-row items-center justify-between p-4">
                        <a href="/" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">LOGO HERE</a>
                    </div>
                    <nav class="pb-0 flex justify-end gap-4">
                        <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900" href="#">Edit</a>
                        <button class="flex gap-2 rounded-3xl items-center bg-blue-600 text-white px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                            </svg>
                            <span>Share Link</span>
                        </button>
                    </nav>
                </div>
            </div>
            <div class="w-full">
                <div class="flex max-w-screen-lg p-8 mx-auto items-center justify-between">
                    <div id="container" class="w-full flex flex-col md:flex-row border rounded-md bg-white">
                        <div class="w-full md:w-4/12 font-medium border-r p-10">
                            <div class="rounded-full h-10 w-10 hover:bg-blue-100 flex items-center justify-center border cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-gray-500 mt-4">Debarshi Das</div>
                            <div class="text-2xl font-bold text-gray-700">30 Minute Meeting</div>
                            <div class="flex items-center gap-2 text-gray-700 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span>15 min</span>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                                </svg>
                                <span>Video conferencing details provided upon confirmation.</span>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                <span>12:30am - 1:00am, Saturday, January 29, 2022.</span>
                            </div>
                            <div class="flex items-start gap-2 text-gray-700 mt-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                                </svg>
                                <span>India Standard Time.</span>
                            </div>
                        </div>
                        <div class="w-full md:w-8/12 font-medium p-10">
                            <div class="w-8/12">
                                <div class="text-xl">Enter Details</div>
                                <div class="mt-4">
                                    <label for="name">Name *</label>
                                    <input type="text" class="border py-2 px-2 w-full mt-2 rounded-md">
                                </div>
                                <div class="mt-4">
                                    <label for="name">Email *</label>
                                    <input type="text" class="border py-2 px-2 w-full mt-2 rounded-md">
                                </div>
                                <div class="mt-4">
                                    <label for="name">Please share anything that will help prepare for our meeting.</label>
                                    <textarea class="border py-2 px-2 w-full mt-2 rounded-md"></textarea>
                                </div>
                                <div class="mt-4">
                                    <button @click="$router.push({ path: '/schedule/confirmation' })" class="py-2 px-3 bg-blue-600 text-white rounded-3xl">Schedule Event</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
           
        }
    },
    computed: {
       
    },

    methods: {
        
    }
}
</script>

<style scoped>
    #container{
        height: 600px;
    }
</style>