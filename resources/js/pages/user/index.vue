<template>
    <layout>
        <Breadcrumb active="user" :breadcrumb="breadcrumb" />
        
        <div class="ui right aligned grid">
            <div class="left floated right aligned six wide column" style="text-align: left !important">
                <router-link :to="{name: 'user_create'}" class="ui teal labeled icon button">
                    Tambah User
                    <i class="add icon"></i>
                </router-link>
                
            </div>
            <div class="right floated left aligned six wide column" style="text-align: right !important">                
                <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
                <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
            </div>
        </div>
        
        <Loading v-if="loading"/>
        <sui-table striped v-else>
            <TableHeader :header="tableHeader" />
            <TableBody :data="dataUsers" labelEdit="Edit" edit="user_edit" v-on:delete="handleDelete" v-if="dataUsers.length"/>
            <TableKosong colspan="6" :text="message_table_kosong" v-else/>
        </sui-table>
        <pagination :data="users" v-on:pagination-change-page="getUser" :limit="4"></pagination>
    </layout>
</template>

<script>
    import Breadcrumb from '../../components/Breadcrumb'
    import TableHeader from '../../components/TableHeader'
    import TableBody from '../../components/TableBody'
    import TableKosong from '../../components/TableKosong'
    import Loading from '../../components/Loading'
    
    export default {
        data: () => ({
            breadcrumb: [
                {value: 'home',label:'Dashboard'},
                {value: 'user',label:'User'}
            ],
            tableHeader: ['ID','Name','E-mail','Otoritas','Edit','Hapus'],
            loading: true,
            users: {},
            dataUsers: [],
            searchLoading: false,
            search: '',
            message_table_kosong: 'Data Users Kosong'
        }),
        components:{
            Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        watch: {
          search(){
            const app = this
            app.searchLoading = true
            app.getUser()
          }
        },
        mounted() {
            const app = this
            app.getUser()
        },
        methods: {
            getUser(page = 1) {
                const app =  this
                axios.get(`api/users?page=${page}&search=${app.search}`).then((resp) => {
                    app.users = resp.data
                    app.dataUsers = resp.data.data
                    app.searchLoading = false
                    app.loading = false
                    if(!app.users.data.length && app.search){ 
                        app.message_table_kosong = `Oopps, Tidak ada data User yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
                    }                    
                })
                .catch((err) => {
                    app.searchLoading = false
                    app.loading = false
                    alert("Gagal Memuat Data User")
                    console.log(err)
                })
            },
            handleDelete(id){
                const app = this
                axios.delete(`api/users/${id}`).then((resp) => {
                    app.alert("Berhasil menghapus data user")
                    app.getUser()
                })
                .catch((err) => {
                    alert(err)
                    console.log(err)
                })
            },
            alert(pesan){
                const app = this
                app.$swal({
                    text: pesan,
                    icon: "success",
                    buttons: false,
                    timer: 1000,
                })
            }
        }
    }
</script>