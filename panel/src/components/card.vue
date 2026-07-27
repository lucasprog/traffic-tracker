<template>
  <div class="card">
    <slot/>
  </div>
</template>
<style scoped lang="scss">
@reference 'tailwindcss';
  .card{
    @apply p-4 bg-white shadow rounded-lg flex items-center gap-8;
  }
</style>
