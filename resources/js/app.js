require('./bootstrap');


import Vue from 'vue'
import App from './App.vue'
import VideoCallApp from './components/App.vue'
import EventLink from './views/event/EventLink.vue'
import store from './store'
import VueRouter from 'vue-router'
import router from './router/routes'
import VCalendar from 'v-calendar';


Vue.prototype.$axios = axios;

Vue.use(VueRouter)

Vue.use(VCalendar, {
    componentPrefix: 'vc',
    screens: {
        "sm": "640px",
        "md": "768px",
        "lg": "1024px",
        "xl": "1280px"
      }
});

new Vue({
    el: '#app',
    store,
    router,
    components: { App, VideoCallApp, EventLink }
})
