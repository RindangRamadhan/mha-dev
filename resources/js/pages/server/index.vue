<template>
    <layout>
        <Breadcrumb active="server" :breadcrumb="breadcrumb" />
        
        <div class="ui pointing menu">
            <router-link :to="{name: 'server_create'}" class="ui teal labeled icon button">
                Server
                <i class="add icon"></i>
            </router-link>
            <div class="right menu">                
                <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
                <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
            </div>
        </div>
        
        <Loading v-if="loading"/>
        <div class="responsive" v-else>
            <sui-table unstackable>
                <TableHeader :header="tableHeader" />
                <TableBody :data="dataServers" labelEdit="Edit" edit="server_edit" v-on:delete="handleDelete" v-if="dataServers.length"/>
                <TableKosong colspan="6" :text="message_table_kosong" v-else/>
            </sui-table>
            <pagination :data="servers" v-on:pagination-change-page="getServer" :limit="4"></pagination>
        </div>
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
                {value: 'server',label:'Server'}
            ],
            tableHeader: ['ID','Server','Edit','Hapus'],
            loading: true,
            servers: {},
            dataServers: [],
            searchLoading: false,
            search: '',
            message_table_kosong: 'Data Server Kosong'
        }),
        components:{
            Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        watch: {
          search(){
            const app = this
            app.searchLoading = true
            app.getServer()
          }
        },
        mounted() {
            const app = this
            app.getServer()
        },
        methods: {
            getServer(page = 1) {
                const app =  this
                axios.get(`api/server?page=${page}&search=${app.search}`).then((resp) => {
                    app.servers = resp.data
                    app.dataServers = resp.data.data
                    app.searchLoading = false
                    app.loading = false
                    if(!app.servers.data.length && app.search){ 
                        app.message_table_kosong = `Oopps, Tidak ada data Server yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
                    }                    
                })
                .catch((err) => {
                    app.searchLoading = false
                    app.loading = false
                    alert("Gagal Memuat Data Server")
                    console.log(err)
                })
            },
            handleDelete(id){
                const app = this
                axios.delete(`api/server/${id}`).then((resp) => {
                    app.alert("Berhasil Menghapus Data Server")
                    app.getServer()
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