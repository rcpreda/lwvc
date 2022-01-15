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
                            {{ authUser.name }}
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <button @click="logout()" class="text-gray-400 hover:text-red-400">Logout</button>
                    </div>
                </div>
                <div id="chat-container" class="relative">
                    <VideoChat v-if="myStream"/>
                    <div v-else class="h-full flex flex-col items-center justify-center">
                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 1.643.397 3.23 1.145 4.65L2.029 20.94a.85.85 0 0 0 1.036 1.036l4.29-1.117A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10ZM12 8a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h3Zm3 5.162v-2.324l1.734-1.642A.75.75 0 0 1 18 9.741v4.518a.75.75 0 0 1-1.266.545L15 13.162Z" fill="#212121"/></svg>
                        <p class="font-medium text-xl mt-2">Laravel WebRTC Video Chat</p>
                        <p class="text-gray-500 text-sm">Select a user & start video call</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
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
    computed: {
        ...mapGetters([
            'myStream'
        ])
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

        Echo.private(`video-call.${this.authUser.id}`)
            .listenForWhisper('incomingVideoCall', (e) => {
                console.log("Incoming call")
                this.$store.dispatch("acceptCall", { fromUser: e.fromUser, signalData: e.signalData});
            })
            .listenForWhisper('videoCallAccepted', (e) => {
                console.log("Call Accepted")
                this.$store.dispatch("callAccepted", { signalData: e.signalData});
            })
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