<template lang="html">
  <div class="background">
    <sui-grid centered vertical-align="middle">
      <sui-grid-column>

        <h2 is="sui-header" image>
          <sui-header-content style="color: white">Log-in to your Account</sui-header-content>
        </h2>

        <sui-form v-on:submit.prevent="saveForm()">
          <Message :header="message" :errors="errors" v-if="errors.length" />
          <sui-segment stacked>
            <sui-form-field>
              <sui-input
              v-model="email"
              type="email"
              placeholder="E-mail address"
              icon="user"
              icon-position="left" />
            </sui-form-field>
            <sui-form-field>
              <sui-input
              v-model="password"
              type="password"
              placeholder="Password"
              icon="lock"
              icon-position="left" />
            </sui-form-field>
             <Loading v-if="loading" />
           	 <sui-button size="large" color="teal" fluid v-else>Login</sui-button>
          </sui-segment>
        </sui-form>

        <sui-message>Belum punya akun? <router-link :to="{name: 'register'}">Register</router-link></sui-message>
      </sui-grid-column>
    </sui-grid>
  </div>
</template>


<script>

import Message from '../components/Message'
import Loading from '../components/Loading'

export default {
  data: () => ({
    loading: false,
    errors: [],
    message: '',
    email: '',
    password: ''
  }),
  components:{
    Message, Loading
  },
  mounted() {
      console.log('Component mounted.')
  },
  methods:{
    saveForm(e){
      const app = this
      app.loading = true
      axios.post('login',{email:app.email,password:app.password})
      .then((resp) => {
        app.loading = false
        localStorage.setItem('api_token',resp.data.api_token)
        app.$router.push('/home')
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
        let data = []
        app.message = errors.message
        Object.keys(errors.errors).forEach((error) => {
           data.push(errors.errors[error][0])
        })
        app.errors = data
      }
    }
  }
}
</script>

<style lang="css" scoped>  
  .background {
    background-image: url('/images/login-background.jpg') !important;
    background-size: cover !important;
    height: 105vh; 
    padding: 10px;
  }
  .grid {
    height: 100%;
  }
  .column {
    max-width: 450px;
    text-align: center !important;
  }
</style>

