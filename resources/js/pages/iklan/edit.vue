<template lang="html">
    <layout>
        <Breadcrumb active="iklan_edit" :breadcrumb="breadcrumb" />
        <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
                label="Name"
                type="text"
                placeholder="Name"
                v-model="iklans.name"
                :errors="errors.name"
            />
            <button class="ui teal labeled icon button" type="submit">
                Simpan Iklan
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
            breadcrumb: [{value: 'home',label:'Dashboard'}, {value: 'iklan',label:'Iklans'}, {value: 'iklan_edit',label:'Edit Iklan'}],
            loading: false,
            errors: [],
            message: '',
            iklans: {
                name: '',
            }
        }),
        mounted(){
            const app = this
            app.findIklan(app.$route.params.id)
        },
        components:{
            Header, Breadcrumb, TextInput
        },
        methods: {
          findIklan(id){
            const app = this
            axios.get(`api/iklan/${id}`).then((resp) => {
                const { data } = resp
                app.iklans.name = data.name
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
            axios.put(`api/iklan/${id}`,app.iklans).then((resp) => {
                app.loading = false
                app.alert("Berhasil Mengubah Iklan")
                app.$router.push('/iklan')
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
