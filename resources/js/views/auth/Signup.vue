<template>
    <div>
         <div class="w-full min-h-screen flex flex-col justify-center items-center bg-gray-50">
            <div class="bg-white border border-gray-300 w-80 py-8 flex items-center flex-col mb-3">
                <h1 class="font-medium">Video Chat</h1>
                <a class="text-xs mt-2 text-gray-500">Create an account & start calling</a>
                <div class="mt-4 w-64 flex flex-col">
                    <input autofocus
                        class="text-xs w-full mb-2 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                        id="name" name="name" v-model="name" placeholder="Name" type="text" required>
                    <input autofocus
                        class="text-xs w-full mb-2 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                        id="email" name="email" v-model="email" placeholder="Email" type="email" required>
                    <input autofocus
                        class="text-xs w-full mb-4 rounded border bg-gray-100 border-gray-300 px-2 py-2 focus:outline-none focus:border-gray-400 active:outline-none"
                        id="password" name="password" v-model="password" placeholder="Password" type="password" required>
                    <button @click="signup()" class="text-sm text-center cursor-pointer bg-blue-600 text-white py-1 rounded font-medium">
                        Sign up
                    </button>
                </div>
                <div class="text-center w-80 py-4">
                    <span class="text-sm">Already have an account?</span>
                    <router-link to="/login" class="text-blue-500 text-sm font-semibold">Login</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: null,
            email: null,
            password: null,
        }
    },
    methods: {
        signup(){
            this.$axios.post('/api/signup', {name:this.name, email: this.email, password: this.password}).then(res => {
                this.$router.push('/login')
            })
        }
    }
}
</script>