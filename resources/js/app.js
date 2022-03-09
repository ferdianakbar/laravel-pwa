import $ from 'jquery';
window.$ = window.jQuery = $;

require('./bootstrap');
import * as Vue from 'vue';
import {createRouter, createWebHistory} from 'vue-router';
import VueCookies from 'vue3-cookies';
import {routes} from './router';
import {checkToken} from "./helper";

//initiate router
const router = createRouter({
    history: createWebHistory(),
    routes
});

//initiate the vue
const app = Vue.createApp({
    data() {
        return {
            siteName: '',
            loggedIn: false
        }
    },
    mounted() {
        //set the sitename
        let rootContainer = $(this.$el.parentNode);
        this.siteName = rootContainer.data('site-name');
        checkToken(this);
    }
});

//add router and vue cookies to the vue
app.use(router);
app.use(VueCookies);

//registering Navigation and FooterView components
app.component('navigation', require('./components/Navigation').default);
app.component('footer-view', require('./components/FooterView').default);


//Set global axios configuration
axios.defaults.baseURL = '/api';
axios.defaults.headers.common['Accept'] = 'application/json';

app.config.globalProperties.$axios = axios;

//Mounting the vue object as SPA
app.mount('#app');
