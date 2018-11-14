<template lang="html">
    <layout>
        <Breadcrumb active="daftar_akun_edit" :breadcrumb="breadcrumb" />
        <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
                label="Name"
                type="text"
                placeholder="Name"
                v-model="daftar_akuns.nama_akun"
                :errors="errors.nama_akun"
            />

            <sui-form-field>
                <label>Investor</label>
                <select class="ui fluid search dropdown" name="card[expire-month]" v-model="daftar_akuns.id_user" ref="user">
                    <option value="">--PILIH INVESTOR--</option>
                    <option v-for="user, index in this.$store.state.user.users" v-bind:value="user.id">
                                {{ user.name }}
                    </option>
                </select>
                <sui-label basic color="red" pointing v-if="errors.users">
                    {{errors.users[0]}}
                </sui-label>
            </sui-form-field>

            <button class="ui teal labeled icon button" type="submit">
                Simpan Akun
                <i class="save icon"></i>
            </button>
        </form>
    </layout>
</template>

<script>

    import Header from '../../components/Header'
    import Breadcrumb from '../../components/Breadcrumb'
    import TextInput from '../../components/TextInput'

    export default {
        data: () => ({
            breadcrumb: [{value: 'home',label:'Dashboard'}, {value: 'daftar_akun',label:'Akuns'}, {value: 'daftar_akun_edit',label:'Edit Akun'}],
            loading: false,
            errors: [],
            message: '',
            daftar_akuns: {
                id_user: '',
                nama_akun: ''
            }
        }),
        mounted(){
            const app = this
            app.$store.dispatch('user/LOAD_USERS')
            app.findAkun(app.$route.params.id)
        },
        components:{
            Header, Breadcrumb, TextInput
        },
        methods: {
          findAkun(id){
            const app = this
            axios.get(`api/daftar-akun/${id}`).then((resp) => {
                const { data } = resp
                app.daftar_akuns.id_user = data.id_user
                app.daftar_akuns.nama_akun = data.nama_akun
            })
            .catch((err) => {
                console.log(err)
                alert(err)
            })
          },
          saveForm(){
            const app = this
            const id = app.$route.params.id
            app.loading = true
            axios.put(`api/daftar-akun/${id}`,app.daftar_akuns).then((resp) => {
                app.loading = false
                app.alert("Berhasil Mengubah Akun")
                app.$router.push('/daftar-akun')
            })
            .catch((err) => {
                console.log(err)
                const app = this
                const errors = err.response.data
                app.loading = false
                app.setError(errors)
            })
          },
          setError(errors){
            const app = this
            if(Object.keys(errors).length) {
                app.errors = errors.errors
            }
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
  };
</script>
