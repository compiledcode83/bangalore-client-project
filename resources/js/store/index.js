import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from 'vuex-persistedstate';
import Cookies from 'js-cookie';

import * as cartModule from './modules/cart';
import * as authModule from './modules/auth';
import * as langModule from './modules/lang';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authModule: authModule,
        langModule: langModule,
        cartModule: cartModule
    },
    plugins: [createPersistedState({
        storage: {
            getItem: key => Cookies.get(key),
            setItem: (key, value) => Cookies.set(key, value, { domain: `.${window.location.hostname}`, expires: 375 , secure: false }),
            removeItem: key => Cookies.remove(key)
        }
    })],
})
