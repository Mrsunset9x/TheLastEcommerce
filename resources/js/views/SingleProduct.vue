<template>
    <div>
        <!--        <div class="container">-->
        <!--            <div class="row">-->
        <!--                <div v-for="prd in product">-->
        <!--                    <div class="col-md-8 offset-md-5" style="max-width: 100%">-->
        <!--                        <img :src="'/uploads/products/avatar/'+prd.image" :alt="prd.name" style="max-width: 700px">-->
        <!--                        <div >-->
        <!--                            <div class="card product-card" v-for="img in images" style=" float: left ;max-width: 100px">-->
        <!--                                <img :src="'/uploads/products/'+img.name" :alt="img.name"-->
        <!--                                     style="max-height: 150px;max-width: 150px">-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                        <h3 class="title" v-html="prd.name"></h3>-->
        <!--                        <p class="text-muted">{{ prd.description }}</p>-->
        <!--                        <h4>-->
        <!--                            <span class="small-text text-muted float-left">$ {{ prd.price }}</span>-->
        <!--                            <span class="small-text float-right">Available Quantity: {{ prd.units }}</span>-->
        <!--                        </h4>-->
        <!--                        <br>-->

        <!--                    </div>-->
        <!--                    <router-link :to="{ path: '/checkout?pid='+prd.id }"-->
        <!--                                 class="col-md-4 btn btn-sm btn-primary float-right">Buy Now-->
        <!--                    </router-link>-->
        <!--                </div>-->

        <!--            </div>-->

        <!--        </div>-->
        <div class="container">
            <div class="card">
                <div class="container-fliud">
                    <div class="wrapper row" v-for="prd in product">
                        <div class="preview col-md-6">
                            <div><h3>Chi Tiết Sản Phẩm</h3></div>

                            <div class="preview-pic tab-content">
                                <div class="tab-pane active" id="pic-1"><img
                                    :src="'/uploads/products/avatar/'+prd.image" :alt="prd.name"/></div>
                                <div class="tab-pane" :id="pic+1" v-for="img in images"><img
                                    :src="'/uploads/products/'+img.name" :alt="img.name"/></div>
                            </div>
                            <ul class="preview-thumbnail nav nav-tabs">
                                <li class="active" v-for="img in images"><a data-target="#pic-1" data-toggle="tab"><img
                                    :src="'/uploads/products/'+img.name" :alt="img.name"/></a></li>
                            </ul>

                        </div>
                        <div class="details col-md-6" :rules="rules" ref="bannerForm">
                            <h3 class="product-title">{{ prd.name }}</h3>
                            <div class="rating">
                                <el-rate
                                    v-model="formReport.vote"
                                    :texts="['oops', 'disappointed', 'normal', 'good', 'great']"
                                    show-text>
                                </el-rate>
                                <div>
                                    <el-progress :percentage="50"></el-progress>
                                    <el-progress :percentage="50"></el-progress>
                                    <el-progress :percentage="50"></el-progress>
                                    <el-progress :percentage="50"></el-progress>
                                    <el-progress :percentage="50"></el-progress>
                                </div>
                                <span class="review-no">41 reviews</span>
                            </div>
                            <b><h3>Description Product :</h3></b>
                            <p class="product-description">{{ prd.description }}</p>
                            <h4 class="price">current price: <span> ${{ prd.price }}</span></h4>
                            <h5 class="sizes">sizes:
                            </h5>
                            <h5 class="colors">colors:
                                <span class="color orange not-available" data-toggle="tooltip"
                                      title="Not In store"></span>
                                <span class="color green"></span>
                                <span class="color blue"></span>
                            </h5>
                            <div class="action">

                            </div>
                            <div class="action" style="padding-top: 10px">
                                <button class=" col-md-2 btn btn-sm btn-danger">add to cart</button>
                                <router-link :to="{ path: '/checkout?pid='+prd.id }"
                                             class="add-to-cart btn btn-default">Buy Now
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3><b>Comment :</b></h3>
                        <div v-if="isLoggedIn">
                            <el-input
                                type="textarea"
                                :rows="2"
                                placeholder="Please input"
                                v-model="formReport.content">
                            </el-input>
                            <el-button type="danger" round @click="storeReport">Send</el-button>
                        </div>
                        <div v-if="!isLoggedIn">
                            <h2><b>You need to login to Comment !!</b></h2>
                            <button class="col-md-4 btn btn-primary float-left" @click="login">Login</button>
                            <button class="col-md-4 btn btn-danger float-right" @click="register">Create an account
                            </button>
                        </div>
                        <div class="row" v-for="report in reports">
                            <div class="col-md-2">
                                <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
                                <p class="text-secondary text-center">{{ report.created_at }}</p>
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <a class="float-left" href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>{{
                                            report.name
                                        }}</strong></a>
                                    <el-rate
                                        v-model="report.vote"
                                        :texts="['oops', 'disappointed', 'normal', 'good', 'great']"
                                        show-text>
                                    </el-rate>

                                </p>
                                <div class="clearfix"></div>
                                <p>{{ report.content }}</p>
                                <p>
                                    <a class="float-right btn btn-outline-primary ml-2"> <i class="fa fa-reply"></i>
                                        Reply</a>
                                    <a class="float-right btn text-white btn-danger"> <i class="fa fa-heart"></i>
                                        Like</a>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    data() {
        return {
            product: [],
            attribute: [],
            choice: '',
            images: [],
            star: null,
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
            reports: '',
            formReport: {
                vote: '',
                content: '',
            },
            isLoggedIn: null,
            rules: {
                vote: [
                    {required: true, message: 'Vui lòng tên Banner !', trigger: 'blur'},
                ]
            }

        }
    },
    beforeMount() {
        this.$axios.get(`/api/v1/product/${this.$route.params.id}`)
            .then(response => {
                console.log(response.data.product);

                this.product = response.data.product.products
                $.each(this.product, (key, value) => {
                    $.each(value.images, (k, v) => {
                        this.images.push(v);
                    })
                })
                $.each(this.product, (z, u) => {

                    this.attribute.push(u.attributes);
                })
            })
            .catch(error => {
                console.error(error);
            })
        this.$axios.post(`api/v1/reportusers/${this.$route.params.id}`)
            .then((res) => {
                console.log(res);
                this.reports = res.data.report;
            })
    },

    mounted() {
        this.isLoggedIn = localStorage.getItem('jwt') != null
    },

    methods: {
        storeReport() {
            this.$axios.post(`api/v1/reportuser/${this.$route.params.id}`, this.formReport)
                .then((res) => {
                    console.log(res);
                })
        },
        login() {
            this.$router.push({name: 'login', params: {nextUrl: this.$route.fullPath}})
            this.$forceUpdate();
        },
        register() {
            this.$router.push({name: 'register', params: {nextUrl: this.$route.fullPath}})
        },

    }
}
</script>
<style scoped>
.small-text {
    font-size: 18px;
}

