<template lang="html">
  <div>
    <sui-menu fixed inverted>
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
    
    <div class="ui inverted vertical pointing menu fixed" style="height: 100%">
      <router-link :to="{name: 'home'}" class="item" v-if="this.$store.state.user.loggedIn">
        <i class="th list icon"></i> MHA - DEV
      </router-link>
      
      <div class="item">
        <i class="angle down icon"></i> Master Data
        <div class="menu" style="padding-left: 15px">
          <a class="item">Daftar Akun</a>
          <a class="item">Investor</a>
          <router-link :to="{name: 'user'}" class="item" v-if="this.$store.state.user.loggedIn">
              User
          </router-link>
        </div>
     </div>

      <a class="item"><i class="gamepad icon"></i> Games </a>
      <a class="item"><i class="video camera icon"></i> Channels </a>
      <a class="item"><i class="video play icon"></i> Videos </a>
    </div>
  </div>
</template>

<script>
  export default {
    mounted(){
      const app = this
      const pelanggan = app.$store.state.user.profile.id 
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
