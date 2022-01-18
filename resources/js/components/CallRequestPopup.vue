<template>
    <div v-if="incomingCallData" class="min-w-min p-3 shadow-lg rounded bg-gray-100 text-gray-600 text-sm">
        <div class="font-medium">Incoming Video Call from <i>"{{ incomingCallData.user.name }}"</i></div>
        <div class="flex gap-4 mt-4 text-white">
            <div @click="accept()" class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M0 5a2 2 0 0 1 2-2h7.5a2 2 0 0 1 1.983 1.738l3.11-1.382A1 1 0 0 1 16 4.269v7.462a1 1 0 0 1-1.406.913l-3.111-1.382A2 2 0 0 1 9.5 13H2a2 2 0 0 1-2-2V5z"/>
                </svg>
            </div>
            <div @click="reject()" class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10.961 12.365a1.99 1.99 0 0 0 .522-1.103l3.11 1.382A1 1 0 0 0 16 11.731V4.269a1 1 0 0 0-1.406-.913l-3.111 1.382A2 2 0 0 0 9.5 3H4.272l6.69 9.365zm-10.114-9A2.001 2.001 0 0 0 0 5v6a2 2 0 0 0 2 2h5.728L.847 3.366zm9.746 11.925-10-14 .814-.58 10 14-.814.58z"/>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    computed: {
        ...mapGetters([
            'incomingCallData'
        ])
    },
    methods: {
        accept(){
            this.$store.dispatch("acceptCall");
            this.$store.dispatch("hideCallRequestPopup");
        },
        reject(){
            this.$store.dispatch("rejectCall");
            this.$store.dispatch("hideCallRequestPopup");
        }
    }
}
</script>