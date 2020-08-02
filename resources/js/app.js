import './bootstrap';
import Header from './components/layouts/Header.vue';
import Footer from './components/layouts/Footer.vue';
import router from './router';
import store from './store'

Vue.component('myHeader', Header);
Vue.component('myFooter' , Footer);



const app = new Vue({
    el: '#app',
    store,
    router
});
