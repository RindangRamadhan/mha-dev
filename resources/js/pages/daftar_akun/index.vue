<template>
    <layout>
        <Breadcrumb active="daftar_akun" :breadcrumb="breadcrumb" />

        <div class="ui pointing menu">
            <router-link :to="{name: 'daftar_akun_create'}" class="ui teal labeled icon button">
                Akun
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
                <TableBody :data="dataAkuns" labelEdit="Edit" edit="daftar_akun_edit" v-on:delete="handleDelete" v-if="dataAkuns.length"/>
                <TableKosong colspan="6" :text="message_table_kosong" v-else/>
            </sui-table>
            <pagination :data="daftar_akuns" v-on:pagination-change-page="getAkun" :limit="4"></pagination>
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
                {value: 'daftar_akun',label:'Akun'}
            ],
            tableHeader: ['ID','Investor','Akun','Edit','Hapus'],
            loading: true,
            akuns: {},
            dataAkuns: [],
            searchLoading: false,
            search: '',
            message_table_kosong: 'Data Akun Kosong'
        }),
        components:{
            Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        watch: {
          search(){
            const app = this
            app.searchLoading = true
            app.getAkun()
          }
        },
        mounted() {
            const app = this
            app.getAkun()
        },
        methods: {
            getAkun(page = 1) {
                const app =  this
                axios.get(`api/daftar-akun?page=${page}&search=${app.search}`).then((resp) => {
                    app.akuns = resp.data
                    app.dataAkuns = resp.data.data
                    app.searchLoading = false
                    app.loading = false
                    if(!app.akuns.data.length && app.search){ 
                        app.message_table_kosong = `Oopps, Tidak ada data Akun yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
                    }                    
                })
                .catch((err) => {
                    app.searchLoading = false
                    app.loading = false
                    alert("Gagal Memuat Data Akun")
                    console.log(err)
                })
            },
            handleDelete(id){
                const app = this
                axios.delete(`api/daftar-akun/${id}`).then((resp) => {
                    app.alert("Berhasil Menghapus Data Akun")
                    app.getAkun()
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