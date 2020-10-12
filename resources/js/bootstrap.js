import axios from 'axios';
import Vue from 'vue';
import VueRouter from 'vue-router';
import BV from 'bootstrap-vue';

window.$ = require('jquery');
window.jQuery = require('jquery');
require('../files/bootstrap.datetimepicker/jquery.md.bootstrap.datetimepicker.js');
require('../files/bootstrap/js/bootstrap.min.js');
require('../files/inputmask/jquery.inputmask.min.js');
require('../files/fileinput/js/fileinput.min.js');
require('../files/bootstrap-selectpicker/js/bootstrap-select.min.js');

window.Vue = Vue;
window.axios = axios;


Vue.use(VueRouter);
Vue.use(BV);
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');
Pusher.logToConsole=true;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    forceTLS:false,
    wsPort: 6001,
    encrypted: true,
    disableStats: true,
});


