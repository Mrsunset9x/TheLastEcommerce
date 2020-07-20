<template>
	<div>
        <table class="table table-responsive table-striped">
            <thead>
                <tr>
                    <td></td>
                    <td>Product</td>
                    <td>Quantity</td>
                    <td>Cost</td>
                    <td>Delivery Address</td>
                    <td>is Delivered?</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(order,index) in orders" @key="index">
                    <td>{{index+1}}</td>
                    <td v-html="order.products.name"></td>
                    <td>{{order.quantity}}</td>
                    <td>{{order.quantity * order.products.price}}</td>
                    <td>{{order.address}}</td>
                    <td>{{order.is_delivered === 1? "Yes" : "No"}}</td>
                    <td v-if="order.is_delivered === 0"><button class="btn btn-success" @click="deliver(index)">Deliver</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
	export default {
        data(){
            return {
                orders : [],
                totalRecord: 0,
                currentPage: 1,
                sort: 'column=id&sort=desc',
            }
        },
        beforeMount(){
            this.$axios.get(`/api/v1/order/?page=${this.currentPage}&${this.sort}`)
            .then(response => {
                console.log(response.data.order);
                this.orders = response.data.order
            })
            .catch(error => {
                console.error(error);
            })
        },
        methods : {
            deliver(index){
                let order = this.orders[index]
                axios.patch(`/api/orders/${order.id}/deliver`)
                .then(response => {
                    this.orders[index].is_delivered = 1
                    this.$forceUpdate()
                })
                .catch(error => {
                    console.error(error);
                })
            }
        }
    }
</script>
