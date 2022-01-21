<template>
    <div class="h-full bg-gray-100 flex justify-center w-full relative">
        <div class="w-full h-20 lg:h-36 bg-gray-700 flex justify-center">
            <div class="w-11/12 mt-3 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" @click="mobileNav=true" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <div id="container" class="w-11/12 md:w-10/12 absolute top-10 md:top-16 bg-white text-gray-500">
            <div class="flex h-full shadow-xl text-xs lg:text-sm">
                <div class="hidden md:block md:w-4/12 lg:w-3/12 border-r">
                    <div class="h-12 bg-gray-100 flex items-center px-5"> Online Users:  {{ onlineUsersCount }}</div>
                    <UsersList/>
                </div>
                <div class="w-full md:w-8/12 lg:w-9/12">
                    <div class="h-12 bg-gray-100 flex justify-between items-center px-2 md:px-5">
                        <div class="flex gap-2 items-center">
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
                        <div v-else class="h-full flex flex-col items-center justify-center space-x-2">
                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 1.643.397 3.23 1.145 4.65L2.029 20.94a.85.85 0 0 0 1.036 1.036l4.29-1.117A9.96 9.96 0 0 0 12 22c5.523 0 10-4.477 10-10ZM12 8a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h3Zm3 5.162v-2.324l1.734-1.642A.75.75 0 0 1 18 9.741v4.518a.75.75 0 0 1-1.266.545L15 13.162Z" fill="#212121"/></svg>
                            <p class="font-medium text-lg lg:text-xl mt-2">Laravel WebRTC Video Chat</p>
                            <p class="text-gray-500 text-sm">Select an user & start video call</p>
                            <CallRequestPopup v-if="displayCallRequestPopup && incomingCallData" class="absolute top-2 right-2"/>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="mobileNav" id="mobileNav" class="absolute z-20 bg-white text-sm overflow-auto w-10/12 left-0 top-12 shadow-lg md:hidden">
                <div class="relative">
                    <div class="h-10 flex items-center justify-between border-b px-2 bg-gray-50 sticky top-0 w-full"> 
                        <div>Online Users</div>
                        <svg xmlns="http://www.w3.org/2000/svg" @click="mobileNav=false" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <UsersList @buttonHit="mobileNav=false" class="px-2"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import UsersList from '../components/UsersList.vue'
import VideoChat from '../components/VideoChat.vue'
import CallRequestPopup from '../components/CallRequestPopup.vue'
export default {
    components: {
        UsersList,
        VideoChat,
        CallRequestPopup
    },
    data(){
        return {
            mobileNav: false
        }
    },
    computed: {
        ...mapGetters([
            'onlineUsersCount',
            'myStream',
            'incomingCallData',
            'displayCallRequestPopup'
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
                this.$axios.get(`/signals/${e.signalID}`).then(res => {
                    this.$store.dispatch("setIncomingCallData", res.data.data);
                })
                this.$store.dispatch("showCallRequestPopup");
            })
            .listenForWhisper('videoCallAccepted', (e) => {
                console.log("Call Accepted")
                this.$axios.get(`/signals/${e.signalID}`).then(res => {
                    this.$store.dispatch("setIncomingCallData", res.data.data);
                    this.$store.dispatch("callAccepted");
                })
            })
            .listenForWhisper('videoCallRejected', (e) => {
                console.log("Call Rejected")
                this.$store.dispatch("callRejected", { fromUser: e.fromUser});
            })
            .listenForWhisper('videoCallEnded', (e) => {
                console.log("Call Ended")
                this.$store.dispatch("callEnded", { fromUser: e.fromUser});
            })

    }

}
</script>

<style scoped>
    #container{
        /* min-height: calc(100% - 20rem); */
        height: 80%;
        max-height: 600px;
    }
    /* @media only screen and (max-width: 600px) {
        #container{
            height: 70%;
        }
    } */
    #chat-container{
        height: calc(100% - 3rem)
    }
    #mobileNav{
        height: calc(100% - 3rem)
    }
</style>