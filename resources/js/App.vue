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
      this.$router.push('/login')
    })
  }
}
</script>