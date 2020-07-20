<template>
	<div>
        <table class="table table-responsive table-striped" style="color: black ; text-align: center">
            <thead>
                <tr>
                    <td></td>
                    <td style="width: 40%">Product</td>
                    <td style="width: 20%">Units</td>
                    <td style="width: 30%">Price</td>
                    <td style="width: 40%">Description</td>
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
                    <td v-model="product.price" >{{product.description}}</td>
                    <td ><img :src="'/uploads/products/avatar/'+product.image" :alt="product.name"></td>
                    <td>
                        <a ><i class="fa fa-trash-o" style="color:red ; font-size: 17px"></i></a> </td>
                </tr>
            </tbody>
        </table>

        <br>
        <button class="btn btn-primary" @click="newProduct">Add New Product</button>
    </div>
</template>
<script>
    import Modal from './ProductModal'
	export default {
        data(){
            return {
                products : [],
                editingItem : null,
                addingProduct : null,
                totalRecord: 0,
                currentPage: 1,
                sort: 'column=id&sort=desc',
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
            })
        },
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
                this.editingItem = null
                let index = this.products.indexOf(product)
                axios.put(`/api/products/${product.id}`,{
                    name  : product.name,
                    units : product.units,
                    price : product.price,
                    description : product.description,
                })
                .then(response =>{
                    this.products[index] = product
                })
                .catch(response => {

                })
            },
            addProduct(product){
                this.addingProduct = null
                axios.post("/api/products/",{
                    name  : product.name,
                    units : product.units,
                    price : product.price,
                    description : product.description,
                    image : product.image
                })
                .then(response =>{
                    this.products.push(product)
                })
                .catch(response => {

                })
            }
        }
    }
</script>

<style scoped>

</style>
