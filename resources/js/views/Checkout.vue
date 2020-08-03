<template>
    <div class="container">
            <h2 style="margin-left: 45% ; color: green"><b>Check Out </b></h2>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="order-box" v-for=" prd in product ">
                    <img :src="'/uploads/products/avatar/'+prd.image" :alt="prd.name" style=" max-width: 70px ">
                    <h2 class="title" v-html="prd.name"></h2>
                    <p class="small-text text-muted float-left">$ {{ prd.price }}</p>
                    <p class="small-text text-muted float-right">Available Units: {{ prd.units }}</p>
                    <br>
                    <hr>
                    <label class="row"><span class="col-md-2 float-left">Quantity: </span><input type="number"
                                                                                                 name="units" min="1"
                                                                                                 :max="prd.units"
                                                                                                 class="col-md-2 float-left"
                                                                                                 v-model="quantity"
                                                                                                 @change="checkUnits"></label>
                </div>
                <br>
                <div>
                    <div v-if="!isLoggedIn">
                        <h2>You need to login to continue</h2>
                        <button class="col-md-4 btn btn-primary float-left" @click="login">Login</button>
                        <button class="col-md-4 btn btn-danger float-right" @click="register">Create an account</button>
                    </div>
                    <div v-if="isLoggedIn">
                        <div class="row">
                            <label for="Name" class="col-md-3 col-form-label">Name of the consignee</label>
                            <div class="col-md-9">
                                <input id="Name" type="text" class="form-control" v-model="name" required>
                            </div>

                            <label for="address" class="col-md-3 col-form-label">Delivery Address</label>
                            <div class="col-md-9">
                                <input id="address" type="text" class="form-control" v-model="address" required>
                            </div>

                            <label for="phone" class="col-md-3 col-form-label">Your Phone</label>
                            <div class="col-md-9">
                                <input id="phone" type="text" class="form-control" v-model="phone" required>
                            </div>
                        </div>
                        <br>
                        <button class="col-md-4 btn btn-sm btn-success float-right" v-if="isLoggedIn"
                                @click="placeOrder">Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['pid'],
    data() {
        return {
            address: "",
            name: "",
            phone: "",
            quantity: 1,
            isLoggedIn: null,
            product: [],
            productId: ''
        }
    },
    mounted() {
        this.isLoggedIn = localStorage.getItem('jwt') != null
    },
    beforeMount() {
        this.$axios.get(`/api/v1/product/${this.pid}`)
            .then(response => {
                console.log(response);
                this.product = response.data.product.products
            })
            .catch(error => {
                console.error(error);
            })
        if (localStorage.getItem('jwt') != null) {
            this.user = JSON.parse(localStorage.getItem('user'))
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('jwt')
        }
    },
    methods: {
        login() {
            this.$router.push({name: 'login', params: {nextUrl: this.$route.fullPath}})
        },
        register() {
            this.$router.push({name: 'register', params: {nextUrl: this.$route.fullPath}})
        },
        placeOrder(e) {
            $.each(this.product, (key, value) => {
                this.productId = value.id;
            })
            e.preventDefault()
            console.log(this.product);
            this.$axios.post('api/v1/order', {
                address: this.address,
                quantity: this.quantity,
                product_id: this.productId,
                name: this.name,
                mobile: this.phone
            })
                .then(response => {
                    this.$router.push('/confirmation')
                })
                .catch(error => {
                    console.error(error);
                })
        },
        checkUnits(e) {
            if (this.quantity > this.product.units) {
                this.quantity = this.product.units
            }
        }
    }
}
</script>
<style scoped>
.small-text {
    font-size: 18px;
}

.order-box {
    border: 1px solid #cccccc;
    padding: 10px 15px;
}

.title {
    font-size: 36px;
}
</style>
