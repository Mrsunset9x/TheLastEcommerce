
require('./bootstrap');

import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import VueRouter from 'vue-router';
import axios from 'axios';


Vue.config.productionTip = false;

import login from './components/login.vue';
import listProduct from './components/Products/ListProduct.vue';

Vue.use(ElementUI, {locale});
Vue.use(VueRouter);
Vue.use(axios);

axios.defaults.baseURL = 'http://127.0.0.1:8000/';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('access_token')}`;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

Vue.prototype.$axios = axios

const routes = [
    { path: '/login', name: 'login', component: login },
    { path:'./listProduct', name:'listProduct' , component:listProduct},
]

const router = new VueRouter({
	 mode: 'history',
    routes // short for `routes: routes`
})
Vue.component('admin',require('./components/App').default);
Vue.component('login',require('./components/login').default);


const app = new Vue({
    el: '#app',
    router
});
