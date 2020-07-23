<template>
    <div>
        <table class="table table-dark">
            <thead>
            <tr>
                <td></td>
                <td>Name</td>
                <td>Email</td>
                <td>Address</td>
                <td>Joined</td>
                <td>level</td>
                <td>Total Orders</td>
                <td>Is Active</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(user,index) in users" @key="index">
                <td>{{index+1}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.address}}</td>
                <td>{{user.created_at}}</td>
                <td>{{user.level ==1?"Admin" :"User"}}</td>
                <td>{{user.orders.length}}</td>
                <td>{{ user.status == 1? "Active" : "No Active"}}</td>
                <td  v-if=" user.status == 0">
                    <button class="btn btn-success" @click="accept(index)">Active Now ?</button>
                    <button class="btn btn-danger" @click="deleteUser(index)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                users: [],
                totalRecord: 0,
                currentPage: 1,
                sort: 'column=id&sort=desc',
            }
        },
        beforeMount() {
            this.getUser();
            },
        methods: {
            getUser()
            {
                this.$axios.get(`/api/v1/user/?page=${this.currentPage}&${this.sort}`)
                    .then(response => {
                        console.log(response);
                        this.users = response.data.users
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
            accept(index) {
                let user = this.users[index]
                this.$axios.patch(`/api/v1/user/${user.id}/accept`)
                    .then(response => {
                        this.users[index].status = 1
                        this.$forceUpdate()
                    })
                    .catch(error => {
                        console.error(error);
                    })
            },
            deleteUser(index)
            {
                let use = this.users[index]
                this.$axios.delete(`/api/v1/user/${use.id}`)
                .then(res =>{
                    this.getUser();
                }).catch(errors =>{
                    console.log(errors);
                })
            }
        }
    }
</script>
