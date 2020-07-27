<template>
    <div>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Address</th>
                <th scope="col">Products</th>
                <th scope="col">Quantity</th>
                <th scope="col">unit price</th>
                <th scope="col">total price</th>
                <th scope="col">is_delivered</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(order,index) in orders" @key="index">
                <th scope="row">{{index+1}}</th>
                <td>{{order.name}}</td>
                <td>{{order.address}}</td>
                <td v-for="(product,index) in order.products" @key="index">{{ product.name }}</td>
                <td>{{ order.quantity }}</td>
                <td>{{ order.product_price }}</td>
                <td>{{ order.product_price * order.quantity }}</td>
                <td>{{ order.order_status == 1? "Yes" : "No"}}</td>
                <td v-if=" order.order_status == 0" ><button class="btn btn-success" @click="deliver(index)">Deliver</button></td>
            </tr>
            </tbody>
        </table>
        <el-pagination
            layout="prev, pager, next"
            @current-change="changePage"
            :total="totalRecord">
        </el-pagination>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                orders: [],
                products:[],
                totalRecord: 0,
                currentPage: 1,
                sort: 'column=id&sort=desc',
                drawer: false,
                loading: false,
            }
        },
        created() {
            this.$axios.get(`/api/v1/order/?page=${this.currentPage}&${this.sort}`)
                .then(response => {
                    console.log(response);
                    this.orders = response.data.order;
                })
                .catch(error => {
                    console.error(error);
                })
        },
        methods: {
            deliver(index) {
                let order = this.orders[index]
                this.$axios.patch(`/api/v1/orders/${order.id}/deliver`)
                    .then(response => {
                        this.orders[index].order_status = 1
                        this.$forceUpdate()
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
            changePage(page) {
                this.currentPage = page;
                this.getBanner();
            },
        }

    }
</script>
