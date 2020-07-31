<template>
    <div>
        <div class="container-fluid" style="background-color: #000000;">
            <div class="container">
                <nav class="navbar navbar-expand-lg ">
                    <router-link :to="{name: 'home'}" class="navbar-brand">Clothes Shop</router-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 150px">
                        <ul class="navbar-nav mr-auto" v-for=" cate in categories">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ cate.name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" v-for="(subCate,index) in cate.categories"
                                       @key="index">{{ subCate.name }}</a>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                            </li>
                            <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                            <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Register
                            </router-link>
                            <span v-if="isLoggedIn">
                                  <router-link :to="{ name: 'userboard' }" class="nav-link" v-if="user_type === 0"> Hi, {{
                                          name
                                      }}</router-link>
                                  <router-link :to="{ name: 'admin' }" class="nav-link"
                                               v-if="user_type === 1"> Hi, {{ name }}</router-link>
                            </span>
                            <li class="nav-link" v-if="isLoggedIn" @click="logout"> Logout</li>
                            <el-dropdown>
                                <el-button v-loading >
                                    Cart({{ totalCart }})
                                </el-button>
                                <el-dropdown-menu slot="dropdown">
                                    <div class="container">
                                        <table id="cart" class="table table-hover table-condensed">
                                            <thead>
                                            <tr>
                                                <th style="width:50%">Tên sản phẩm</th>
                                                <th style="width:10%">Giá</th>
                                                <th style="width:8%">Số lượng</th>
                                                <th style="width:22%" class="text-center">Thành tiền</th>
                                                <th style="width:10%"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td data-th="Product">
                                                    <div class="row">
                                                        <div class="col-sm-2 hidden-xs"><img
                                                            src=""
                                                            alt="Sản phẩm 1" class="img-responsive" width="100">
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <h4 class="nomargin">Sản phẩm 1</h4>
                                                            <p>Mô tả của sản phẩm 1</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-th="Price">200.000 đ</td>
                                                <td data-th="Quantity"><input class="form-control text-center" value="1"
                                                                              type="number">
                                                </td>
                                                <td data-th="Subtotal" class="text-center">200.000 đ</td>
                                                <td class="actions" data-th="">
                                                    <button class="btn btn-info btn-sm"><i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td data-th="Product">
                                                    <div class="row">
                                                        <div class="col-sm-2 hidden-xs"><img
                                                            src=""
                                                            alt="Sản phẩm 1" class="img-responsive" width="100">
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <h4 class="nomargin">Sản phẩm 2</h4>
                                                            <p>Mô tả của sản phẩm 2</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-th="Price">300.000 đ</td>
                                                <td data-th="Quantity"><input class="form-control text-center" value="1"
                                                                              type="number">
                                                </td>
                                                <td data-th="Subtotal" class="text-center">300.000 đ</td>
                                                <td class="actions" data-th="">
                                                    <button class="btn btn-info btn-sm"><i class="fa fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tfoot>
                                            <tr class="visible-xs">
                                                <td class="text-center"><strong>Tổng 200.000 đ</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="http://hocwebgiare.com/" class="btn btn-warning"><i
                                                    class="fa fa-angle-left"></i> Tiếp tục mua hàng</a>
                                                </td>
                                                <td colspan="2" class="hidden-xs"></td>
                                                <td class="hidden-xs text-center"><strong>Tổng tiền 500.000 đ</strong>
                                                </td>
                                                <td><a href="http://hocwebgiare.com/" class="btn btn-success btn-block">Thanh
                                                    toán <i class="fa fa-angle-right"></i></a>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </el-dropdown-menu>
                            </el-dropdown>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <main class="py-4">
            <router-view @loggedIn="change"></router-view>
            <Footer></Footer>
        </main>
    </div>
</template>
<script>
import Footer from './Footer.vue';
export default {

    data() {
        return {
            name: null,
            user_type: 0,
            isLoggedIn: localStorage.getItem('jwt') != null,

            ///
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
            //
            categories: '',
            pushToCart: [],
            totalCart:'',
        }
    },
    components:{
        Footer
    },
    created() {
        this.setDefaults();
        this.getTotalCart();
        this.$on('adcart',value =>{
            this.totalCart = value
        })
    },
    beforeMount() {
        this.$axios.get(`api/v1/category?page=${this.currentPage}&${this.sort}`)
            .then((res) => {
                this.categories = res.data.category;
            }).catch((errors) => {
            console.log(errors);
        })
    },
    methods: {
        setDefaults() {
            if (this.isLoggedIn) {
                let user = JSON.parse(localStorage.getItem('user'))
                this.name = user.name
                this.user_type = user.level
            }
        },
        change() {
            this.isLoggedIn = localStorage.getItem('jwt') != null
            this.setDefaults()

        },
        logout() {
            localStorage.removeItem('jwt')
            localStorage.removeItem('user')
            this.change()
            this.$router.push('/')
        },
        getTotalCart(){
            this.$axios.get('/cart')
                .then((res) => {
                    this.totalCart = res.data.total;
                })
        },

    }
}
</script>

<style scoped>
.footer {
    background: #b9e2fc;
    color: black;
}

.container {
    max-width: 1140px;
}


</style>