.title {
    font-size: 36px;
    margin-left: 30px;
}

.demonstration {
    display: flex;
}

img {
    max-width: 100%;
}

.preview {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
}

@media screen and (max-width: 996px) {
    .preview {
        margin-bottom: 20px;
    }
}

.preview-pic {
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
}

.preview-thumbnail.nav-tabs {
    border: none;
    margin-top: 15px;
}

.preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%;
}

.preview-thumbnail.nav-tabs li img {
    max-width: 100%;
    display: block;
}

.preview-thumbnail.nav-tabs li a {
    padding: 0;
    margin: 0;
}

.preview-thumbnail.nav-tabs li:last-of-type {
    margin-right: 0;
}

.tab-content {
    overflow: hidden;
}

.tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
    animation-name: opacity;
    -webkit-animation-duration: .3s;
    animation-duration: .3s;
}

.card {
    margin-top: 50px;
    background: #eee;
    padding: 3em;
    line-height: 1.5em;
}

@media screen and (min-width: 997px) {
    .wrapper {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
}

.details {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
}

.colors {
    -webkit-box-flex: 1;
    -webkit-flex-grow: 1;
    -ms-flex-positive: 1;
    flex-grow: 1;
}

.product-title, .price, .sizes, .colors {
    text-transform: UPPERCASE;
    font-weight: bold;
}

.checked, .price span {
    color: #ff9f1a;
}

.product-title, .rating, .product-description, .price, .vote, .sizes {
    margin-bottom: 15px;
}

.product-title {
    margin-top: 0;
}

.size {
    margin-right: 10px;
}

.size:first-of-type {
    margin-left: 40px;
}

.color {
    display: inline-block;
    vertical-align: middle;
    margin-right: 10px;
    height: 2em;
    width: 2em;
    border-radius: 2px;
}

.color:first-of-type {
    margin-left: 20px;
}

.add-to-cart, .like {
    background: #ff9f1a;
    padding: 1.2em 1.5em;
    border: none;
    text-transform: UPPERCASE;
    font-weight: bold;
    color: #fff;
    -webkit-transition: background .3s ease;
    transition: background .3s ease;
}

.add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff;
}

.not-available {
    text-align: center;
    line-height: 2em;
}

.not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff;
}

.orange {
    background: #ff9f1a;
}

.green {
    background: #85ad00;
}

.blue {
    background: #0076ad;
}

.tooltip-inner {
    padding: 1.3em;
}

@-webkit-keyframes opacity {
    0% {
        opacity: 0;
        -webkit-transform: scale(3);
        transform: scale(3);
    }
    100% {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}

@keyframes opacity {
    0% {
        opacity: 0;
        -webkit-transform: scale(3);
        transform: scale(3);
    }
    100% {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}


</style>
