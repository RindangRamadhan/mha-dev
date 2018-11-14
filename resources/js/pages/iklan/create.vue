<template lang="html">
    <layout>
        <Breadcrumb active="iklan_create" :breadcrumb="breadcrumb" />
        <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
              label="Nama Iklan"
              type="text"
              id="name"
              placeholder="Nama Iklan"
              v-model="iklans.name"
              :errors="errors.name"
            />
            <button class="ui teal labeled icon button" type="submit">
                Submit Iklan
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
            breadcrumb: [{value: 'index',label:'Dashboard'}, {value: 'iklan',label:'Iklan'}, {value: 'iklan_create',label:'Tambah Iklan'}],
            loading: false,
            errors: [],
            message: '',
            iklans: {
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
            axios.post('api/iklan',app.iklans).then((resp) => {
              app.loading = false
              app.alert("Berhasil Menambahkan Iklan baru")
              app.$router.push('/iklan')
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
