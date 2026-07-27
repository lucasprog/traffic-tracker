<script setup lang="ts">
  import {useWebSitesStore} from "../stores/websites.ts";

  import { computed, onMounted, ref } from "vue";

  onMounted(function(){
    useWebSitesStore().get();
  });

  const data = computed(() => useWebSitesStore().websitesData);

  const onEdit = (website) => {
    useWebSitesStore().openModal();
    useWebSitesStore().formEditId = website.id;
    useWebSitesStore().setForm(website.name, website.domain);
  }

  const onDelete = async (website) => {
    useWebSitesStore().formEditId = website.id;
    await useWebSitesStore().delete();
    await useWebSitesStore().get();
  }
</script>
<template>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Domain</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="d in data">
        <td>{{d.id}}</td>
        <td>{{d.name}}</td>
        <td>{{d.domain}}</td>
        <td>
          <button class="btn btn-edit" @click="onEdit(d)">
            Edit
          </button>
          <button class="btn btn-delete" @click="onDelete(d)">
            Delete
          </button>
          <router-link :to="`/pages/${d.id}`">View Data Pages</router-link to="/">
        </td>
      </tr>
    </tbody>
  </table>

</template>
<style scoped lang="scss">
@reference 'tailwindcss';

  table{
    @apply w-full ;
  }



  .btn{
    @apply px-4 py-1 max-w-[100px] rounded mr-4 mb-2 hover:opacity-80;
    &-edit{
      @apply bg-blue-600 text-white;
    }
    &-delete{
      @apply bg-red-600 text-white;
    }
  }
</style>
