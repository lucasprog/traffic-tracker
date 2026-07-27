<script setup lang="ts">
import LayoutPanel from "./layouts/layout-panel.vue"
import { RouterView } from 'vue-router'
</script>

<template>
  <LayoutPanel>
    <RouterView />
  </LayoutPanel>
</template>

<style lang="scss" scoped>
@reference 'tailwindcss';
app {
  @apply flex flex-col items-center justify-center min-h-screen h-full w-full;
}
</style>
