<template lang="html">
    <layout>
        <Breadcrumb active="user_create" :breadcrumb="breadcrumb" />
        <form v-on:submit.prevent="saveForm()" v-bind:class="[loading ? 'ui loading form' : 'ui form']">
            <TextInput 
              label="Nama User"
              type="text"
              id="name"
              placeholder="Name User"
              v-model="users.name"
              :errors="errors.name"
            />
            <TextInput 
              label="Password"
              type="password"
              id="password"
              placeholder="Password"
              v-model="users.password"
              :errors="errors.password"
            />
            <TextInput 
              label="E-mail"
              type="email"
              id="email"
              placeholder="E-mail"
              v-model="users.email"
              :errors="errors.email"
            />
            
            <sui-form-field>
                <label>Otoritas</label>
                <select class="ui fluid search dropdown" name="card[expire-month]" v-model="users.otoritas" ref="otoritas">
                    <option value="">--PILIH OTORITAS--</option>
                    <option v-for="otoritas, index in this.$store.state.otoritas.otoritas" v-bind:value="otoritas.id">
                                {{ otoritas.display_name }}
                    </option>
                </select>
                <sui-label basic color="red" pointing v-if="errors.otoritas">
                    {{errors.otoritas[0]}}
                </sui-label>
            </sui-form-field>
            <button class="ui teal labeled icon button" type="submit">
                Submit User
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
            breadcrumb: [{value: 'index',label:'Home'}, {value: 'user',label:'Users'}, {value: 'user_create',label:'Tambah User'}],
            loading: false,
            errors: [],
            message: '',
            users: {
                name: '',
                password: '',
                email: '',
                otoritas: ''
            }
        }),
        mounted(){
          const app = this
          app.$store.dispatch('otoritas/LOAD_OTORITAS')
        },
        components:{
          Header, Breadcrumb, TextInput
        },
        methods: {
          saveForm(){
            const app = this
            app.loading = true
            axios.post('api/users',app.users).then((resp) => {
              app.loading = false
              app.alert("Berhasil Menambahkan User baru")
              app.$router.push('/user')
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
