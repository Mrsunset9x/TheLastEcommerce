<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="user.email" required
                                           autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="user.password"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
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
            user: {
                email: '',
                password: '',
            },
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()

            if (this.user.password.length > 0) {
                this.$axios.post('http://localhost:8000/api/v1/login', this.user)
                    .then(response => {
                        if (response.data.code === 200) {
                            let level = response.data.user.level
                            localStorage.setItem('jwt', response.data.jwt)
                            localStorage.setItem('user', JSON.stringify(response.data.user))

                            if (localStorage.getItem('jwt') != null) {
                                this.$emit('loggedIn')
                                if (this.$route.params.nextUrl != null) {
                                    this.$router.push(this.$route.params.nextUrl)
                                } else {
                                    if (level === 1) {
                                        this.$router.push({name: 'admin'})
                                    } else {
                                        this.$router.push('/dashboard')
                                    }
                                }
                            }
                        } else {
                            this.notification();
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
        },
        notification() {
            const h = this.$createElement;
            this.$notify({
                title: 'Thông Báo !',
                message: h('i', {style: 'color: red'}, 'Thông tin tài Khoản hoặc mật khẩu không chính xác, vui lòng kiểm tra lại !')
            });
        },
    },
}
</script>

