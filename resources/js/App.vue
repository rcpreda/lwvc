<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <Navbar/>
    <router-view></router-view>
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue'
export default {
  name: 'App',
  components: {
    Navbar
  }
}
</script>