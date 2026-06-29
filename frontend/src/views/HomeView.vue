<template>
  <div class="home-layout">
    <AppHeader />
    <AppNav />

    <main class="home-main">
      <HeroSection
        :title="hero.title"
        :button-text="hero.button_text"
        :button-url="hero.button_url"
        :bg-image="hero.background"
      />
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AppHeader from '@/components/AppHeader.vue'
import AppNav from '@/components/AppNav.vue'
import HeroSection from '@/components/HeroSection.vue'

const hero = ref({
  title:       'МААААМ, Я\nВ КАРПАТИ',
  button_text: 'ДІЗНАТИСЯ БІЛЬШЕ',
  button_url:  '#routes',
  background:  '',
})

onMounted(async () => {
  try {
    const { data } = await axios.get('/api/v1/hero')
    if (data) {
      hero.value = {
        title:       (data.title || '').replace(/\\n/g, '\n'),
        button_text: data.button_text || 'ДІЗНАТИСЯ БІЛЬШЕ',
        button_url:  data.button_url  || '#routes',
        background:  data.background  || '',
      }
    }
  } catch {
    // use defaults
  }
})
</script>

<style scoped>
.home-layout {
  height: 100vh;
  overflow: hidden;
}

.home-main {
  height: 100vh;
  overflow-y: auto;
  overflow-x: hidden;
  scroll-snap-type: y mandatory;
}

.home-main > * {
  scroll-snap-align: start;
}
</style>
