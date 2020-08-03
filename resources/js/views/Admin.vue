<template>
    <div>
        <div class="container" style=" max-width: 100%">
            <div class="row">
                <nav class="navbar-default navbar-static-side" role="navigation">
                    <div class="sidebar-collapse">
                        <ul class="nav metismenu" id="side-menu">
                            <li class="special_link">
                                <a href='/admin'><i class="fa fa-database"></i> <span class="nav-label">Dashboard</span></a>
                            </li>
                            <li>
                                <a href="#" @click="setComponent('banner')"><i class="fa fa-pie-chart"></i> <span
                                    class="nav-label">Banners</span> </a>
                            </li>
                            <li>
                                <a href="#" @click="setComponent('products')"><i class="fa fa-bar-chart-o"></i> <span
                                    class="nav-label">Products</span></a>
                            </li>
                            <li>
                                <a href="#" @click="setComponent('orders')"><i class="fa fa-pie-chart"></i> <span
                                    class="nav-label">Order</span> </a>
                            </li>
                            <li>
                                <a href="#" @click="setComponent('users')"><i class="fa fa-edit"></i> <span
                                    class="nav-label">Users</span></a>

                            </li>
                            <li>
                                <a href="#" @click="setComponent('coupon')"><i class="fa fa-edit"></i> <span
                                    class="nav-label">Coupon</span></a>
                            </li>
                            <li>
                                <a href="#" @click="setComponent('#')"><i class="fa fa-edit"></i> <span
                                    class="nav-label">Suppliers</span></a>
                            </li>

                        </ul>
                    </div>
                </nav>
                <div class="col-md-9">
                    <component :is="activeComponent"></component>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Main from '../components/admin/Main'
import Users from '../components/admin/Users'
import Products from '../components/admin/Products'
import Orders from '../components/admin/Orders'
import Banner from '../components/admin/Banner'
import Coupon from "../components/admin/Coupon";

export default {
    data() {
        return {
            user: null,
            activeComponent: null
        }
    },
    components: {
        Main, Users, Products, Orders, Banner , Coupon
    },
    beforeMount() {
        this.setComponent(this.$route.params.page)
        this.user = JSON.parse(localStorage.getItem('user'))
        axios.defaults.headers.common['Content-Type'] = 'application/json'
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
    },
    methods: {
        setComponent(value) {
            switch (value) {
                case "banner":
                    this.activeComponent = Banner
                    this.$router.push({name: 'admin-pages', params: {page: 'banner'}})
                    break;
                case "users":
                    this.activeComponent = Users
                    this.$router.push({name: 'admin-pages', params: {page: 'users'}})
                    break;
                case "orders":
                    this.activeComponent = Orders
                    this.$router.push({name: 'admin-pages', params: {page: 'orders'}})
                    break;
                case "products":
                    this.activeComponent = Products
                    this.$router.push({name: 'admin-pages', params: {page: 'products'}})
                    break;
                case "coupon":
                    this.activeComponent = Coupon
                    this.$router.push({name: 'admin-pages', params: {page: 'coupon'}})
                    break;
                default:
                    this.activeComponent = Main
                    this.$router.push({name: 'admin'})
                    break;
            }
        }
    }
}
</script>
<style scoped>
</style>
