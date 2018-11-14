<template>
    <layout>
        <Breadcrumb active="iklan" :breadcrumb="breadcrumb" />
        
        <div class="ui pointing menu">
            <router-link :to="{name: 'iklan_create'}" class="ui teal labeled icon button">
                Iklan
                <i class="add icon"></i>
            </router-link>
            <div class="right menu">                
                <sui-input placeholder="Search..." icon="search" v-model="search" loading v-if="searchLoading" />
                <sui-input placeholder="Search..." icon="search" v-model="search" v-else />
            </div>
        </div>
        
        <Loading v-if="loading"/>
        <div class="responsive">
            <sui-table unstackable>
                <TableHeader :header="tableHeader" />
                <TableBody :data="dataIklans" labelEdit="Edit" edit="iklan_edit" v-on:delete="handleDelete" v-if="dataIklans.length"/>
                <TableKosong colspan="6" :text="message_table_kosong" v-else/>
            </sui-table>
            <pagination :data="iklans" v-on:pagination-change-page="getIklan" :limit="4"></pagination>
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
                {value: 'iklan',label:'Iklan'}
            ],
            tableHeader: ['ID','Iklan','Edit','Hapus'],
            loading: true,
            iklans: {},
            dataIklans: [],
            searchLoading: false,
            search: '',
            message_table_kosong: 'Data Iklan Kosong'
        }),
        components:{
            Breadcrumb, TableHeader, TableBody, TableKosong, Loading
        },
        watch: {
          search(){
            const app = this
            app.searchLoading = true
            app.getIklan()
          }
        },
        mounted() {
            const app = this
            app.getIklan()
        },
        methods: {
            getIklan(page = 1) {
                const app =  this
                axios.get(`api/iklan?page=${page}&search=${app.search}`).then((resp) => {
                    app.iklans = resp.data
                    app.dataIklans = resp.data.data
                    app.searchLoading = false
                    app.loading = false
                    if(!app.iklans.data.length && app.search){ 
                        app.message_table_kosong = `Oopps, Tidak ada data Iklan yang ditemukan untuk kata kunci "${app.search}". Cobalah menggunakan kata kunci yang lain.`
                    }                    
                })
                .catch((err) => {
                    app.searchLoading = false
                    app.loading = false
                    alert("Gagal Memuat Data Iklan")
                    console.log(err)
                })
            },
            handleDelete(id){
                const app = this
                axios.delete(`api/iklan/${id}`).then((resp) => {
                    app.alert("Berhasil Menghapus Data Iklan")
                    app.getIklan()
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