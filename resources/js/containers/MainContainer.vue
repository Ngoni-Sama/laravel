<template>
  <div class="app">
    <app-header></app-header>
    <div class="app-body">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
  import AppHeader from "../components/Header/Header";

  export default {
    name: "main-container",
    components: {
      AppHeader
    }
  }
</script>

<style scoped>

</style>