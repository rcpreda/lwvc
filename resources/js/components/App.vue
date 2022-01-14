<template>
    <div class="max-w-7xl mx-auto h-screen py-10 text-gray-500">
        <div class="flex h-full shadow-xl">
            <div class="w-3/12 border-r">
                <div class="h-12 bg-gray-100 flex items-center px-5"> Online Users </div>
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
                    <VideoChat v-if="0"/>
                    <div v-else class="h-full flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <p class="font-medium text-xl mt-2">Laravel WebRTC Video Chat</p>
                        <p class="text-gray-500 text-sm">Select a user & start video call</p>
                    </div>
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
            this.$axios.post('/logout').then(() => {
                window.location.href = '/login';
            })
        }
    },
    props: {
        authUser:{
            type: Object,
            required: true
        }
    },
    mounted(){
        if(!this.authUser){
            window.location.href = '/login';
        } else {
            this.$store.dispatch("setAuthUser", this.authUser);
        }

        Echo.join(`Laravel-video-chat`)
            .here((users) => {
                this.$store.dispatch("setOnlineUsers", users);
            })
            .joining((user) => {
                this.$store.dispatch("insertOnlineUser", user);
            })
            .leaving((user) => {
                this.$store.dispatch("removeOnlineUser", user);
            })
            .error((error) => {
                console.error(error);
            });
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