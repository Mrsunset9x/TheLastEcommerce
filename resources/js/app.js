
require('./bootstrap');
import Notifications from 'vue-notification'
import VueRouter from 'vue-router';
import Vuex from 'vuex'
import store from './store/index'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import axios from 'axios';

import routes from './router/index'

window.Vue = require('vue');
window.Vue.use(VueRouter);
window.Vue.use(Vuex);
window.Vue.use(Notifications);
window.Vue.use(ElementUI);
window.Vue.use(axios);

axios.defaults.baseURL = 'http://127.0.0.1:8000/';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('access_token')}`;

import VueConfirmDialog from "vue-confirm-dialog";

Vue.use(VueConfirmDialog);
const router = new VueRouter({ routes })
const app = new Vue({
    router,store
  }).$mount('#app')
