<template>
  <header>
    <MenuComponent />
  </header>
  <div class="container">
    <router-view />
  </div>
</template>

<script>

import MenuComponent from '@/components/MenuComponent.vue';

export default {
  name: 'App',
  components: {
    MenuComponent
  }
};
</script>
