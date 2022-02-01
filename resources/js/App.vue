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
      'setAuthUser'
    ])
  },
  mounted() {
    this.$axios.get('/api/user').then(res => {
      this.setAuthUser(res.data.data)
    })
  }
}
</script>