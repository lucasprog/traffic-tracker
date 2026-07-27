<script setup lang="ts">
defineProps<{
  title: string
  message: string
  type: 'success' | 'error' | 'warning' | 'info'
}>()
</script>
<template>
  <div :class="`${type} flex flex-col`" role="alert">
    <strong class="font-bold">{{ title }}</strong>
    <span class="block sm:inline"> {{ message }} </span>
  </div>
</template>
<style scoped>
.success {
  background-color: #3dd861;
  color: #111d14;
  border: 1px solid #3dd861;
  padding: 10px;
  border-radius: 5px;
}
.error {
  background-color: #b10516;
  color: #f8d7da;
  border: 1px solid #b10516;
  padding: 10px;
  border-radius: 5px;
}
.warning {
  background-color: #dbad21;
  color: #25200f;
  border: 1px solid #dbad21;
  padding: 10px;
  border-radius: 5px;
}
.info {
  background-color: #0c5460;
  color: #bee5eb;
  border: 1px solid #0c5460;
  padding: 10px;
  border-radius: 5px;
}
</style>
