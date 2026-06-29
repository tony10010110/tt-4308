<template>
  <div class="home-layout">
    <AppHeader />
    <AppNav />

    <main class="home-main">
      <!-- Hero -->
      <HeroSection
        :title="hero.title"
        :button-text="hero.button_text"
        :button-url="hero.button_url"
        :bg-image="hero.background"
      />

      <!-- Activity Selector -->
      <ActivitySelector />

      <!-- Other sections (placeholder until designed) -->
      <section id="prices"    class="section-placeholder"><span>ЦІНИ</span></section>
      <section id="about"     class="section-placeholder"><span>ПРО МАУНТІ</span></section>
      <section id="equipment" class="section-placeholder"><span>СПОРЯДЖЕННЯ</span></section>
      <section id="faq"       class="section-placeholder"><span>FAQ</span></section>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AppHeader from '@/components/AppHeader.vue'
import AppNav from '@/components/AppNav.vue'
import HeroSection from '@/components/HeroSection.vue'
import ActivitySelector from '@/components/ActivitySelector.vue'

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
        title:      (data.title || '').replace(/\\n/g, '\n'),
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
  min-height: 100vh;
  background-color: var(--color-bg);
}

.home-main {
  padding-top: var(--header-height);
  overflow-y: auto;
  height: calc(100vh - var(--header-height));
}

/* Temporary placeholders for sections not yet designed */
.section-placeholder {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  border-top: 1px solid var(--color-border);
}

.section-placeholder span {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 14px;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  opacity: 0.3;
}
</style>
