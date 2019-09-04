<template>
  <header class="app-header navbar">
    <b-link class="navbar-brand" to="/dashboard">
    </b-link>
    <div class="navbar-title">
      <h4 class="m-0">{{title}}</h4>
    </div>
    <b-navbar-nav v-if="userName" class="ml-auto">
      <HeaderDropdownAccnt/>
    </b-navbar-nav>
  </header>
</template>

<script>
  import HeaderDropdownAccnt from './HeaderDropdownAccnt.vue';

  export default {
    name: 'app-header',

    data () {
      return {
        title: "Test"
      }
    },
    components: {
      HeaderDropdownAccnt
    },

    computed: {
      userName () {
        if (this.$store.state.userInfo.name) {
          return this.$store.state.userInfo.name.charAt(0).toUpperCase();
        }
        return '';
      }
    },
  }
</script>

<style scoped>
  .navbar-title {
    margin-right: auto !important;
  }
</style>