require('./bootstrap');
import 'dtoaster/dist/dtoaster.css'

import Vue from 'vue'
import App from './App.vue'
import VideoCallApp from './components/App.vue'
import store from './store'
import VueRouter from 'vue-router'
import router from './router/routes'
import VCalendar from 'v-calendar';
import DToaster from 'dtoaster'
import ToasterPresets from './config/json/toast_presets.json';


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

Vue.directive('clickoutside', {
    bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            if (!(el == event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});

router.beforeEach((to, from, next) => {
    // this is the main cause why the the signup page keep redirect to login
    // because the condition is tru when where not going to login page (we are going to signup)
    // and we are not authenticated
    // so the solution is change the order of the logic or add new condition as shown below
    if (to.name === "Signup" && !localStorage.getItem('auth-user')) {
        next()
    }
    else if (to.name !== 'Login' && !localStorage.getItem('auth-user')) {
        next({ name: 'Login' })
    }
    else if ((to.name == 'Login' || to.name == 'Signup') && localStorage.getItem('auth-user')) {
        next({ name: 'Dashboard' })
    } else {
        next()
    }
})


Vue.use(DToaster, {
    presets: ToasterPresets,
    position: 'top-left', //toasts container position on the screen
    containerOffset: '45px', //toasts container offset from top/bottom of the screen
});


new Vue({
    el: '#app',
    store,
    router,
    components: { App, VideoCallApp }
})
