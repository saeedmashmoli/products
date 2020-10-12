import './bootstrap';
import Header from './components/layouts/Header.vue';
import Footer from './components/layouts/Footer.vue';
import Chats from './components/detailcomponents/AdminChats';
import router from './router';
import store from './store'

Vue.component('myHeader', Header);
Vue.component('myFooter' , Footer);
Vue.component('myChats' , Chats);


const app = new Vue({
    el: '#app',
    store,
    router
});
