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
import store from './store';
import VueProgressBar from 'vue-progressbar';
import VueSweetAlert2 from 'vue-sweetalert2';

import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

import cartBox from './components/Cart-Box';
import accountMenu from './components/account-menu';
import search from "./components/search";

import 'sweetalert2/dist/sweetalert2.min.css';

window.axios = require('axios');

const options = {
    color: '#e11b22',
    failedColor: '#f99d1b',
    thickness: '5px',
    transition: {
        speed: '0.1s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
};

Vue.use(VueInternationalization);
Vue.use(VueRouter);

const lang = 'en';//document.documentElement.lang.substr(0, 2);
// or however you determine your current app locale

const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
});

const alertOptions = {
    confirmButtonColor: '#f99c1c',
    cancelButtonColor: '#e01b22',
};
Vue.use(VueSweetAlert2, alertOptions);
Vue.use(VueProgressBar, options);

let app = new Vue({
    el: '#app',
    i18n,
    store,
    components: {
        cartBox, accountMenu, search
    },
    mounted: function(){
        axios.get('/api/v1/home-categories')
            .then(response => this.categories = response.data);
        this.$Progress.finish();
    },
    created () {
        //  [App.vue specific] When App.vue is first loaded start the progress bar
        this.$Progress.start();
        //  hook the progress bar to start before we move router-view
        this.$router.beforeEach((to, from, next) => {
            //  does the page we want to go to have a meta.progress object
            if (to.meta.progress !== undefined) {
                let meta = to.meta.progress;
                // parse meta tags
                this.$Progress.parseMeta(meta);
            }
            //  start the progress bar
            this.$Progress.start();
            //  continue to next page
            next();
        });
        //  hook the progress bar to finish after we've finished moving router-view
        this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish();
        })
    },

    data: {
        categories: null,
    },

    router: new VueRouter(routes)
});


axios.interceptors.request.use(
    (requestConfig) => {
        if (store.getters['authModule/isAuthenticated']) {
            console.log('sending authorization');
            console.log(store.state.authModule.accessToken);
            requestConfig.headers.Authorization = `Bearer ${store.state.authModule.accessToken}`;
        }else{
            console.log('No authorization');
        }
        return requestConfig;
    },
    (requestError) => Promise.reject(requestError),
);
axios.interceptors.response.use(
    response => response,
    (error) => {
        if (error.response.status === 401) {
            // Clear token and redirect
            console.log('asdasds');
            store.commit('authModule/setAccessToken', null);
            window.location.replace(`${window.location.origin}/login`);
        }
        return Promise.reject(error);
    },
);
