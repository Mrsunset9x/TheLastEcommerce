<template>
    <div>
        <div class="login-container">
            <el-form :model="user" status-icon :rules="rules" ref="loginForm" label-width="120px" class="demo-ruleForm">
                <el-form-item label="Email" prop="email">
                    <el-input type="text" size="small" v-model="user.email">
                    </el-input>
                </el-form-item>

                <el-form-item label="Mật khẩu" size="small" prop="password">
                    <el-input type="password" v-model="user.password" autocomplete="off"></el-input>
                </el-form-item>

                <el-form-item align="center">
                    <el-button type="primary" size="small" @click="loginSubmit('loginForm')">Đăng nhập</el-button>
                    <el-button type="default" size="small">Đăng ký mới</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<style>
    .login-container {
        padding-top: 100px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<script>
export default {
    name:'login',
    data() {
        return {
           user : {
               email : '',
               password : '',
           },
            rules: {
                email: [
                    {required: true, message: 'Vui lòng nhập email', trigger: 'blur'},
                    {type: 'email', message: 'Email không đúng định dạng',trigger: ['blur'] }
                ],
                password: [
                    {required: true, message: 'Vui lòng nhập mật khẩu', trigger: 'blur'},
                ],
            }
        }
    },
    methods:{
        loginSubmit() {
            axios.post('http://127.0.0.1:8000/api/v1/login',{email :this.user.email,password : this.user.password})
            .then((res)=> {
                if(res.status === 200){
                    localStorage.setItem('access_token', res.data.access_token);
                    this.$router.go('/product')
                }
            }).catch((errors)=>{
                console.log(errors);
            })
        }
    }
}
</script>
