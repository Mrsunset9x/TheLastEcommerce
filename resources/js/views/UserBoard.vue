<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">All your orders</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <div class="row">
                        <div class="col-md-4 product-box" v-for="(order,index) in orders" @key="index">
                            <div v-for="(prd,index) in order['products']" @key="index">
                            <img :src="`/uploads/products/avatar/`+prd.image" :alt="prd.name">

                            <h5><span v-html="prd.name"></span><br>
                                <span class="small-text text-muted">unit Price :{{prd.price}}</span>
                            </h5>
                            <hr>
<!--                            <span class="small-text text-muted">Quantity: {{order.quantity}}-->
                                <span class="float-right">{{order.order_status == 1? "Shipped!" : "Not yet shipped"}}</span>
<!--                            </span>-->
                            <br><br>
                            </div>
                            <p><strong>Delivery address:</strong> <br>{{order.address}}</p>
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
                user : null,
                orders : [],
            }
        },
        beforeMount(){
            this.user = JSON.parse(localStorage.getItem('user'))
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')

            this.$axios.get(`api/v1/user/${this.user.id}/order`)
            .then(response => {
                console.log(response);
                this.orders = response.data
            })
            .catch(error => {
                console.error(error);
            })
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
