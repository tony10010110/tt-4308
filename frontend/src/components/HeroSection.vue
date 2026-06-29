<template>
  <section class="hero" id="hero">
    <div class="hero__bg" :style="bgStyle" />

    <div class="hero__content" ref="contentEl">
      <h1 class="hero__title" ref="titleEl" v-html="titleHtml"></h1>
      <a :href="buttonUrl" class="hero__cta" @click.prevent="scrollTo(buttonUrl)">
        {{ buttonText }}
      </a>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick, watch } from 'vue'

const props = defineProps({
  title:      { type: String, default: 'МААААМ, Я\nВ КАРПАТИ' },
  buttonText: { type: String, default: 'ДІЗНАТИСЯ БІЛЬШЕ' },
  buttonUrl:  { type: String, default: '#routes' },
  bgImage:    { type: String, default: '' },
})

const bgStyle = computed(() => {
  const src = props.bgImage || '/images/hero-bg.jpg'
  return { backgroundImage: `url(${src})` }
})

// Convert newlines / existing <p> to <p> tags for per-line sizing
const titleHtml = computed(() => {
  const raw = (props.title || '').replace(/<p>/gi, '\n').replace(/<\/p>/gi, '')
  return raw.trim().split('\n').filter(Boolean)
    .map(line => `<p>${line.trim()}</p>`)
    .join('')
})

const contentEl = ref(null)
const titleEl   = ref(null)

function fitLines() {
  if (!titleEl.value || !contentEl.value) return
  const availableWidth = contentEl.value.offsetWidth
  if (!availableWidth) return

  titleEl.value.querySelectorAll('p').forEach(p => {
    p.style.fontSize = '200px'
    const naturalWidth = p.scrollWidth
    const fitted = Math.floor(availableWidth / naturalWidth * 200)
    p.style.fontSize = fitted + 'px'
  })
}

let ro
onMounted(async () => {
  await nextTick()
  fitLines()
  ro = new ResizeObserver(fitLines)
  ro.observe(contentEl.value)
})
onUnmounted(() => ro?.disconnect())
watch(titleHtml, async () => { await nextTick(); fitLines() })

function scrollTo(href) {
  if (!href.startsWith('#')) return
  const el = document.querySelector(href)
  if (el) el.scrollIntoView({ behavior: 'smooth' })
}
</script>

<style scoped>
.hero {
  position: relative;
  width: 100%;
  height: 100vh;
  display: flex;
  align-items: flex-end;
  justify-content: flex-end;
  overflow: hidden;
}

.hero__bg {
  position: absolute;
  inset: 0;
  background-size: cover;
  background-position: center;
  background-color: #263d2a;
  background-image:
    linear-gradient(
      160deg,
      #1c3320 0%,
      #2d4a25 30%,
      #3d5e30 55%,
      #2a3d28 75%,
      #1a2a1e 100%
    );
}

.hero__bg::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0.2)  0%,
    rgba(0, 0, 0, 0.1)  40%,
    rgba(0, 0, 0, 0.55) 100%
  );
}

.hero__content {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 0 150px 150px 0;
  width: 100%;
  max-width: 640px;
}

.hero__title {
  font-family: var(--font-primary);
  font-weight: 700;
  line-height: 0.9;
  letter-spacing: -0.02em;
  text-transform: uppercase;
  color: var(--color-white);
  margin-bottom: 32px;
  width: 100%;
}

.hero__title p {
  white-space: nowrap;
  display: block;
  line-height: 0.9;
}

.hero__cta {
  display: block;
  width: 100%;
  padding: 14px 32px;
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 14px;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: var(--color-bg);
  background-color: var(--color-white);
  text-align: center;
  transition: background-color 0.2s, color 0.2s;
  cursor: pointer;
}

.hero__cta:hover {
  background-color: var(--color-red);
  color: var(--color-white);
}

@media (max-width: 768px) {
  .hero__content {
    padding: 0 24px 60px 24px;
    max-width: 100%;
  }
}
</style>
