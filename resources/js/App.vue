<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <router-view></router-view>
  </div>
</template>

<script>
import {mapActions} from 'vuex'
export default {
  name: 'App',
  methods:{
    ...mapActions([
      'setAuthUser',
      'destroyAuthUser'
    ])
  },
  mounted() {
    this.$axios.get('/api/user').then(res => {
      this.setAuthUser(res.data.data)
    }).catch(err => {
      this.destroyAuthUser()
      localStorage.removeItem("auth-user");
      // this is make when the  signup page refresh it will be redirect to login
      // Better to create manual check in every page, so we wil have more control
        //this.$router.push('/login')
    })
  }
}
</script>
