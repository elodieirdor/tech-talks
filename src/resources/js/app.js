import Vue from 'vue';
import router from './router';
import store from './store';
import App from './components/App';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.config.productionTip = false;

require('./bootstrap');

window.axios.interceptors.request.use(function (config) {
    const token = store.state.token;
    if (token) {
        config.headers['Authorization'] =  `Bearer ${token}`;
    }
    return config;
}, function (error) {
    // Do something with request error
    return Promise.reject(error);
});

if (localStorage.getItem('user') && localStorage.getItem('token')) {
    store.commit('autoAuthenticate');
}

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    template: '<App />',
    router,
    store
});
