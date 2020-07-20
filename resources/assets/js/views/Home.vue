<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Welcome to Autumn Shop !!</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index">
                            <router-link :to="{ path: '/products/'+product.id}">
                                <img :src="'/uploads/products/avatar/'+product.image" :alt="product.name">
                                <h5><span v-html="product.name"></span>
                                    <span class="small-text text-muted float-right">$ {{product.price}}</span>
                                </h5>
                                <button class="col-md-4 btn btn-sm btn-primary float-right">Buy Now</button>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                products : [],
                totalRecord: 0,
                currentPage: 1,
                sort: 'column=id&sort=desc',
            }
        },
        mounted(){
           this.$axios.get(`api/v1/product?page=${this.currentPage}&${this.sort}`).then((res) => {
                    if (res.status === 200) {
                         this.products = res.data.product;
                        // this.totalRecord = res.data.meta.total;
                        console.log(res);                    }
                }).catch((errors) => {
                    this.loading = false;
                    this.$message({type: 'error',message: errors.message});
                });   
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
        height: 30vh;
        background: #ababab;
        align-items: center;
        margin-bottom: 20px;
        margin-top: -20px;
    }
    .title {
        font-size: 60px;
        color: green;
    }
</style>