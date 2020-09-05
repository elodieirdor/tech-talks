<template>
  <div>
  <b-navbar toggleable="lg" type="dark" variant="info">
    <b-navbar-brand :to="{ name: 'index' }">Tech talks</b-navbar-brand>
      <b-navbar-nav class="ml-auto">
          <b-nav-item-dropdown right v-if="$store.state.user">
              <template v-slot:button-content>
                  <em>{{$store.state.user.name}}</em>
              </template>
              <b-dropdown-item href="#">My talks</b-dropdown-item>
              <b-dropdown-item href="#">Sign Out</b-dropdown-item>
          </b-nav-item-dropdown>
          <b-navbar-nav right v-else>
              <b-nav-item :to="{ name: 'login' }">Login</b-nav-item>
              <b-nav-item :to="{ name: 'register' }">Register</b-nav-item>
          </b-navbar-nav>
      </b-navbar-nav>

  </b-navbar>
</div>
</template>

<script>
export default {
  name: 'AppHeader',
}
</script>
