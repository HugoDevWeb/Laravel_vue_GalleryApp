
require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
import routes from './routes';
Vue.use(VueRouter);

const router = new VueRouter({
    routes: routes
});

Vue.component('spinner', require('vue-simple-spinner'));

import App from './App.vue';

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});
