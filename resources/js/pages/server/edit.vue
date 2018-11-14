<template lang="html">
    <layout>
        <Breadcrumb active="server_edit" :breadcrumb="breadcrumb" />
        <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
                label="Name"
                type="text"
                placeholder="Name"
                v-model="servers.name"
                :errors="errors.name"
            />
            <button class="ui teal labeled icon button" type="submit">
                Simpan Server
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
            breadcrumb: [{value: 'home',label:'Dashboard'}, {value: 'server',label:'Servers'}, {value: 'server_edit',label:'Edit Server'}],
            loading: false,
            errors: [],
            message: '',
            servers: {
                name: '',
            }
        }),
        mounted(){
            const app = this
            app.findServer(app.$route.params.id)
        },
        components:{
            Header, Breadcrumb, TextInput
        },
        methods: {
          findServer(id){
            const app = this
            axios.get(`api/server/${id}`).then((resp) => {
                const { data } = resp
                app.servers.name = data.name
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
            axios.put(`api/server/${id}`,app.servers).then((resp) => {
                app.loading = false
                app.alert("Berhasil Mengubah Server")
                app.$router.push('/server')
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
