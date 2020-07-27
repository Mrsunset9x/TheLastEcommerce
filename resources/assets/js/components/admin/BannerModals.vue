<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header" v-html="data.name">
                        <div >Thông tin Banner</div>
                    </slot>
                </div>

                <div class="modal-body">
                    <slot name="body">
                        <div>Name: <input type="text" v-model="data.name"></div>
                        <br>
                        <div style="padding-top: 12px"> Content: <input type="text" v-model="data.content"></div>
                        <br>
                        <div>Link: <input type="text" v-model="data.link"></div>
                        <br>
                        Image:
                        <br>
                        <span >
                              <img  class="img-thumbnail" :src="'/uploads/banners/'+data.images" :alt="data.image" v-show="data.images != null">
                              <input type="file" id="file" @change="attackImageBanner">
                            </span>
                        <br>
                        <br>
                        <input type="radio" value="1" v-model="data.status"> Hiển thị
                        <input type="radio" value="0" v-model="data.status"> Không hiển thị
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer">
                        <button type="button" class="btn btn-secondary" @click="close">Close</button>
                        <button type="button" class="btn btn-primary" @click="uploadImageBanner">
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

        props:[
            'banner'
        ],

        data() {
            return {
                attach : null,
            }
        },
        computed : {
            data : function(){
                if(this.banner != null){
                    return this.banner
                }
                else {
                    return {
                        name : "",
                        content:'',
                        link : "",
                        status : "",
                        image : false,

                    }
                }
            }
        },
        methods:
        {
            attackImageBanner(event){
                this.attach =event.target.files[0];
            },

            uploadImageBanner()
            {
                if (this.attach != null){
                    var formData = new FormData();
                    formData.append("image",this.attach)
                    this.$axios.post(`api/v1/bannerimg`,formData,{
                        headers:{
                            'Content-Type': 'multipart/form-data'
                        },
                    }).then(res =>{
                        this.banner.image = res.data
                        this.$emit('close',this.banner)
                    })
                }
                else {
                    this.$emit('close',this.banner)
                }
            },
            close()
            {
                this.$emit('close')
            }
        }

    }
</script>

<style scoped>
.modal-mask {
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
