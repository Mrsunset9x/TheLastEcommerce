<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header" v-html="data.name">
                        <div>Thông tin sản phẩm</div>
                    </slot>
                </div>

                <div class="modal-body">
                    <div name="body">
                        <div>Name: <input type="text" v-model="data.name"></div>
                        <br>
                        Category :
                        <div v-for="(item,index) in category">
                            <input type="radio" v-bind:value="item.id" v-model="data.category_id">
                            <span>{{ item.name }}</span>
                        </div>

                        <div style="padding-top: 12px"> Units: <input type="text" v-model="data.units"></div>
                        <br>
                        <div>Price: <input type="text" v-model="data.price"></div>
                        <br>
                        Description:
                        <br>
                        <ckeditor v-model="data.description"></ckeditor>
                        <span>
                              <img class="img-thumbnail" :src="'/uploads/products/avatar/'+data.image" :alt="data.image"
                                   v-show="data.image != null">
                              <input type="file" id="file" @change="attachFile">
                            </span>
                        <br>
                        <br>
                        <div> <input type="radio" v-model="data.featured_products" value="1"> Sản phẩm nổi bật
                            <input type="radio" v-model="data.featured_products" value="null"> Bỏ sản phẩm nổi bật</div>
                        <hr>
                        <div>
                        <input type="radio" v-model="data.status" value="1"> Hiển thị
                        <input type="radio" v-model="data.status" value="0"> Không hiển thị
                        </div>
                    </div>
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn btn-secondary" @click="close">Close</button>
                        <button type="button" class="btn btn-primary" @click="uploadFile">
                            Finish
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        this.$axios.get(`api/v1/category?limit=10&page=1&column=id&sort=asc`)
            .then(res => {
                this.category = res.data.category;
            }).catch(errors => {
            console.log(errors)
        })

    },
    props: ['product'],

    data() {
        return {
            attachment: null,
            category: [],

        }
    },
    computed: {
        data: function () {
            if (this.product != null) {
                return this.product
            } else {
                return {
                    name: "",
                    category_id: '',
                    units: "",
                    price: "",
                    featured_products:"",
                    description: "",
                    image: false,
                    status: '',

                }
            }
        }
    },
    methods: {
        attachFile(event) {
            this.attachment = event.target.files[0];
        },
        uploadFile(event) {
            if (this.attachment != null) {
                var formData = new FormData();
                formData.append("image", this.attachment)
                this.$axios.post('api/v1/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                }).then(response => {
                    console.log(response);
                    this.product.image = response.data
                    this.$emit('close', this.product)
                }).catch((res) => {
                    console.log(res);
                })
            } else {
                this.$emit('close', this.product)
            }
        },
        close() {
            this.$emit('close')
        }

    }
}
</script>
<style scoped>
.modal-mask {
    padding-top: 10px;
    position: absolute;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    width: 600px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
    margin-top: 0;
    color: #42b983;
}

.modal-body {
    margin: 20px 0;
}

.modal-default-button {
    float: right;
}

.modal-enter {
    opacity: 0;
}

.modal-leave-active {
    opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
}
</style>
