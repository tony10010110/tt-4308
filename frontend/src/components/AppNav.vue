<template>
  <nav class="app-nav" aria-label="Головна навігація">
    <ul class="app-nav__list">
      <li v-for="item in navItems" :key="item.id" class="app-nav__item">
        <a
          :href="item.href"
          class="app-nav__link"
          :class="{ 'is-active': activeSection === item.id }"
          @click.prevent="scrollTo(item.href)"
        >
          {{ item.label }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const navItems = [
  { id: 'prices',    label: 'ЦІНИ',        href: '#prices' },
  { id: 'about',     label: 'ПРО МАУНТІ',  href: '#about' },
  { id: 'equipment', label: 'СПОРЯДЖЕННЯ', href: '#equipment' },
  { id: 'routes',    label: 'МАРШРУТИ',    href: '#routes' },
  { id: 'faq',       label: 'FAQ',         href: '#faq' },
]

const activeSection = ref('')

function scrollTo(href) {
  const el = document.querySelector(href)
  if (el) {
    el.scrollIntoView({ behavior: 'smooth' })
  }
}

function onScroll() {
  for (const item of navItems) {
    const el = document.getElementById(item.id)
    if (!el) continue
    const rect = el.getBoundingClientRect()
    if (rect.top <= 100 && rect.bottom > 100) {
      activeSection.value = item.id
      return
    }
  }
}

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }))
onUnmounted(() => window.removeEventListener('scroll', onScroll))
</script>

<style scoped>
.app-nav {
  position: fixed;
  top: var(--header-height);
  left: 0;
  z-index: 90;
  display: flex;
  flex-direction: column;
  justify-content: center;
  height: calc(100vh - var(--header-height));
  padding: 40px 0;
}

.app-nav__list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.app-nav__link {
  display: block;
  padding: 8px 20px;
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.04em;
  color: var(--color-white);
  opacity: 0.5;
  transition: opacity 0.2s, background-color 0.2s;
  white-space: nowrap;
}

.app-nav__link:hover,
.app-nav__link.is-active {
  opacity: 1;
  background-color: var(--color-red);
  padding-left: 20px;
}
</style>
