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

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    template: '<App />',
    router,
    store
});
