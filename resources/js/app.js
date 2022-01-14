require('./bootstrap');

import Vue from 'vue'
import App from './components/App.vue'
import store from './store'

Vue.prototype.$axios = axios;

new Vue({
    el: '#app',
    store,
    components: { App }
})