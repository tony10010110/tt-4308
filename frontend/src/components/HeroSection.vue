<template>
  <section class="hero" id="hero">
    <!-- Background image -->
    <div
      class="hero__bg"
      :style="bgImage ? { backgroundImage: `url(${bgImage})` } : {}"
    />

    <!-- Content -->
    <div class="hero__content">
      <h1 class="hero__title">
        {{ title }}
      </h1>
      <a :href="buttonUrl" class="hero__cta" @click.prevent="scrollTo(buttonUrl)">
        {{ buttonText }}
      </a>
    </div>
  </section>
</template>

<script setup>
const props = defineProps({
  title:      { type: String,  default: 'МААААМ, Я\nВ КАРПАТИ' },
  buttonText: { type: String,  default: 'ДІЗНАТИСЯ БІЛЬШЕ' },
  buttonUrl:  { type: String,  default: '#routes' },
  bgImage:    { type: String,  default: '' },
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
  background-color: #1a2a1a;
}

/* Dark gradient overlay — right side stays dark for text readability */
.hero__bg::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to bottom,
    rgba(0, 0, 0, 0.25) 0%,
    rgba(0, 0, 0, 0.15) 50%,
    rgba(0, 0, 0, 0.55) 100%
  );
}

.hero__content {
  position: relative;
  z-index: 1;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 0;
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

/* ─── Responsive ─────────────────────────────────────────────── */
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
