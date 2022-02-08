<template>
   <div>
        <div class="antialiased bg-gray-100 shadow-sm">
            <div class="w-full text-gray-700 bg-white">
                <div class="flex flex-col max-w-screen-lg px-4 py-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
                    <div class="flex flex-row items-center justify-between">
                        <a @click="$router.push('/')" class="cursor-pointer text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">LOGO HERE</a>
                        <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="mobile = !mobile">
                            <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                                <path v-show="!mobile" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                <path v-show="mobile" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <nav :class="{'flex': mobile, 'hidden': !mobile}" class="flex-col flex-grow pb-4 md:pb-0 md:flex md:justify-end md:flex-row">
                        <router-link class="px-4 py-2 mt-2 text-sm font-semibold md:mt-0 md:ml-4" to="/">Home</router-link>
                        <router-link to="/availibility" class="px-4 py-2 mt-2 text-sm font-semibold md:mt-0 md:ml-4">Availibility</router-link>
                        <div class="relative ml-4">
                            <div class="flex items-center">
                                <div v-if="authUser" class="rounded-full flex items-center font-medium text-xl justify-center w-8 h-8 bg-blue-500 text-white">
                                    {{ authUser.name.charAt(0) }}
                                </div>
                                <button @click="dropDown = !dropDown" class="flex items-center py-2 mt-2 text-sm font-semibold text-left md:w-auto md:inline md:mt-0 md:ml-2">
                                    <span>Account</span>
                                    <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': dropDown, 'rotate-0': !dropDown}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>
                            <transition name="fade">
                                <div v-show="dropDown" class="absolute right-0 w-full md:max-w-max md:w-screen mt-2 origin-top-right">
                                    <div class="px-2 pt-2 pb-2 bg-white rounded-md shadow-lg">
                                        <div class="grid grid-cols-1 gap-1">
                                            <a class="flex row items-center rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="#">
                                                <div class="text-gray-800 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="font-semibold">Account Settings</p>
                                                </div>
                                            </a>
                                            <hr>
                                            <a @click="logout()" class="flex cursor-pointer items-center rounded-lg bg-transparent p-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                                <div class="text-gray-800 rounded-lg">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="font-semibold">Logout</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
   </div>
</template>

<script>
import {mapGetters} from 'vuex'
import {mapActions} from 'vuex'
export default {
    data(){
        return {
            mobile: false,
            dropDown: false
        }
    },
    computed: {
        ...mapGetters([
            'authUser'
        ])
    },
    methods: {
        ...mapActions([
            'destroyAuthUser'
        ]),
        logout(){
            this.$axios.post('/api/logout').then(() => {
                this.destroyAuthUser()
                localStorage.removeItem("auth-user");
                this.$router.push('/login')
            })
        }
    },
}
</script>

<style scoped>

</style>
