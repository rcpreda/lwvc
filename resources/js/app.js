require('./bootstrap');


import Vue from 'vue'
import App from './App.vue'
import VideoCallApp from './components/App.vue'
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
    if (to.name !== 'Login' && !localStorage.getItem('auth-user')) {
        next({ name: 'Login' })
    }
    else if ((to.name == 'Login' || to.name == 'Signup') && localStorage.getItem('auth-user')) {
        next({ name: 'Dashboard' })
    } else{
        next()
    } 
})

new Vue({
    el: '#app',
    store,
    router,
    components: { App, VideoCallApp}
})
