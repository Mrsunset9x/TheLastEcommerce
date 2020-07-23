<template>
    <div>
        <div class="container" style=" max-width: 100%">
            <div class="row">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="special_link">
                            <a href="package.html"><i class="fa fa-database"></i> <span class="nav-label">Dashboard</span></a>
                        </li>
                        <li>
                            <a href="#"  @click="setComponent('orders')"><i class="fa fa-pie-chart"></i> <span class="nav-label">Banners</span>  </a>
                        </li>
                        <li>
                            <a href="#" @click="setComponent('products')"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Products</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="#">Flot Charts</a></li>
                                <li><a href="">Morris.js Charts</a></li>
                                <li><a href="">Rickshaw Charts</a></li>
                                <li><a href="">Chart.js</a></li>
                                <li><a href="">Chartist</a></li>
                                <li><a href="">c3 charts</a></li>
                                <li><a href="">Peity Charts</a></li>
                                <li><a href="">Sparkline Charts</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"  @click="setComponent('orders')"><i class="fa fa-pie-chart"></i> <span class="nav-label">Order</span>  </a>
                        </li>
                        <li>
                            <a href="#" @click="setComponent('users')"><i class="fa fa-edit"></i> <span class="nav-label">Users</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="#">Basic form</a></li>
                                <li><a href="#">Advanced Plugins</a></li>
                                <li><a href="#">Wizard</a></li>
                                <li><a href="#">File Upload</a></li>

                            </ul>
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

    export default {
        data(){
            return {
                user : null,
                activeComponent : null
            }
        },
        components : {
            Main, Users, Products, Orders
        },
        beforeMount(){
            this.setComponent(this.$route.params.page)
            this.user = JSON.parse(localStorage.getItem('user'))
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        },
        methods : {
            setComponent(value){
                switch(value) {
                    case "users":
                        this.activeComponent = Users
                        this.$router.push({name : 'admin-pages', params : {page: 'users'}})
                        break;
                    case "orders":
                        this.activeComponent = Orders
                        this.$router.push({name : 'admin-pages', params : {page: 'orders'}})
                        break;
                    case "products":
                        this.activeComponent = Products
                        this.$router.push({name : 'admin-pages', params : {page: 'products'}})
                        break;
                    default:
                        this.activeComponent = Main
                        this.$router.push({name : 'admin'})
                        break;
                }
            }
        }
    }
</script>
<style scoped>
    .hero-section {
        height: 20vh;
        background: #ababab;
        align-items: center;
        margin-bottom: 20px;
        margin-top: -20px;
    }
    .title {
        font-size: 60px;
        color: #ffffff;
    }
</style>
