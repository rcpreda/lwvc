import Vue from 'vue'
import Router from 'vue-router'
import CreateEventView from '../views/event/Create.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  scrollBehavior () {
    return { x: 0, y: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'CreateEvent',
      component: CreateEventView
    },
  ]
})