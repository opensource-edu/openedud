import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import VueRouter from 'vue-router'

import App from './App.vue'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
var VueResource = require('vue-resource')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(ElementUI)
Vue.use(VueRouter)
Vue.use(VueResource)


const router = new VueRouter({
    routes: [
        { path: '/', component: require('./components/ExampleComponent.vue') },
        { path: '/course', component: require('./components/course/CourseList.vue') },
        { path: '/course/:id/edit', name: 'CourseEdit', component: require('./components/course/CourseEdit.vue') },
        { path: '/course/add', component: require('./components/course/AddCourse.vue') },
    ]
})

const app = new Vue({
    el: "#app",
    router,
    components: { App }
})