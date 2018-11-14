<template lang="html">
    <layout>
        <Breadcrumb active="server_create" :breadcrumb="breadcrumb" />
        <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
              label="Nama Server"
              type="text"
              id="name"
              placeholder="Nama Server"
              v-model="servers.name"
              :errors="errors.name"
            />
            <button class="ui teal labeled icon button" type="submit">
                Submit Server
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
            breadcrumb: [{value: 'home',label:'Dashboard'}, {value: 'server',label:'Server'}, {value: 'server_create',label:'Tambah Server'}],
            loading: false,
            errors: [],
            message: '',
            servers: {
                name: '',
            }
        }),
        mounted(){
          const app = this
        },
        components:{
          Header, Breadcrumb, TextInput
        },
        methods: {
          saveForm(){
            const app = this
            app.loading = true
            axios.post('api/server',app.servers).then((resp) => {
              app.loading = false
              app.alert("Berhasil Menambahkan Server baru")
              app.$router.push('/server')
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
