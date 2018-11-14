<template>
    <div>
      <Header style="margin-top: 70px;"/>
      <sui-container fluid>
          <slot/>
      </sui-container>
    </div>
</template>

<style>
    .responsive {
      float: right;
      width: 100%;
      overflow: scroll;
      overflow-y: hidden;
    }
    .ui.menu {
        border: 1px solid #ffffff !important;
        box-shadow: 0 1px 2px 0 #ffffff !important;
    }
</style>

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
