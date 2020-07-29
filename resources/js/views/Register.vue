<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <el-form :model="ruleForm" status-icon :rules="rules" ref="ruleForm" label-width="120px"
                                 class="demo-ruleForm">
                            <el-form-item>
                                <div v-for="(errr,index) in ruleForm.validationErrors" @key="index">
                                {{ errr }}
                            </div></el-form-item>
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

        return {
            ruleForm: {
                name: '',
                email: '',
                phone: '',
                address: '',
                password: '',
                checkPass: '',
                validationErrors:'',
            },
            rules: {
                checkPass: [
                    {required: true, message: 'Vui lòng tên password !', trigger: 'blur'},
                ],
            }
        }
    },
    methods: {
        submitForm(formName) {
            console.log('befor');
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    console.log('after');
                    this.handleSubmit();
                }
            })
        },
        handleSubmit() {
            console.log('inside on handle');
            if (this.password === this.checkPass) {
                axios.post('api/v1/register', {
                    name: this.ruleForm.name,
                    email: this.ruleForm.email,
                    phone: this.ruleForm.phone,
                    password: this.ruleForm.password,
                    address: this.ruleForm.address,
                }).then(response => {
                        // console.log(response);
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
                        if (error.response.status === 422){
                           this.ruleForm.validationErrors = error.response.data.errors.messages;
                           console.log(this.ruleForm.validationErrors);
                        }
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
