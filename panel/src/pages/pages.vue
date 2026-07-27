<script setup lang="ts">
  import { useRoute } from "vue-router";
  import { usePagesStore } from "../stores/pages.ts";
  import { useWebSitesStore } from "../stores/websites.ts";
  import { onMounted, computed } from "vue";
  import Card from "../components/card.vue";

  const route = useRoute();

  usePagesStore().websiteId = route.params.website;

  const data = computed(() => usePagesStore().pagesData);

  onMounted(async function(){
    await useWebSitesStore().get();
    await usePagesStore().get();
  })

  const search = () => {
    usePagesStore().get();
  }

</script>
<template>
  <Card>
    <form @submit.prevent="search">
        <input type="date" v-model="usePagesStore().form.start_at" placeholder="Start period"/>
        <input type="date" v-model="usePagesStore().form.end_at" placeholder="End period"/>
        <button type="submit">Search</button>
    </form>
  </Card>
  <table>
    <thead>
      <tr>
        <th>Page Name</th>
        <th>Route</th>
        <th>Qtd Visits</th>
        <th>Website</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="d in data">
        <td>{{d.name}}</td>
        <td>{{d.route}}</td>
        <td>{{d.unique_visits}}</td>
        <td>{{ usePagesStore().findWebsite(d.website_id)?.name??"" }}</td>
      </tr>
    </tbody>
  </table>
</template>
<style scoped lang="scss">
@reference 'tailwindcss';

  table{
    @apply w-full mt-8;
  }

  form{
    @apply flex gap-4;
    input{
      @apply bg-gray-100 px-4 py-2;
    }
    button{
      @apply bg-green-500 px-8 py-2 text-white;
    }
  }

</style>
