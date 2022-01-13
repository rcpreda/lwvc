<template>
    <div class="max-w-7xl mx-auto h-screen py-10 text-gray-500">
        <div class="flex h-full shadow-xl rounded">
            <div class="w-3/12 border-r">
                <div class="h-12 bg-gray-100 flex items-center px-5">
                    All Users
                </div>
                <div id="users-container" class="px-5 overflow-auto">
                    <div v-for="(user,i) in users" :key="i" class="flex items-center justify-between py-3 border-b user">
                        <div class="flex gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="truncate">
                                {{ user.name }}
                            </span>
                        </div>
                       <div class="flex items-center gap-2" v-if="user.online">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer hidden video-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="w-9/12">
                <div class="h-12 bg-gray-100 flex justify-between items-center px-5">
                    <div class="flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                        </svg>
                        <span>
                            William Rogers
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <span>Debarshi Das - </span>
                        <button class="text-gray-400 hover:text-red-400">Logout</button>
                    </div>
                </div>
                <div id="chat-container" class="relative">
                    <div id="video-container" class="bg-gray-800 relative">
                        <div class="absolute w-40 h-28 bg-gray-900 bottom-0">

                        </div>
                    </div>
                    <div class="absolute w-full h-12 flex gap-4 justify-center items-center bg-gray-100 bottom-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 cursor-pointer text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 cursor-pointer text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            users: [
                { "name": "William Rogers", "online": true },
                { "name": "Stanley Mendoza", "online": true },
                { "name": "Martha Martin", "online": false },
                { "name": "Betty Matthes", "online": false },
                { "name": "Anna Aguirre", "online": true },
                { "name": "Kenneth Lee", "online": false },
                { "name": "Thomas Meyers", "online": false },
                { "name": "Ermelinda Price", "online": false },
                { "name": "Pamela Kelm", "online": false },
                { "name": "Daniel McClary", "online": true },
                { "name": "Leslie Teller", "online": false },
                { "name": "Linda Jackson", "online": false },
                { "name": "Charles Ortiz", "online": false },
                { "name": "Donald Jones", "online": false },
                { "name": "Valerie Jacobson", "online": true },
            ]
        }
    }
}
</script>

<style scoped>
    #users-container{
        height: calc(100% - 3rem)
    }
    #chat-container{
        height: calc(100% - 3rem)
    }
    #video-container{
        height: calc(100% - 3rem)
    }
    .user:hover .video-icon {
        display: block;
    }
</style>