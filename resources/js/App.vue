<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
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
  }
}
</script>