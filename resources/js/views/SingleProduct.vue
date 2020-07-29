<template>
    <div class="container">
        <div class="row">
            <div v-for="prd in product">
                <div class="col-md-8 offset-md-2">
                    <img :src="'/uploads/products/avatar/'+prd.image" :alt="prd.name">
                    <h3 class="title" v-html="prd.name"></h3>
                    <p class="text-muted">{{ prd.description }}</p>
                    <h4>
                        <span class="small-text text-muted float-left">$ {{ prd.price }}</span>
                        <span class="small-text float-right">Available Quantity: {{ prd.units }}</span>
                    </h4>
                    <br>
                    <hr>
                </div>
                <router-link :to="{ path: '/checkout?pid='+prd.id }"
                             class="col-md-4 btn btn-sm btn-primary float-right">Buy Now
                </router-link>
            </div>
<!--            <div class="imgg">-->
<!--            <div class="demo-image__placeholder">-->
<!--                <div class="block" v-for="img in images">-->
<!--                    <el-image :src="'/uploads/products/'+img.name" :alt="img.name" style="max-width: 300px"></el-image>-->
<!--                </div>-->
<!--            </div>-->
<!--            </div>-->
            <div class="demo-image__lazy" >
                <el-image v-for="url in images" :key="url.name" :src="'/uploads/products/'+url.name" lazy ></el-image>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            product: [],
            images: [],


        }
    },
    beforeMount() {
        this.$axios.get(`/api/v1/product/${this.$route.params.id}`)
            .then(response => {
                console.log(response);
                this.product = response.data.product
                $.each(this.product,(key,value)=>{
                    $.each(value.images,(k,v)=>{
                        this.images.push(v);
                    })
                })
            })
            .catch(error => {
                console.error(error);
            })
    }
}
</script>
<style scoped>
.small-text {
    font-size: 18px;
}

.title {
    font-size: 36px;
}
.demonstration {
    display: flex;
}
</style>
