import Vue from 'vue'
import Router from 'vue-router'
import CreateEventView from '../views/event/Create.vue'
import ScheduleEventView from '../views/event/Schedule.vue'
import ScheduleConfirmView from '../views/event/ScheduleConfirm.vue'
import ScheduleConfirmationView from '../views/event/Confirmed.vue'
import DashboardView from '../views/event/Dashboard.vue'
import AvailibilityView from '../views/event/Availibility.vue'
import LoginView from '../views/auth/Login.vue'
import SignupView from '../views/auth/Signup.vue'
import ShowEventView from '../views/event/Show.vue';

Vue.use(Router)

export default new Router({
    mode: 'history',
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes: [
        {
            path: '/',
            name: 'Dashboard',
            component: DashboardView
        },
        {
            path: '/availibility',
            name: 'Availibility',
            component: AvailibilityView
        },
        {
            path: '/login',
            name: 'Login',
            component: LoginView
        },
        {
            path: '/signup',
            name: 'Signup',
            component: SignupView
        },
        {
            path: '/create',
            name: 'CreateEvent',
            component: CreateEventView
        },
        {
            path: '/schedule',
            name: 'ScheduleEvent',
            component: ScheduleEventView
        },
        {
            path: '/schedule/confirm',
            name: 'ScheduleConfirm',
            component: ScheduleConfirmView
        },
        {
            path: '/schedule/confirmation',
            name: 'ScheduleConfirmation',
            component: ScheduleConfirmationView
        },
        {
            path: '/event/show/:id',
            name: 'ShowEvent',
            component: ShowEventView
        },
    ]
})
