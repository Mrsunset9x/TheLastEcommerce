<template>
    <div>
        <el-row class="toolbar">
            <el-button type="primary" icon="el-icon-plus" size="mini" @click="drawer = true">
                Thêm mới
            </el-button>
        </el-row>

        <el-table :data="product" v-loading="loading" border style="width: 100%">
            <el-table-column type="selection" width="55" align="center"></el-table-column>
            <el-table-column sortable prop="name" label="Tên sản phẩm">
            </el-table-column>
            <el-table-column sortable prop="question_number" align="center" label="Số câu hỏi" width="180" :formatter="getQuestionNumber">
            </el-table-column>
            <el-table-column sortable prop="image" label="Hình ảnh" width="200">
            </el-table-column>
            <el-table-column width="180">
                <template slot-scope="scope">
                    <el-button size="mini" icon="el-icon-info" @click="detail(scope.row.id)"></el-button>
                    <el-button size="mini" icon="el-icon-edit" @click="edit(scope.row.id)"></el-button>
                    <el-button size="mini" icon="el-icon-delete" @click="destroy(scope.row.id)" type="danger"></el-button>
                </template>
            </el-table-column>
        </el-table>

        <el-row class="pagination-table-view">
            <el-pagination background layout="prev, pager, next"
                @current-change="changePage"
                :total="totalRecord">
            </el-pagination>
        </el-row>

        <el-drawer title="Thêm mới đề thi" :visible.sync="drawer" :with-header="true">
            <el-row class="form-exam">
                <el-form :model="productForm" :rules="rules" ref="productForm" label-position="top" size="mini">
                    <el-form-item prop="name" label="Tên đề thi">
                        <el-input v-model="productForm.name" size="small" placeholder="Tên đề thi"></el-input>
                    </el-form-item>

                    <el-form-item prop="time" label="Thời gian làm bài (phút)">
                        <el-input v-model="productForm.time" size="small" placeholder="Thời gian làm bài"></el-input>
                    </el-form-item>

                    <el-form-item align="center">
                        <el-button type="primary" @click="validate('productForm')">Lưu lại</el-button>
                        <el-button type="danger" @click="drawer = false">Hủy</el-button>
                      </el-form-item>
                </el-form>
            </el-row>
        </el-drawer>

    </div>
</template>

<script>
    export default {
        name: 'ListExamComponent',
        props: {},
        data() {
            return {
                productForm: {
                    name: '',
                    image: '',
                },
                product: [],
                loading: false,
                totalRecord: 0,
                currentPage: 1,
                drawer: false,
                sort: 'column=id&sort=desc',
                rules: {
                    name: [
                        {required: true, message: 'Vui lòng nhập tên sản phẩm', trigger: 'blur'},
                    ]
                }
            }
        },
        created() {
            if (!localStorage.getItem('access_token')) {
                this.$router.push({name: 'login'});
                return false;
            }

            this.getProduct();
        },
        methods: {
            getProduct() {
                this.loading = true;
                this.$axios.get(`api/v1/product?page=${this.currentPage}&${this.sort}`).then((res) => {
                    if (res.status === 200) {
                        // this.product = res.data.product;
                        // this.totalRecord = res.data.meta.total;
                        console.log(res);
                    }
                    this.loading = false;
                }).catch((errors) => {
                    this.loading = false;
                    this.$message({type: 'error',message: errors.message});
                });
            },
            changePage(page) {
                this.currentPage = page;
                this.getProduct();
            },
            validate(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.productForm.id ? this.update() : this.store();
                    }
                })
            },
            detail(id) {
                this.$router.push({name: 'exams.detail', params: {id: id}})
            },
            edit(id) {
                this.$axios.get(`api/v1/exams/${id}`).then((res) => {
                    if (res.status === 200) {
                        this.drawer   = true;
                        this.productForm = res.data.exam;
                    }
                }).catch((errors) => {
                    this.$message({type: 'error',message: errors.message});
                });
            },
            store() {
                this.$axios.post(`api/v1/exams`, this.productForm).then((res) => {
                    if (res.status === 200) {
                        this.getProduct();
                        this.productForm =  {
                            name: '',
                            time: '',
                        };
                    }
                }).catch((errors) => {
                    this.$message({type: 'error',message: errors.message}); 
                });
            },
            update() {
                this.$axios.put(`api/v1/exams/${this.productForm.id}`, this.productForm).then((res) => {
                    if (res.status === 200) {
                        this.getProduct();
                    }
                }).catch((errors) => {
                    this.$message({type: 'error',message: errors.message});
                });
            },
            destroy(id) {
                this.$confirm('Bạn có chắc chắn xóa không?', 'Suntech', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    this.$axios.delete(`api/v1/exams/${id}`).then((res) => {
                        if (res.status === 200) this.getProduct();
                    }).catch((errors) => {
                        this.$message({type: 'error',message: errors.message});
                    });
                }).catch(() => {});
            },
            getQuestionNumber(row) {
                return row.questions.length;
            }
        }
    }

</script>

<style scoped>
    .form-exam {
        padding: 20px;
    }

    #el-drawer__title {
        font-size: 22px !important;
    }
</style>