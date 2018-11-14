<template>
    <div>
      <Header style="margin-top: 70px;"/>
      <sui-container fluid style="padding-left: 18%">
          <slot/>
      </sui-container>
    </div>
</template>

<script>
  import Dashboard from '../pages/dashboard'
  import Footer from '../components/Footer'
  import Header from '../components/Header'

  export default {
    components:{
      Dashboard,Footer,Header
   }
  }
</script>
