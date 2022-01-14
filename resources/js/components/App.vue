<template>
    <div class="max-w-7xl mx-auto h-screen py-10 text-gray-500">
        <div class="flex h-full shadow-xl rounded">
            <div class="w-3/12 border-r">
                <div class="h-12 bg-gray-100 flex items-center px-5"> All Users </div>
                <UsersList/>
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
                        <span>{{ authUser.name }} - </span>
                        <button @click="logout()" class="text-gray-400 hover:text-red-400">Logout</button>
                    </div>
                </div>
                <div id="chat-container" class="relative">
                    <VideoChat/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UsersList from '../components/UsersList.vue'
import VideoChat from '../components/VideoChat.vue'
export default {
    components: {
        UsersList,
        VideoChat
    },
    data(){
        return{
            
        }
    },
    methods: {
        logout(){
            this.$axios.post('/logout')
        }
    },
    props: {
        authUser:{
            type: Object,
            required: true
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
</style>