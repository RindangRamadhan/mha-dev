<template lang="html">
  <div>
    <sui-menu fixed inverted>
      <a class="item" @click="sideBar()">
        <i class="sidebar icon"></i>
        Menu
      </a>
      <sui-menu-menu position="right">
        <router-link :to="{name: 'login'}" 
          class="item"
          v-if="!this.$store.state.user.loggedIn">
            Login
        </router-link>

        <router-link :to="{name: 'register'}"
          class="item"
          v-if="!this.$store.state.user.loggedIn">
            Register
        </router-link>

        <sui-dropdown 
          icon="user circle"
          v-bind:text="this.$store.state.user.profile.name"
          item class="simple"
          v-if="this.$store.state.user.loggedIn">
              <sui-dropdown-menu>
                  <router-link :to="{name: 'profil'}"
                    class="item"
                    v-if="this.$store.state.user.loggedIn">
                      Profil
                  </router-link>
                  <router-link :to="{name: 'logout'}"
                    class="item"
                    v-if="this.$store.state.user.loggedIn">
                      Logout
                  </router-link>
              </sui-dropdown-menu>
        </sui-dropdown>
      </sui-menu-menu>
    </sui-menu>
    
    <div class="ui inverted vertical pointing menu fixed sidebar" style="height: 100%">
      <router-link :to="{name: 'home'}" class="item" v-if="this.$store.state.user.loggedIn">
        <i class="th list icon"></i> MHA - DEV
      </router-link>
      
      <div class="item">
        <i class="angle down icon"></i> Master Data
        <div class="menu" style="padding-left: 15px">
          <router-link :to="{name: 'daftar_akun'}" class="item" v-if="this.$store.state.user.loggedIn">
              Daftar Akun
          </router-link>
          <router-link :to="{name: 'iklan'}" class="item" v-if="this.$store.state.user.loggedIn">
              Iklan
          </router-link>
          <router-link :to="{name: 'server'}" class="item" v-if="this.$store.state.user.loggedIn">
              Server
          </router-link>
          <router-link :to="{name: 'user'}" class="item" v-if="this.$store.state.user.loggedIn">
              User
          </router-link>
        </div>
     </div>
      <a class="item"><i class="chart line icon"></i> Profit Harian</a>
      <a class="item"><i class="clipboard list icon"></i> Laporan Periode </a>
    </div>
  </div>
</template>

<script>
  export default {
    mounted(){
      const app = this
      const pelanggan = app.$store.state.user.profile.id 
    },
    methods: {
      sideBar() {
        $('.ui.pointing.menu.sidebar')
          .sidebar('toggle')
        ;
      }
    }
  }
</script>

<style lang="css" scoped>
img.logo {
  margin-right: 1.5em !important;
}
.main {
  margin-top: 7em;
}
.wireframe {
  margin: 2em 0;
}
.footer {
  margin: 5em 0em 0em;
  padding: 5em 0em;
}
</style>
