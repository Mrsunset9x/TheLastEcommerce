<template>
    <div>
        <table id="productTable" class="table table-dark noenmodel" style="text-align: center ;width: 100%">
            <thead>
            <tr>
                <td></td>
                <td style="width: 30%">Name</td>
                <td style="width: 20%">Content</td>
                <td style="width: 30%">Link</td>
                <td style="width: 40%">Image</td>
                <td style="width: 40%">Status</td>
                <td style="width: 40%">Action</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(bann,index) in banner " @key="index" >
                <td></td>
                <td v-html="bann.name" ></td>
                <td >{{bann.content}}</td>
                <td >{{bann.link}}</td>
                <td ><img :src="'/uploads/banners/'+bann.images" :alt="bann.images" style="max-width: 200px"></td>
                <td>{{ bann.status ==1? "Show" : "Hide"}}</td>
                <td >
                    <button v-if=" bann.status == 0" class="btn btn-success" @click="accept(index)">Show Now ?</button>
                </td>
            </tr>

            </tbody>
        </table>
        <button class="btn btn-primary" >Add New Banner</button>
    </div>
</template>

<script>
    export default {
        created() {
            this.$axios.get(`api/v1/banner?limit=10&page=1&column=id&sort=asc`)
                .then(res => {
                    console.log(res);
                    this.banner = res.data.banner;
                }).catch(error => {
                console.error(error);
            });
        },
        name: "Banner",
        data (){
            return {
                banner :[],
                totalRecord: 0,
                currentPage: 1,
                sort: 'column=id&sort=desc',
            }
        },

        methods: {

        }
    }
</script>

<style scoped>

</style>
