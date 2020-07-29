<template>
    <div>
        <el-table :default-sort="{prop: 'name', order: 'descending'}"
                  :data="banners.filter(data => !search || data.name.toLowerCase().includes(search.toLowerCase()))"
                  style="width: 100%">
            <el-table-column
                type="index">
            </el-table-column>
            <el-table-column
                sortable
                label="Name"
                prop="name">
            </el-table-column>
            <el-table-column
                label="Content"
                prop="content">
            </el-table-column>
            <el-table-column
                label="Link"
                prop="link">
            </el-table-column>
            <el-table-column
                align="right">
                <template slot="header" slot-scope="scope">
                    <el-input
                        v-model="search"
                        size="mini"
                        placeholder="Type to search"/>
                </template>
                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        @click="handleEdit(scope.row.id)">Edit
                    </el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        @click="handleDelete(scope.row.id)">Delete
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-drawer
            title="I am the title"
            :visible.sync="drawer"
            :with-header="false">
            <el-row>
                <h3 style="margin-top: 12px; text-align: center"> Thêm mới Banner</h3>
                <el-form :model="bannerForm" :rules="rules" ref="bannerForm" label-width="120px" class="demo-ruleForm">
                    <el-form-item label="Tên Banner" prop="name">
                        <el-input v-model="bannerForm.name"></el-input>
                    </el-form-item>
                    <el-form-item label="Nội dung " prop="content">
                        <el-input v-model="bannerForm.content"></el-input>
                    </el-form-item>
                    <el-form-item label="Link Banner" prop="link">
                        <el-input v-model="bannerForm.link"></el-input>
                    </el-form-item>
                    <el-form-item label="Trạng Thái" prop="status">
                        <el-radio v-model="bannerForm.status" :label="1">Show Banner</el-radio>
                        <el-radio v-model="bannerForm.status" :label="0">Hide</el-radio>
                    </el-form-item>
                    <el-form-item label="Hình ảnh" prop="images">
                        <img class="img-thumbnail" :src="'/uploads/banners/'+bannerForm.images" :alt="bannerForm.images"
                             style="max-width: 250px">
                        <input type="file" @change="attachFile">
                    </el-form-item>
                    <el-form-item class="submitupdate">
                        <el-button type="success"  @click="Validate('bannerForm')" round>Submit</el-button>
                        <el-button type="danger" round>Danger</el-button>
                    </el-form-item>

                </el-form>
            </el-row>
        </el-drawer>
        <el-pagination
            layout="prev, pager, next"
            @current-change="changePage"
            :total="totalRecord">
        </el-pagination>

        <br>
        <button class="btn btn-primary" @click="clearForm">Add New Product</button>
    </div>
</template>
<script>

export default {
    data() {
        return {
            banners: [],
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
            avb: 1,
            search: '',
            drawer: false,
            bannerForm: {
                name: '',
                content: '',
                link: '',
                status: '',
                images: '',
            },
            attachment: null,
            rules: {
                name: [
                    {required: true, message: 'Vui lòng tên Banner !', trigger: 'blur'},
                ]
            }
        }
    },
    beforeMount() {
        this.getBanner();
    },

    methods: {
        getBanner() {
            this.$axios.get(`/api/v1/banner/?page=${this.currentPage}&${this.sort}`)
                .then(response => {
                    this.banners = response.data.banner
                    this.totalRecord = response.data.meta.total
                })
                .catch(error => {
                    console.error(error);
                });
        },
        attachFile(event) {
            this.attachment = event.target.files[0];
            if (this.attachment != null) {
                var formData = new FormData();
                formData.append("image", this.attachment)
                this.$axios.post('api/v1/bannerimg', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                }).then(res => {
                    this.bannerForm.images = res.data;
                    console.log(this.bannerForm);
                })
            }
        },

        Validate(formName)
        {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.bannerForm.id ? this.pushData() : this.storebanner();
                }
            })
        },
        pushData() {
            console.log('in update');
            this.$axios.put(`/api/v1/banner/${this.bannerForm.id}`, this.bannerForm)
                .then((response) => {
                    console.log(response);
                    this.drawer = false;
                    if (response.status === 200) {
                        this.getBanner();
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        },
        storebanner() {
            console.log('in create');
            this.$axios.post(`/api/v1/banner/`, this.bannerForm)
                .then((res) => {
                    if (res.status === 200) {
                        this.$forceUpdate();
                        this.getBanner();
                        this.bannerForm = {
                            id:'',
                            name: '',
                            content: '',
                            link: '',
                            status: '',
                            image: '',
                        };
                    }
                    this.drawer = false;
                })
                .catch(error => {
                    console.error(error);
                });
        },

        handleEdit(id) {
            console.log(id);
            this.$axios.get(`api/v1/banner/${id}`)
                .then((res) => {
                    console.log(res.data.banner.id);
                    if (res.status === 200) {
                        this.drawer = true;
                        this.bannerForm = res.data.banner;
                    }
                }).catch(
                (res) => {
                    console.log(res);
                }
            )
        },

        handleDelete(id) {
            this.$axios.delete(`api/v1/banner/${id}`)
                .then((res) => {
                    console.log(res);
                    if (res.status === 200) {
                        this.notification()
                        this.getBanner()
                    }
                }).catch(
                (res) => {
                    console.log(res)
                }
            )
        },


        // deliver(index) {
        //     let order = this.orders[index]
        //     axios.patch(`/api/orders/${order.id}/deliver`)
        //         .then(response => {
        //             this.$forceUpdate()
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         })
        // },

        changePage(page) {
            this.currentPage = page;
            this.getBanner();
        },

        notification() {
            const h = this.$createElement;
            this.$notify({
                title: 'Title',
                message: h('i', {style: 'color: teal'}, 'Đã xoá thành công')
            });
        },
        clearForm()
        {
            this.bannerForm = {
                    name: '',
                    content: '',
                    link: '',
                    status: '',
                    image: '',
            };
            this.drawer =true;
        }
    }
}
</script>

<style scoped>

.abv {

}

.submitupdate {
    margin-top: 50px;
}

/*.noenmodel {*/
/*    transition: inherit;*/

/*}*/
</style>
