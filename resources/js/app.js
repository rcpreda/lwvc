require('./bootstrap');

import Vue from 'vue'
import App from './components/App.vue'
import axios from 'axios'

Vue.prototype.$axios = axios;

new Vue({
    el: '#app',
    components: { App }
})