
<template>
  <nav
    class="navbar navbar-expand-lg bg-primary"
    data-bs-theme="dark"
  >
    <div class="container">
      <a
        class="navbar-brand"
        href="#"
      >Jukebox</a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbar"
        aria-controls="navbar"
        aria-expanded="false"
      >
        <span class="navbar-toggler-icon" />
      </button>
      <div
        class="collapse navbar-collapse d-flex justify-content-end"
        id="navbar"
      >
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <router-link
              class="nav-link"
              to="/"
            >
              Início
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link"
              to="/tasks"
            >
              Tasks
            </router-link>
          </li>
          <li class="nav-item">
            <router-link
              v-if="!authenticated"
              class="nav-link"
              to="/login"
            >
              Login
            </router-link>
          </li>
          <li class="nav-item">
            <a
              v-if="authenticated"
              class="nav-link"
              type="button"
              @click="logout"
            >Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { isAuthenticated } from '@/services/authService';
import { logout } from '@/services/loginService';

export default{
  name: 'MenuComponent',

  data() {
    return {
      authenticated: false
    };
  },

  created() {
    this.authenticated = isAuthenticated();
  },

  methods: {
    logout() {
      logout();
      this.authenticated = false;
      this.$router.push('/login');
    }
  }

};
</script>
