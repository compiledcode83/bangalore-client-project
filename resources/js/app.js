/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import store from './store';
import VueProgressBar from 'vue-progressbar';
import VueSweetAlert2 from 'vue-sweetalert2';

import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

import cartBox from './components/Cart-Box';
import accountMenu from './components/partials/NavMenu';
import Social from "./components/Social";
import NewsletterFooter from "./components/NewsletterFooter";
import search from "./components/search";
import Layout from "./components/partials/Layout";
import SiteFooter from "./components/partials/Footer";
import TopMenu from "./components/partials/TopMenu";

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

let lang = 'en';
if (store.getters['langModule/currentLang']) {
    lang = store.state.langModule.lang;
}

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
        Layout, SiteFooter, TopMenu , cartBox, accountMenu, search, Social, NewsletterFooter
    },
    mounted: function(){
        // this.$Progress.finish();
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

    router: new VueRouter(routes)
});


axios.interceptors.request.use(
    (requestConfig) => {
        if (store.getters['authModule/isAuthenticated']) {
            // console.log('sending authorization');
            // console.log(store.state.authModule.accessToken);
            requestConfig.headers.Authorization = `Bearer ${store.state.authModule.accessToken}`;
        }else{
            console.log('No authorization');
        }

        // requestConfig.headers.xLocalization = this.$store.state.langModule.lang;

        return requestConfig;
    },
    (requestError) => Promise.reject(requestError),
);
axios.interceptors.response.use(
    response => response,
    (error) => {
        if (error.response.status === 401) {
            // Clear token and redirect
            store.commit('authModule/setAccessToken', null);
            window.location.replace(`${window.location.origin}/login`);
        }
        return Promise.reject(error);
    },
);
