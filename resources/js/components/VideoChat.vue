<template>
    <div class="h-full">
        <div id="video-container" class="relative">
            <video id="other-video" class="w-full h-full object-cover bg-gray-800"></video>
            <div v-if="!otherStream" class="transform -translate-x-2/4 -translate-y-2/4 absolute left-1/2 top-2/4 bg-gray-800 text-gray-400 flex justify-center items-center">
                <div class="text-center">
                    Waiting for response from <i>&nbsp;{{ callingUser.name }}</i>
                </div>
            </div>
            <video id="my-video" class="absolute w-20 h-20 md:w-28 md:h-20 lg:w-40 lg:h-28 bottom-0 object-cover z-20 bg-gray-900" muted></video>
            <svg xmlns="http://www.w3.org/2000/svg" v-if="!mic" class="h-4 w-4 bottom-0.5 z-20 text-red-500 absolute" fill="currentColor" viewBox="0 0 16 16">
                <path d="M13 8c0 .564-.094 1.107-.266 1.613l-.814-.814A4.02 4.02 0 0 0 12 8V7a.5.5 0 0 1 1 0v1zm-5 4c.818 0 1.578-.245 2.212-.667l.718.719a4.973 4.973 0 0 1-2.43.923V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 1 0v1a4 4 0 0 0 4 4zm3-9v4.879L5.158 2.037A3.001 3.001 0 0 1 11 3z"/>
                <path d="M9.486 10.607 5 6.12V8a3 3 0 0 0 4.486 2.607zm-7.84-9.253 12 12 .708-.708-12-12-.708.708z"/>
            </svg>
        </div>
        <div class="w-full h-12 flex gap-4 justify-center items-center bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" v-if="mic" @click="toggleMic(false)" class="h-7 w-7 cursor-pointer text-gray-500" fill="currentColor" viewBox="0 0 16 16">
                <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"/>
                <path d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0v5zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" v-else @click="toggleMic(true)" class="h-7 w-7 cursor-pointer text-gray-500" fill="currentColor" viewBox="0 0 16 16">
                <path d="M13 8c0 .564-.094 1.107-.266 1.613l-.814-.814A4.02 4.02 0 0 0 12 8V7a.5.5 0 0 1 1 0v1zm-5 4c.818 0 1.578-.245 2.212-.667l.718.719a4.973 4.973 0 0 1-2.43.923V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 1 0v1a4 4 0 0 0 4 4zm3-9v4.879l-1-1V3a2 2 0 0 0-3.997-.118l-.845-.845A3.001 3.001 0 0 1 11 3z"/>
                <path d="m9.486 10.607-.748-.748A2 2 0 0 1 6 8v-.878l-1-1V8a3 3 0 0 0 4.486 2.607zm-7.84-9.253 12 12 .708-.708-12-12-.708.708z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" @click="endCall()" class="h-8 w-8 cursor-pointer text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd" />
            </svg>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {
                mic: true
            }
        },
        computed: {
            ...mapGetters([
                'peer',
                'myStream',
                'otherStream',
                'callingUser'
            ])
        },
        methods: {
            toggleMic(status){
                this.mic = status
                if(this.myStream){
                    this.$store.dispatch('toggleMic', this.mic)
                }
            },
            endCall(){
                this.$store.dispatch('endCall')
            }
        },
        mounted(){
            if(this.myStream){
                const myVideo = document.querySelector("#my-video");
                try {
                    myVideo.srcObject = this.myStream;
                } catch (e) {
                    myVideo.src = URL.createObjectURL(this.myStream);
                }
                myVideo.play();
            }
            this.peer.on('error', (err) => {
                console.log(err)
                this.$store.dispatch("callEnded");
            })
            this.peer.on('close', () => {
                console.log("Peer connection closed")
                this.$store.dispatch("callEnded");
            })
        },
        watch: {
            otherStream(){
                if(this.otherStream){
                    const otherVideo = document.querySelector("#other-video");
                    try {
                        otherVideo.srcObject = this.otherStream;
                    } catch (e) {
                        otherVideo.src = URL.createObjectURL(this.otherStream);
                    }
                    otherVideo.play();
                }
            }
        }
    }
</script>


<style scoped>
    #video-container{
        height: calc(100% - 3rem)
    }
</style>