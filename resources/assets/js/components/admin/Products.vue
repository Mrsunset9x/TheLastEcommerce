<template>
	<div>
        <table id="productTable" class="table table-dark noenmodel" style="text-align: center ;width: 100%">
            <thead>
                <tr>
                    <td></td>
                    <td style="width: 40%">Product Name</td>
                    <td style="width: 20%">Units</td>
                    <td style="width: 30%">Price</td>
                    <td style="width: 40%">Category</td>
                    <td style="width: 40%">Image</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product,index) in products" @key="index" @dblclick="editingItem = product" >
                    <td>{{index+1}}</td>
                    <td v-html="product.name" ></td>
                    <td v-model="product.units" >{{product.units}}</td>
                    <td v-model="product.price" >{{product.price}}</td>
                    <td v-model="product.category_id">{{product.Catname}}</td>
                    <td ><img :src="'/uploads/products/avatar/'+product.image" :alt="product.image"></td>
                </tr>
            </tbody>

        </table>
        <el-pagination
            layout="prev, pager, next"
            @current-change="changePage"
            :total="totalRecord">
        </el-pagination>
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
            this.getProducts();
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
            getProducts()
            {
                this.$axios.get(`/api/v1/product/?page=${this.currentPage}&${this.sort}`)
                    .then(response => {
                        this.products = response.data.product
                        this.totalRecord =response.data.meta.total
                    })
                    .catch(error => {
                        console.error(error);
                    });
                this.$axios.get(`api/v1/category?limit=10&page=1&column=id&sort=asc`)
                    .then(res=>{
                        this.category =res.data.category;
                    }).catch(errors =>{
                    console.log(errors)
                })
            },

            addProduct(product){
                console.log(product)
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
            endEditing(product){
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
            changePage(page) {
                this.currentPage = page;
                this.getProducts();
            },

        }
    }
</script>

<style scoped>
.noenmodel {
    transition: inherit;

}
</style>
