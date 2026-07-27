<script setup >
  import Menu from "../components/menu.vue";
  import Card from "../components/card.vue";
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
</template>
<style scoped lang="scss">
@reference 'tailwindcss';

header,footer{
  @apply p-2 w-full;
}

main{
  @apply p-4 w-full;
}

</style>
