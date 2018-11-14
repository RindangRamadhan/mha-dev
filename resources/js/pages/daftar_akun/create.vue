<template lang="html">
    <layout>
        <Breadcrumb active="daftar_akun_create" :breadcrumb="breadcrumb" />
        <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
              label="Nama Akun"
              type="text"
              id="name"
              placeholder="Nama Akun"
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
                Submit Akun
                <i class="send icon"></i>
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
            breadcrumb: [{value: 'home',label:'Dashboard'}, {value: 'daftar_akun',label:'Akun'}, {value: 'daftar_akun_create',label:'Tambah Akun'}],
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
        },
        components:{
          Header, Breadcrumb, TextInput
        },
        methods: {
          saveForm(){
            const app = this
            app.loading = true
            axios.post('api/daftar-akun',app.daftar_akuns).then((resp) => {
              app.loading = false
              app.alert("Berhasil Menambahkan Akun baru")
              app.$router.push('/daftar-akun')
            })
            .catch((err) => {
              console.log(err)
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
