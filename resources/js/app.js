/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
//
// window.Vue = require('vue');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';

window.axios = require('axios');

Vue.use(VueRouter);

let app = new Vue({
    el: '#app',

    mounted: function(){
        axios.get('/api/v1/home-categories')
            .then(response => this.categories = response.data);
            // .finally(() => console.log(this.categories));
    },

    data: {
        categories: null,
    },

    router: new VueRouter(routes)
});
