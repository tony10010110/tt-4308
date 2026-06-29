<template>
  <!-- Desktop: 5-column icon row -->
  <div class="faq-services">
    <div
      v-for="service in services"
      :key="service.type"
      class="faq-services__cell"
      :class="{ 'is-active': service.active }"
      :style="service.active ? { backgroundColor: service.color } : {}"
    >
      <div class="faq-services__icon-wrap">
        <img
          :src="service.icon"
          :alt="service.label"
          class="faq-services__icon"
        />
      </div>
    </div>
  </div>

  <!-- Mobile: active card (full width) -->
  <div
    v-if="activeService"
    class="faq-services__active-card"
    :style="{ backgroundColor: activeService.color }"
  >
    <div class="faq-services__active-inner">
      <img :src="activeService.icon" :alt="activeService.label" class="faq-services__active-icon" />
      <p class="faq-services__active-label">{{ activeService.label }}</p>
    </div>
  </div>
</template>

<script setup>
const services = [
  { type: 'avia',    icon: '/icons/airplane.svg', label: 'Допомога в купівлі авіаквитків', color: 'var(--color-avia)',    active: false },
  { type: 'walk',    icon: '/icons/walk.svg',     label: 'Планування піших маршрутів',    color: 'var(--color-walk)',    active: false },
  { type: 'bicycle', icon: '/icons/bicycle.svg',  label: 'Оренда велосипедів і планування маршрутів', color: 'var(--color-bicycle)', active: true },
  { type: 'jeeping', icon: '/icons/car.svg',      label: 'Ми не займаємось джипінгом',   color: 'var(--color-jeeping)', active: false },
  { type: 'fishing', icon: '/icons/boat.svg',     label: 'Яхт-тури Ужем і Тисою',        color: 'var(--color-fishing)', active: false },
]

const activeService = services.find(s => s.active) ?? null
</script>

<style scoped>
/* ─── Desktop: horizontal row ─────────────────────────────────── */
.faq-services {
  display: flex;
  width: 100%;
  border-bottom: 1px solid var(--color-border);
}

.faq-services__cell {
  flex: 1 0 0;
  min-width: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  aspect-ratio: 1 / 1;
  border-right: 1px solid var(--color-border);
  overflow: hidden;
}

.faq-services__cell:last-child {
  border-right: none;
}

.faq-services__icon-wrap {
  width: 48px;
  height: 48px;
  flex-shrink: 0;
}

.faq-services__icon {
  width: 100%;
  height: 100%;
  object-fit: contain;
  filter: brightness(0) invert(1);
  opacity: 0.55;
}

.faq-services__cell.is-active .faq-services__icon {
  opacity: 1;
}

/* ─── Mobile: expanded active card ───────────────────────────── */
.faq-services__active-card {
  display: none;
  width: 100%;
  aspect-ratio: 1 / 1;
  align-items: center;
  justify-content: center;
  border-bottom: 1px solid var(--color-border);
}

.faq-services__active-inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 24px;
}

.faq-services__active-icon {
  width: 160px;
  height: 160px;
  object-fit: contain;
  filter: brightness(0) invert(1);
}

.faq-services__active-label {
  font-family: var(--font-primary);
  font-weight: 600;
  font-size: 18px;
  line-height: 1;
  letter-spacing: -0.36px;
  text-transform: uppercase;
  text-align: center;
  color: var(--color-white);
  max-width: 280px;
}

@media (max-width: 768px) {
  .faq-services__active-card {
    display: flex;
  }
}
</style>
