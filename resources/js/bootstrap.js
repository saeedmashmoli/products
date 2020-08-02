import axios from 'axios';
import Vue from 'vue';
import VueRouter from 'vue-router';
import BV from 'bootstrap-vue'

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
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};


// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
