<template>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-12" v-if="pbCategory === 0">
                        <h2>Featured Products</h2>
                    <div class="row" >
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
                <div class="col-md-12" v-if="pbCategory ===1">
                        <h2>For Him</h2>
                    <div class="row" >
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index"
                             v-if="product.category_id === 1">
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
                <div class="col-md-12" v-if="pbCategory ===2">
                        <h2>For Her</h2>
                    <div class="row" >
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index"
                             v-if="product.category_id === 2">
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
    </div>
</template>

<script>
export default {
    name: "DetailCategory",
    data() {
        return {
            products:[],
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
            pbCategory:'',
        }
    },
    beforeMount() {

        this.$axios.get(`/api/v1/product?page=${this.currentPage}&${this.sort}`)
            .then((res) => {
                this.products = res.data.product;
                this.totalRecord = res.data.meta.total

            })
    },
    created() {
        console.log(this.$route.query.myprop)
        this.pbCategory = this.$route.query.myprop;
        console.log(this.pbCategory);
    },
    methods: {
        changePage(page) {
            this.currentPage = page;
            this.getProducts();
        },
    }
}
</script>

<style scoped>

</style>
