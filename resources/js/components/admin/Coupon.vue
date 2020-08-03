<template>
    <div>
        <el-table :data="coupons.filter(data => !search || data.coupon_code.toLowerCase().includes(search.toLowerCase()))"
                  style="width: 100%">
            <el-table-column
                type="index">
            </el-table-column>
            <el-table-column
                sortable
                label="Coupon_code"
                prop="coupon_code">
            </el-table-column>
            <el-table-column
                label="Amount"
                prop="amount">
            </el-table-column>
            <el-table-column
                label="Expiry_date"
                prop="expiry_date">
            </el-table-column>
            <el-table-column
                label="Status"
                prop="status">
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
                <h3 style="margin-top: 12px; text-align: center"> Thêm mới Coupon</h3>
                <el-form :model="CouponForm" :rules="rules" ref="CouponForm" label-width="120px" class="demo-ruleForm">
                    <el-form-item label="Mã Code" prop="coupon_code">
                        <el-input v-model="CouponForm.coupon_code"></el-input>
                    </el-form-item>
                    <el-form-item label=" Số tiền giảm " prop="amount">
                        <el-input v-model="CouponForm.amount"></el-input>
                    </el-form-item>
                    <el-form-item label="Ngày Hết hạn" prop="expiry_date">
                        <el-date-picker
                            v-model="CouponForm.expiry_date"
                            type="date"
                            placeholder="Select date and time">
                        </el-date-picker>
                    </el-form-item>
                    <el-form-item label="Trạng Thái" prop="status">
                        <el-radio v-model="CouponForm.status" :label="1">Sử Dụng</el-radio>
                        <el-radio v-model="CouponForm.status" :label="0">Không sử dụng</el-radio>
                    </el-form-item>
                    <el-form-item class="submitupdate">
                        <el-button type="success" @click="Validate('CouponForm')" round>Submit</el-button>
                        <el-button type="danger" round>Danger</el-button>
                    </el-form-item>
                </el-form>
            </el-row>
        </el-drawer>
        <br>
        <button class="btn btn-primary" @click="clearForm">Add New Coupon</button>
    </div>
</template>

<script>
export default {
    name: "Coupon",
    data() {
        return {
            coupons: [],
            totalRecord: 0,
            currentPage: 1,
            sort: 'column=id&sort=desc',
            search: '',
            drawer: false,
            CouponForm: {
                coupon_code: '',
                amount: '',
                expiry_date: '',
                status: '',
            },
            rules: {
                coupon_code: [
                    {required: true, message: 'Vui lòng chọn mã giảm giá !', trigger: 'blur'},
                ]
            }
        }
    },
    created() {
        this.getCoupon()
    },
    methods: {
        getCoupon() {
            this.$axios.get(`api/v1/coupon?page=${this.currentPage}&${this.sort}`)
                .then((res) => {
                    this.coupons = res.data.coupon;
                })
        },
        handleEdit(id) {
            this.$axios.get(`api/v1/coupon/${id}`)
                .then((res) => {
                    if (res.status === 200) {
                        this.drawer = true;
                        this.CouponForm = res.data.coupon;
                    }
                }).catch((error) => {
                console.log(error);
            })
        },
        Validate(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.CouponForm.id ? this.editCoupon() : this.storeCoupon();
                }
            })
        },
        storeCoupon() {
            this.$axios.post(`api/v1/coupon`, this.CouponForm)
                .then((res) => {
                    if (res.status === 200) {
                        this.$forceUpdate();
                        this.getCoupon();
                        this.CouponForm = {
                            coupon_code: '',
                            amount: '',
                            expiry_date: '',
                            status: '',
                        }
                        this.notification();
                    }
                    this.drawer =false;
                })

        },
        editCoupon() {
            this.$axios.put(`api/v1/coupon/${this.CouponForm.id}`, this.CouponForm)
                .then((res) => {
                    this.drawer = false;
                    if (res.status === 200) {
                        this.Editnotification();
                        this.getCoupon();
                    }
                })
        },
        handleDelete(id)
        {
            this.$axios.delete(`api/v1/coupon/${id}`)
            .then((res)=>{
                if(res.status ===200){
                    this.Deletenotification();
                    this.getCoupon()
                }
            }).catch((errors)=>{
                console.log(errors);
            })
        },
        clearForm() {
            this.CouponForm = {
                coupon_code: '',
                amount: '',
                expiry_date: '',
                status: '',
            };
            this.drawer = true;
        },
        notification() {
            const h = this.$createElement;
            this.$notify({
                title: 'Thông Báo !',
                message: h('i', { style: 'color: blue'}, 'Đã thêm mã giảm giá thành công')
            });
        },
        Editnotification() {
            const h = this.$createElement;
            this.$notify({
                title: 'Thông Báo !',
                message: h('i', { style: 'color: blue'}, 'Sửa thành công')
            });
        },
        Deletenotification() {
            const h = this.$createElement;
            this.$notify({
                title: 'Thông Báo !',
                message: h('i', { style: 'color: blue'}, 'Xoá thành công')
            });
        },
    }
}
</script>

<style scoped>

</style>
