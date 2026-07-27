<script lang="ts" setup>
defineProps<{
  show: boolean
  close: () => void
}>()
</script>
<template>
  <Teleport to="body">
    <div class="modal" v-if="show">
      <div class="modal-back" v-if="show" @click="close()"></div>
      <div class="modal__screen">
        <slot />
      </div>
    </div>
  </Teleport>
</template>
<style scoped lang="scss">
@reference 'tailwindcss';
.modal {
  @apply fixed top-0 left-0 w-full h-full flex items-center justify-center z-90;

  &-back {
    @apply fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black opacity-50 z-50;
  }

  &__screen {
    @apply bg-gray-200 text-gray-800 p-8 rounded shadow-lg z-100 w-full max-w-2xl;
  }

}
</style>
