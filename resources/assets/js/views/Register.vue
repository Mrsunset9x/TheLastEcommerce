<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="120px"
                                 class="demo-ruleForm">
                            <el-form-item label="Name" prop="name">
                                <el-input v-model="ruleForm.name" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Your Email" prop="email">
                                <el-input v-model="ruleForm.email" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Address" prop="address">
                                <el-input v-model="ruleForm.address" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Your Phone" prop="phone">
                                <el-input v-model.number="ruleForm.phone"></el-input>
                            </el-form-item>
                            <el-form-item label="Password" prop="password">
                                <el-input type="password" v-model="ruleForm.password" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Confirm" prop="checkPass">
                                <el-input type="password" v-model="ruleForm.checkPass" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button type="primary" @click="submitForm('ruleForm')">Submit</el-button>
                                <el-button @click="resetForm('ruleForm')">Reset</el-button>
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['nextUrl'],
    data() {
        var checkName = (rule, value, callback) => {
            if (!value) {
                return callback(new Error('Please input the name'));
            }
        };
        var checkAddress = (rule, value, callback) => {
            if (!value) {
                return callback(new Error('Please input the Address'));
            }
        };
        var checkPhone = (rule, value, callback) => {
            if (!value) {
                return callback(new Error('Please input the Phone'));
            }
            setTimeout(() => {
                if (!Number.isInteger(value)) {
                    callback(new Error('Please input digits'));
                }
            }, 1000);
        };
        var checkEmail = (rule, value, callback) => {
            if (!value) {
                return callback(new Error('Please input the Email'));
            }
        };
        var validatePass = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input the password'));
            } else {
                if (this.ruleForm.checkPass !== '') {
                    this.$refs.ruleForm.validateField('checkPass');
                }
                callback();
            }
        };
        var validatePass2 = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input the password again'));
            } else if (value !== this.ruleForm.password) {
                callback(new Error('Two inputs don\'t match!'));
            } else {
                callback();
            }
        };
        return {
            ruleForm: {
                name: '',
                email: '',
                phone: '',
                address: '',
                password: '',
                checkPass: '',
            },
            rules: {
                name: [
                    {validator: checkName, trigger: 'blur'}
                ],
                password: [
                    {validator: validatePass, trigger: 'blur'}
                ],
                checkPass: [
                    {validator: validatePass2, trigger: 'blur'}
                ],
                address: [
                    {validator: checkAddress, trigger: 'blur'}
                ],
                phone: [
                    {validator: checkPhone, trigger: 'blur'}
                ],
                email: [
                    {validator: checkEmail, trigger: 'blur'}
                ]
            }
        }
    },
    methods: {

        submitForm(formname) {
            this.$refs[formname].validate((valid) => {
                if (valid) {
                    this.handleSubmit();
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        handleSubmit(e) {
            e.preventDefault()

            if (this.password === this.password_confirmation && this.password.length > 0) {
                axios.post('api/v1/register', {
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    address: this.address,
                    password: this.password,
                }).then(response => {
                        console.log(response);
                        localStorage.setItem('user', JSON.stringify(response.data.user))
                        localStorage.setItem('jwt', response.data.token)

                        if (localStorage.getItem('jwt') != null) {
                            this.$emit('loggedIn')
                            if (this.$route.params.nextUrl != null) {
                                this.$router.push(this.$route.params.nextUrl)
                            } else {
                                this.$router.push('/')
                            }
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                this.password = ""
                this.passwordConfirm = ""

                return alert('Passwords do not match')
            }
        }
    }
}
</script>
