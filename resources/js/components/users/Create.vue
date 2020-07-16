<template>
    <div class="main-content">
            <div class="container-fluid">
                    <div class="page-header">
                            <div class="row align-items-end">
                                    <div class="col-lg-8">
                                            <div class="page-header-title">
                                                    <i class="ik ik-edit bg-blue"></i>
                                                    <div class="d-inline">
                                                            <h5>Thêm Mới</h5>
                                                            <!-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                                <form @submit.prevent="saveForm">
                                        <div class="row">
                                                <div class="w-75 m-auto">
                                                        <div class="card">
                                                           <div class="card-body">
                                                                <div class="mb-20">
                                                                        <div class="row">
                                                                                
                                                                                <div class="col-sm-8 col-lg-10">
                                                                                        <div class="input-group">
                                                                                                <span class="input-group-prepend">
                                                                                                        <label class="input-group-text">Name</label>
                                                                                                </span>
                                                                                                <input v-model="name" type="text" class="form-control">
                                                                                        </div>
                                                                                          <div class="input-group">
                                                                                                <span class="input-group-prepend">
                                                                                                        <label class="input-group-text">Email</label>
                                                                                                </span>
                                                                                                <input v-model="email" type="text" class="form-control">
                                                                                        </div>
                                                                                          <div class="input-group">
                                                                                                <span class="input-group-prepend">
                                                                                                        <label class="input-group-text">Password</label>
                                                                                                </span>
                                                                                                <input v-model="password" type="password" class="form-control">
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        
                                                                </div>
                                                           </div>
                                                        </div>
                                                         <button type="submit" class="button-submit btn btn-info btn-block"> Thêm</button>
                                                </div>
                                        </div>    
                                        
                                 </form>
                        </div>
                      
                        </div>
                    </div>
         </div>
</template>
<style>
.type{
        padding-bottom: 50px
}
label{
        font-weight: bold
}
</style>
<script>
export default {
    name:'',
    data() {
        return {
            name:'',
            email:'',
            password:''
        }
    },
    created(){
    },
    computed: {
    },
    methods: {
       saveForm(){
         var data={
              name:this.name,
              email:this.email,
              password:this.password,
          }
        
          axios.post('/api/v1/user',data)
          .then(response=> {
                   this.$router.push('/user')
              this.$notify({
                            group: 'success',
                            title: 'Thành công',
                            type: 'success',
                            text: 'Người dùng đã được thêm mới',
                            speed: 1000,
                                duration: 500,
                    })   
          })
          .catch(function (error) {
              console.log('ERROR',error);
              
          })
       }
            
    },
}
</script>