
require('./bootstrap')
import axios from 'axios'
import Vue from "vue";
window.Vue = require('vue');
import VueRouter from "vue-router";
import Vuetify from "vuetify"

import App from "./App.vue"


import { routes } from './router'

Vue.prototype.$axios = axios;

Vue.use(VueRouter);
Vue.use(Vuetify)



const router = new VueRouter({
    mode: "history",
    routes
});

const app = new Vue({
    el: '#app',
    components: { App },
    router: router,
    vuetify: new Vuetify(),
})
