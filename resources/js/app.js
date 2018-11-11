require('./bootstrap');
require('semantic-ui-css/semantic.js')
import Vue from 'vue'

window.Vue = Vue 

import routes from './routers'
import VueRouter from 'vue-router'
import SuiVue from 'semantic-ui-vue'
import VueSwal from 'vue-swal'
import 'semantic-ui-css/semantic.min.css';

window.Vue.use(VueRouter)
window.$ = window.jQuery = require('jquery')

Vue.use(SuiVue)
Vue.use(VueSwal)
Vue.component('selectize-component', require('vue2-selectize'))
Vue.component('pagination', require('laravel-vue-pagination'));


const router = new VueRouter({ routes })

const app = new Vue({
  router
}).$mount('#app');