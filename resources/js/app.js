import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import CKEditor from 'ckeditor4-vue';
import Bus from './Bus.js';

Vue.use(VueRouter)
Vue.use(ElementUI, {locale});
Vue.use( CKEditor );
Vue.use(Bus);

import App from './views/App'
import Home from './views/Home'
import Login from './views/Login'
import Register from './views/Register'
import SingleProduct from './views/SingleProduct'
import DetailCategory from "./views/DetailCategory";
import Checkout from './views/Checkout'
import Confirmation from './views/Confirmation'
import UserBoard from './views/UserBoard'
import Admin from './views/Admin'

Vue.use(axios);
axios.defaults.baseURL = 'http://127.0.0.1:8000/';
axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('jwt')}`;
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

Vue.prototype.$axios = axios

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/products/:id',
            name: 'single-products',
            component: SingleProduct
        },
        {
            path: '/category/:id',
            name: 'detail-category',
            component: DetailCategory
        },
        {
            path: '/confirmation',
            name: 'confirmation',
            component: Confirmation
        },
        {
            path: '/checkout',
            name: 'checkout',
            component: Checkout,
            props: (route) => ({pid : route.query.pid})
        },
        {
            path: '/dashboard',
            name: 'userboard',
            component: UserBoard,
            meta: {
                requiresAuth: true,
                is_user : true
            }
        },
        {
            path: '/admin/:page',
            name: 'admin-pages',
            component: Admin,
            meta: {
                requiresAuth: true,
                is_admin : true
            }
        },
        {
            path: '/admin',
            name: 'admin',
            component: Admin,
            meta: {
                requiresAuth: true,
                is_admin : true
            }
        },
    ],
})
router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)) {
    if (localStorage.getItem('jwt') == null) {
      next({
        path: '/login',
        params: { nextUrl: to.fullPath }
      })
    } else {
      let user = JSON.parse(localStorage.getItem('user'))
      if(to.matched.some(record => record.meta.level)) {
        if(user.level === 1){
            next()
        }
        else{
            next({ name: 'userboard'})
        }
      }
      else if(to.matched.some(record => record.meta.is_user)) {
        if(user.level === 0){
            next()
        }
        else{
            next({ name: 'admin'})
        }
      }
      next()
    }
  } else {
    next()
  }
})

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
