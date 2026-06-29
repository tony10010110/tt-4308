<template>
  <router-view />
</template>

<script setup>
import { watch } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

watch(
  () => route.meta.bodyClass,
  (cls, prev) => {
    if (prev) document.body.classList.remove(prev)
    if (cls)  document.body.classList.add(cls)
  },
  { immediate: true },
)
</script>
