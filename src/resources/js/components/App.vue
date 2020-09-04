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
