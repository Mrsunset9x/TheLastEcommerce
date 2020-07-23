<template>
	<div>
        <table class="table table-responsive table-striped" style="color: black ; text-align: center ;width: 100%">
            <thead>
                <tr>
                    <td></td>
                    <td style="width: 40%">Product</td>
                    <td style="width: 20%">Units</td>
                    <td style="width: 30%">Price</td>
                    <td style="width: 40%">Category</td>
                    <td style="width: 40%">Image</td>
                    <td style="width: 40%">Action</td>
                </tr>
            </thead>
            <tbody style="background-color: wheat ">
                <tr v-for="(product,index) in products" @key="index" @dblclick="editingItem = product" >
                    <td>{{index+1}}</td>
                    <td v-html="product.name" ></td>
                    <td v-model="product.units" >{{product.units}}</td>
                    <td v-model="product.price" >{{product.price}}</td>
                    <td >{{product.category_id}}</td>
                    <td ><img :src="'/uploads/products/avatar/'+product.image" :alt="product.image"></td>
                    <td>
                        <a v-model="productId" value="product.id" @click="deleteProduct">
                            <i class="fa fa-trash-o" style="color:red ; font-size: 17px"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <modal @close="endEditing" :product="editingItem" v-show="editingItem != null"></modal>
        <modal @close="addProduct"  :product="addingProduct" v-show="addingProduct != null"></modal>
        <br>
        <button class="btn btn-primary" @click="newProduct">Add New Product</button>
    </div>
</template>
<script>
    import Modal from './ProductModal.vue'
	export default {
        data(){
            return {
                products : [],
                editingItem : null,
                addingProduct : null,
                totalRecord: 0,
                currentPage: 1,
                sort: 'column=id&sort=desc',
                productId:'',
                category:[],

            }
        },
        components : {
            Modal
        },
        beforeMount(){
            this.$axios.get(`/api/v1/product/?page=${this.currentPage}&${this.sort}`)
            .then(response => {
                this.products = response.data.product
            })
            .catch(error => {
                console.error(error);
            }).then(
                this.$axios.get(`api/v1/category?limit=10&page=1&column=id&sort=asc`)
                    .then(res=>{
                        this.category =res.data.category;
                    }).catch(errors =>{
                    console.log(errors)
                })
            )
        },
        // Lấy được tấtc cả thông tin nhưng chưa lưu được vào database
        methods : {
            newProduct(){
                this.addingProduct = {
                    name : null,
                    units : null,
                    price : null,
                    description : null,
                    image : null
                }
            },
            endEditing(product){
                console.log(product);
                this.editingItem = null
                let index = this.products.indexOf(product)
                this.$axios.post(`/api/v1/product/${product.id}`,{
                    category_id :product.category_id,
                    name  : product.name,
                    description : product.description,
                    price : product.price,
                    units : product.units,
                    image : product.image,
                    status :product.status,
                })
                .then(response =>{
                    this.products[index] = product
                })
                .catch(response => {

                })
            },
            addProduct(product){
                console.log(product);
                this.addingProduct = null
                this.$axios.post("/api/v1/product/",{
                    category_id :product.category_id,
                    name  : product.name,
                    description : product.description,
                    price : product.price,
                    units : product.units,
                    image : product.image,
                    status :product.status,
                })
                .then(response =>{
                    this.products.push(product)
                })
                .catch(response => {

                })
            },

            deleteProduct()
            {
               console.log( this.productId);
            }
        }
    }
</script>

<style scoped>

</style>
