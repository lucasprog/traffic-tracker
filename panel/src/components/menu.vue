<script setup>
  import Card from "../components/card.vue";
  import {useWebSitesStore} from "../stores/websites.ts";
</script>
<template>
  <Card>
   <div class="inner-menu">
      <h1>Traffic Tracker</h1>
      <nav>
        <ul>
          <li>
            <router-link to="/">Websites</router-link>
          </li>
          <li>
            <router-link to="/pages/all">Pages</router-link>
          </li>
        </ul>
      </nav>
      <button @click="useWebSitesStore().openModal()">New Website</button>
   </div>
  </Card>
</template>
<style scoped lang="scss">
@reference 'tailwindcss';
  nav {
    ul{
      @apply flex items-center justify-between gap-4;
    }
  }

  .inner-menu{
    @apply flex items-center justify-between gap-4 w-full;
  }

  button{
    @apply bg-blue-500 px-8 py-4 rounded text-white hover:opacity-90;
  }
</style>
