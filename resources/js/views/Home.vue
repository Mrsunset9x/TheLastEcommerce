<template>
    <div>

        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <el-carousel class="img" :interval="2000" type="card">
                <el-carousel-item v-for="(item,index) in banners" :key="index">
                    <div class="imgSide">
                        <img :src="'uploads/banners/'+item.images" :alt="item.name">
                    </div>
                </el-carousel-item>
            </el-carousel>
        </div>
        <div class="menu">
            <ul>
                <li>
                    Home
                </li>
            </ul>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(product,index) in products" @key="index">
                            <router-link :to="{ path: '/products/'+product.id}">
                                <img :src="'/uploads/products/avatar/'+product.image" :alt="product.name">
                                <h5><span v-html="product.name"></span>
                                    <span class="small-text text-muted float-right">${{ product.price }}</span>
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
    created() {
        this.$axios.get('api/v1/banner?column=id&sort=desc&limit=30')
            .then((res) => {
             $.each(res.data.banner,(key,value) =>{
                 if (value.status === 1)
                 {
                   return this.banners.push(value);
                 }
             } )
            }).catch((res) => {

        })
    },
    data() {
        return {
            products: [],
            banners:[],
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
        }
    },
    mounted() {
        this.$axios.get(`api/v1/product?page=${this.currentPage}&${this.sort}`).then((res) => {
            if (res.status === 200) {
                this.products = res.data.product;
                console.log(this.products);
            }
        }).catch((errors) => {
            this.loading = false;
            this.$message({type: 'error', message: errors.message});
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
    height: 230px ;
    width: 1140px ;
    overflow: hidden
}
.imgSide img {
    display: block;
    max-width: 1000px;
    max-height: 233px;
    padding-left: 100px;
}
.menu {
    margin-left: 383px;
    max-width: 1140px;
    padding-top: 0px;
    margin-bottom: 0px;
    background-color: red;
}


</style>
