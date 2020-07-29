<template>
    <div>
        <table id="productTable" class="table table-dark noenmodel" style="text-align: center ;width: 100%">
            <thead>
            <tr>
                <td></td>
                <td style="width: 25%">Product Name</td>
                <td style="width: 10%">Units</td>
                <td style="width: 10%">Price</td>
                <td style="width: 20%">Category</td>
                <td style="width: 25%">Image</td>
                <td style="width: 40%">Add More Image</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product,index) in products" @key="index" @dblclick="editingItem = product">
                <td>{{ index + 1 }}</td>
                <td v-html="product.name"></td>
                <td v-model="product.units">{{ product.units }}</td>
                <td v-model="product.price">{{ product.price }}</td>
                <td v-model="product.category_id">{{ product.Catname }}</td>
                <td><img v-model="product.image" :src="'/uploads/products/avatar/'+product.image" :alt="product.name">
                </td>
                <td>
                    <button class=" btn btn-success" @click="addMoreImg(product)">Add more</button>
                </td>
            </tr>
            </tbody>
        </table>
        <el-pagination
            layout="prev, pager, next"
            @current-change="changePage"
            :total="totalRecord">
        </el-pagination>
        <el-drawer
            title="Add More Image for Products"
            :visible.sync="drawer"
            :with-header="false"
            :size=" '40%'"
            v-loading="loading"
            element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading"
            element-loading-background="rgba(0, 0, 0, 0.8)">
            <h3 style="margin-top: 12px; text-align: center">Xem và chỉnh sửa ảnh hiển thị sản phẩm</h3>
            <div class="demo-image__preview">
                <el-image
                    style="width: 200px; height: 200px ; padding-top: 40px; margin-left: 35%"
                    :src="'/uploads/products/avatar/'+avatar"
                    :preview-src-list="srcList">
                </el-image>
            </div>
            <div class="block">
                <span class="demonstration">Image Products</span>
                <el-carousel height="350px">
                    <el-carousel-item v-for="(item,index) in srcList" :key="index">
                        <div class="imgSide">
                            <img :src="item" alt="abc">
                            <a><i @click="deleteimgs(item)" class="fa fa-times" aria-hidden="true"></i></a>
                        </div>
                    </el-carousel-item>
                </el-carousel>
            </div>
            <div class="form-group">
                <label>Upload Files</label>
                <input id="upload-file" type="file" multiple class="form-control" @change="fieldChange">
            </div>
            <button class="btn btn-primary submit" @click="uploadFile">Submit</button>
        </el-drawer>
        <modal @close="endEditing" :product="editingItem" v-show="editingItem != null"></modal>
        <modal @close="addProduct" :product="addingProduct" v-show="addingProduct != null"></modal>
        <br>
        <button class="btn btn-primary" @click="newProduct">Add New Product</button>
    </div>
</template>
<script>
import Modal from './ProductModal.vue'

export default {
    data() {
        return {
            products: [],
            editingItem: null,
            addingProduct: null,
            drawer: false,
            //handleChecked
            loading: false,
            //getItem
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
            //
            productId: '',
            //
            category: [],
            srcList: [],
            avatar: '',
            //upload Multiple Images
            attachments: [],
            form: new FormData,
            //
            checkList: [''],
            img: '',


        }
    },
    components: {
        Modal
    },
    beforeMount() {
        this.getProducts();
    },

    methods: {
        newProduct() {
            this.addingProduct = {
                name: null,
                units: null,
                price: null,
                description: null,
                image: null
            }
        },
        getProducts() {
            this.$axios.get(`/api/v1/product/?page=${this.currentPage}&${this.sort}`)
                .then(response => {
                    this.products = response.data.product
                    this.totalRecord = response.data.meta.total
                })
                .catch(error => {
                    console.error(error);
                });
            this.$axios.get(`api/v1/category?limit=10&page=1&column=id&sort=asc`)
                .then(res => {
                    this.category = res.data.category;
                }).catch(errors => {
                console.log(errors)
            })
        },

        addProduct(product) {
            this.addingProduct = null
            this.$axios.post("/api/v1/product/", {
                category_id: product.category_id,
                name: product.name,
                description: product.description,
                price: product.price,
                units: product.units,
                image: product.image,
                status: product.status,
            })
                .then(response => {
                    this.products.push(product);
                    this.g
                })
                .catch(response => {

                })
        },
        endEditing(product) {
            this.editingItem = null
            let index = this.products.indexOf(product)
            this.$axios.post(`/api/v1/product/${product.id}`, {
                category_id: product.category_id,
                name: product.name,
                description: product.description,
                price: product.price,
                units: product.units,
                image: product.image,
                status: product.status,
            }).then(response => {
                this.products[index] = product
                this.$forceUpdate();
            }).catch(response => {

            })
        },
        // Show form upload more img
        addMoreImg(product) {
            this.productId = product.id;
            this.avatar = product.image;
            this.drawer = true;
            $.each(product.images, (key, value) => {
                this.srcList.push('/uploads/products/' + value.name);
            })
        },
        fieldChange(e) {
            let selectedFiles = e.target.files;
            if (!selectedFiles.length) {
                return false;
            }
            for (let i = 0; i < selectedFiles.length; i++) {
                this.attachments.push(selectedFiles[i]);
            }
            console.log(this.attachments);
        },
        uploadFile() {
            this.loading = true;
            for (let i = 0; i < this.attachments.length; i++) {
                this.form.append('images[]', this.attachments[i]);
            }
            const config = {headers: {'Content-Type': 'multipart/form-data'}};
            document.getElementById('upload-file').value = [];
            axios.post(`/api/v1/addimg/${this.productId}`, this.form, config).then(response => {
                this.$forceUpdate();
                this.loading = false;
                this.drawer = false;
                this.notification();
            }).catch(response => {
            });
        },

        deleteimgs(event) {
            var images = event.match(/\d/g);
            images = images.join("");
            this.img = images + '.jpg';
            console.log(this.img);
            this.form.append('images', this.img);
            this.$axios.post(`/api/v1/deletemultipleimg`, this.form)
                .then((res) => {
                    this.$forceUpdate();
                    this.Deletenotification();
                }).catch((error) => {
                console.log(error);
            })
        },
        //
        changePage(page) {
            this.currentPage = page;
            this.getProducts();
        },
        notification() {
            const h = this.$createElement;
            this.$notify({
                title: 'Thông Báo !',
                message: h('i', {style: 'color: blue'}, 'Đã thêm hình ảnh thành công')
            });
        },
        Deletenotification() {
            const h = this.$createElement;
            this.$notify({
                title: 'Thông Báo !',
                message: h('i', {style: 'color: blue'}, 'Đã xoá hình ảnh thành công cho quý zị')
            });
        },
    }
}
</script>

<style scoped>
.noenmodel {
    transition: inherit;
}

.submit {
    padding-top: 15px;
    margin-left: 39%;
}

.el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 150px;
    margin: 0;
}

.block {
    padding-left: 10px;
}

.imgSide {
    position: relative;
}

.imgSide img {
    display: block;

}

.imgSide .fa-times {
    position: absolute;
    top: 0;
    left: 0;
    font-size: 30px;
    color:red;
}

.icon {
    position: fixed;
    bottom: 0;
    right: 0;
    top: 0;
    width: 50px;
    border-radius: 35px;
    border: 3px solid #73AD21;
}
</style>
