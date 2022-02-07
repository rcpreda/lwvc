<template>
    <div>
        <div class="w-full min-h-screen flex flex-col justify-center items-center bg-gray-50">
            <div class="bg-white border border-gray-300 w-80 py-8 flex items-center flex-col mb-3">
                <h1 class="font-medium">LOGO HERE</h1>
                <div class="mt-8 w-64 flex flex-col">
                    <input autofocus
                        class="text-xs w-full mb-2 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                        id="email" name="email" v-model="email" placeholder="Email" type="email" required>
                    <input autofocus
                        class="text-xs w-full mb-4 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                        id="password" name="password"  v-model="password" placeholder="Password" type="password" required>
                    <div class="flex gap-1.5 mb-4 items-center text-xs text-gray-500">
                        <input type="checkbox" name="remember" v-model="remember">
                        <span class="-mt-0.5">Remember me</span>
                    </div>
                    <button @click="login()" class="text-sm text-center cursor-pointer bg-blue-600 text-white py-1 rounded font-medium">
                        Log In
                    </button>
                </div>
                <div class="flex justify-evenly space-x-2 w-64 mt-4">
                    <span class="bg-gray-300 h-px flex-grow t-2 relative top-2"></span>
                    <span class="flex-none uppercase text-xs text-gray-400 font-semibold">or</span>
                    <span class="bg-gray-300 h-px flex-grow t-2 relative top-2"></span>
                </div>
                <a class="text-xs text-blue-900 mt-4 cursor-pointer -mb-4">Forgot password?</a>
            </div>
            <div class="bg-white border border-gray-300 text-center w-80 py-4">
                <span class="text-sm">Don't have an account?</span>
                <router-link to="/signup" class="text-blue-500 text-sm font-semibold">Sign up</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
    data(){
        return {
            email: null,
            password: null,
            remember: false
        }
    },
    methods: {
        ...mapActions([
            'setAuthUser'
        ]),
        login(){
            this.$axios.get('/sanctum/csrf-cookie').then(res => {
                this.$axios.post('/api/login',{email: this.email, password: this.password, remember: this.remember}).then(res => {
                    localStorage.setItem('auth-user', JSON.stringify(res.data.data));
                    this.setAuthUser(res.data.data)
                    this.$router.push('/')
                })
            });
        }
    }
}
</script>