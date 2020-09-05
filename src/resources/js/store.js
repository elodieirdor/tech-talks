import Vue from 'vue';
import Vuex from 'vuex'
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        user: null,
        token: null,
        isAuthenticated: false,
    },
    mutations: {
        authenticate (state, authResponse) {
            state.user = authResponse.user;
            state.token = authResponse.token;
            state.isAuthenticated = true;

            localStorage.setItem('user', JSON.stringify(state.user));
            localStorage.setItem('token', state.token);
        },
        autoAuthenticate (state) {
            state.user = JSON.parse(localStorage.getItem('user'));
            state.token = localStorage.getItem('token');
            state.isAuthenticated = true;
        }
    }
})

export default store
