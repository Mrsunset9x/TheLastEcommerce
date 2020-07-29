<template>
    <div class="row">
        <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text">
            <a href='/admin/orders'>Orders   {{ orders.length }}</a>
        </div>
        <hr>
        <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text">
            <a href='/admin/products'>Products  {{ products }}</a>
        </div>
        <div class="col-md-4 product-box d-flex align-content-center justify-content-center flex-wrap big-text">
            <a href='/admin/users'> Users   {{ users }}</a>
        </div>
    </div>
</template>
<script>
	export default {
        data(){
            return {
                user : null,
                orders : [],
                products : [],
                users : []
            }
        },
        mounted(){
            axios.get('/api/v1/user?column=id&sort=asc')
            .then(response => {
                this.users = response.data.meta.total
            })
            .catch(error => {
                console.error(error);
            })

            axios.get('/api/v1/product?column=id&sort=asc')
            .then(response => {
                this.products = response.data.meta.total
            })
            .catch(error => {
                console.error(error);
            })

            axios.get('/api/v1/order?column=id&sort=asc')
            .then(response => {
                this.orders = response.data.order
            })
            .catch(error => {
                console.error(error);
            })
        }
    }
</script>
<style scoped>
.big-text {
    font-size: 28px;
}
.product-box {
    border: 1px solid #cccccc;
    padding: 10px 15px;
    height: 20vh
}
</style>
