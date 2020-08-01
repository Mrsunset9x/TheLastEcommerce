<template>
    <div v-loading.fullscreen.lock="fullscreenLoading">
        <div class="bd-example" v-for="bann in banners">
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img :src="'uploads/banners/'+ bann.images " class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <p class="slider-title">{{ bann.name }}</p>
                            <p class="slider-text"> {{ bann.content }} </p>
                            <p class="buttob mt-5">
                                <a class="btn btn-lg btn-success">BUY NOW</a>
                                <a class="btn btn-danger btn-lg">KNOW MORE</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="outer-div">
                        <div class="inner-div1">
                            <img src="../../../public/uploads/for-men.jpg" alt="forMen">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="outer-div">
                        <div class="inner-div1">
                            <img src="../../../public/uploads/for-women.jpg" alt="forWoman">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-12">
                    <h1 class="text-center">FEATURED PRODUCTS</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12" >
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index"
                             v-if="product.featured_products === 1">
                            <router-link :to="{ path: '/products/'+product.id}">
                                <img :src="'/uploads/products/avatar/'+product.image" :alt="product.name">
                                <h5><span v-html="product.name"></span>
                                    <span class="small-text text-muted float-right">${{ product.price }}</span>
                                </h5>
                                <button class="col-md-4 btn btn-sm btn-primary float-left">Buy Now</button>
                            </router-link>
                            <button class="col-md-2 btn btn-sm btn-danger float-right"><i class="fa fa-cart-arrow-down" aria-hidden="true" @click="addcart(product)"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-12">
                    <h1 class="text-center">FOR HIM</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index"
                             v-if="product.category_id === 1">
                            <router-link :to="{ path: '/products/'+product.id}">
                                <img :src="'/uploads/products/avatar/'+product.image" :alt="product.name">
                                <h5><span v-html="product.name"></span>
                                    <span class="small-text text-muted float-right">${{ product.price }}</span>
                                </h5>
                                <button class="col-md-4 btn btn-sm btn-primary float-left">Buy Now</button>
                            </router-link>
                            <button class="col-md-2 btn btn-sm btn-danger float-right"><i class="fa fa-cart-arrow-down"
                                                                                          aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-12">
                    <h1 class="text-center">FOR HER</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index"
                             v-if="product.category_id === 2">
                            <router-link :to="{ path: '/products/'+product.id}">
                                <img :src="'/uploads/products/avatar/'+product.image" :alt="product.name">
                                <h5><span v-html="product.name"></span>
                                    <span class="small-text text-muted float-right">${{ product.price }}</span>
                                </h5>
                                <button class="col-md-4 btn btn-sm btn-primary float-left">Buy Now</button>
                                <button class="col-md-2 btn btn-sm btn-danger float-right"><i
                                    class="fa fa-cart-arrow-down" aria-hidden="true"></i></button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer></Footer>
    </div>
</template>
<script>
import Footer from './Footer.vue';
export default {
    created() {
        this.openFullScreen2();
        this.$axios.get('api/v1/banner?column=id&sort=desc&limit=30')
            .then((res) => {
                $.each(res.data.banner, (key, value) => {
                    if (value.status === 1) {
                        this.banners.push(value);
                    }
                })
            }).catch((res) => {

        })
    },
    components:{
        Footer
    },
    data() {
        return {
            fullscreenLoading: false,
            products: [],
            banners: [],
            cart: [],
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
        }
    },

    mounted() {

        this.$axios.get(`api/v1/product?page=${this.currentPage}&${this.sort}`).then((res) => {
            if (res.status === 200) {
                this.products = res.data.product;
            }
        }).catch((errors) => {
            this.loading = false;
            this.$message({type: 'error', message: errors.message});
        });
    },
    methods: {
        openFullScreen2() {
            const loading = this.$loading({
                lock: true,
                text: 'Waitting...!',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.8)'
            });
            setTimeout(() => {
                loading.close();
            }, 2000);
        },
        addcart(product) {
            this.$axios.get(`/cart/${product.id}`)
                .then((res) => {
                    console.log(res.data.total, res.data);
                    this.$emit('adcart',this.res.data.total)
                })
        }

    }
}
</script>
<style scoped>
.small-text {
    font-size: 14px;
}

.product-box {
    border: 1px solid #cccccc;
    padding: 10px 15px;

}

.hero-section {
    height: 233px;
    width: 1140px;
    background: #fff;
    align-items: center;
    margin-left: 10px;
    margin-bottom: 0;
}

.title {
    font-size: 60px;
    color: green;
}

.img {
    height: 230px;
    width: 1140px;
    overflow: hidden
}

</style>
