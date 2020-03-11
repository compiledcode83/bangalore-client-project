export const namespaced = true;

export const state = {
    lang: '',
};

export const mutations = {
    setLang: (state, value) => {
        state.lang = value;
    },
};

export const getters = {
    currentLang: (state) => {
        return state.lang;
    },
};

export const actions = {

    switchLang(context, lang) {
        return context.commit('setLang', lang);
    }
};
