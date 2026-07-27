<script setup>
  import {useWebSitesStore} from "../../stores/websites.ts";
  import Modal from "../../components/modal.vue";
  import Alert from "../../components/alert.vue";

  import { computed, onMounted, ref } from "vue";

  const webSitesStore = useWebSitesStore();

  onMounted(function(){
    useWebSitesStore().get();
  });

  const data = computed(() => useWebSitesStore().websitesData);

  const closeModal = () => {
    useWebSitesStore().closeModal()
  }

  const submit = async () => {
    if( useWebSitesStore().formEditId )
    {
      await useWebSitesStore().update();
    }else{
      await useWebSitesStore().save();
    }
    useWebSitesStore().get();
  }

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
        </td>
      </tr>
    </tbody>
  </table>
  <Modal :show="useWebSitesStore().modal" :close="closeModal">
    <form @submit.prevent="submit()">
      <input v-model="useWebSitesStore().form.name" name="name" placeholder="Please input the name of Website" />
      <input v-model="useWebSitesStore().form.domain" name="domain" placeholder="Please input the domain of Website" />
      <button type="submit">Save</button>
      <Alert
        v-if="useWebSitesStore().message.type"
        :message="useWebSitesStore().message.message"
        :type="useWebSitesStore().message.type"
        :title="useWebSitesStore().message.title"
      />
    </form>
  </Modal>
</template>
<style scoped lang="scss">
@reference 'tailwindcss';

  table{
    @apply w-full ;
  }

  form{
    @apply
      flex flex-col gap-4
    ;

    button{
      @apply py-2 px-4 max-w-[120px] bg-green-600 text-white rounded hover:opacity-80;
    }


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
