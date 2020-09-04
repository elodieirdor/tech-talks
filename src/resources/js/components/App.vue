<template>
  <div>
    <AppHeader />
    <b-container fluid="xl" class="main-container">
      <router-view />
    </b-container>
  </div>
</template>

<script>
import AppHeader from "./layout/AppHeader";
export default {
  name: "App",
  components: {
    AppHeader,
  },
};
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
.main-container{
  margin-top: 20px;
}
</style>