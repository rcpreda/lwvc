<template>
    <div id="users-container" class="px-5 overflow-auto">
        <div v-for="(user,i) in onlineUsers" :key="i" class="flex w-full items-center justify-between py-3 gap-1 border-b user">
            <div class="flex gap-1 lg:gap-2 items-center w-11/12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="truncate flex-1">
                    {{ user.name }}
                </div>
            </div>
            <div class="flex w-6 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" @click="startCall(user)" class="h-5 w-5 cursor-pointer hidden video-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            
        }
    },
    computed: {
        ...mapGetters([
            'onlineUsers'
        ])
    },
    methods: {
        startCall(user){
            this.$emit('buttonHit')
            this.$store.dispatch('startCall', user)
        }
    },
    mounted(){
        
    }
}
</script>

<style scoped>
    .user:hover .video-icon {
        display: block;
    }
    #users-container{
        height: calc(100% - 3rem)
    }
</style>