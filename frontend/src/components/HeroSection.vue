<template>
  <section class="hero" id="hero">
    <div class="hero__bg" :style="bgStyle" />

    <div class="hero__content">
      <h1 class="hero__title">{{ title }}</h1>
      <a :href="buttonUrl" class="hero__cta" @click.prevent="scrollTo(buttonUrl)">
        {{ buttonText }}
      </a>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title:      { type: String, default: 'МААААМ, Я\nВ КАРПАТИ' },
  buttonText: { type: String, default: 'ДІЗНАТИСЯ БІЛЬШЕ' },
  buttonUrl:  { type: String, default: '#routes' },
  bgImage:    { type: String, default: '' },
})

// Use API image if available, otherwise fall back to local asset
const bgStyle = computed(() => {
  const src = props.bgImage || '/images/hero-bg.jpg'
  return { backgroundImage: `url(${src})` }
})

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
  height: calc(100vh - var(--header-height));
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
  /* Gradient fallback while image loads or if image is missing */
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
  padding: 0 80px 80px 0;
  max-width: 640px;
}

.hero__title {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: clamp(56px, 8vw, 100px);
  line-height: 0.9;
  letter-spacing: -0.02em;
  text-transform: uppercase;
  color: var(--color-white);
  white-space: pre-line;
  margin-bottom: 32px;
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

  .hero__title {
    font-size: clamp(40px, 12vw, 64px);
  }
}
</style>
