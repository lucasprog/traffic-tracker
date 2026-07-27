<script setup lang="ts">
  import Menu from "../components/menu.vue";
  import Card from "../components/card.vue";
   import Modal from "../components/modal.vue";
  import Alert from "../components/alert.vue";
  import {useWebSitesStore} from "../stores/websites.ts";

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

</script>
<template>
  <header>
    <Menu />
  </header>
    <main>
      <slot />
    </main>
  <footer>
    <Card>
      Made by Lucas S. Jesus &copy; 2026
    </Card>
  </footer>
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

header,footer{
  @apply p-2 w-full;
}

main{
  @apply p-4 w-full;
}

form{
    @apply
      flex flex-col gap-4
    ;

    button{
      @apply py-2 px-4 max-w-[120px] bg-green-600 text-white rounded hover:opacity-80;
    }


  }

</style>
