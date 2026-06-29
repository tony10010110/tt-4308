<template>
  <div>
    <h2 class="page-title">Dashboard</h2>
    <div class="cards">
      <router-link v-for="item in cards" :key="item.to" :to="item.to" class="card">
        <span class="card__label">{{ item.label }}</span>
        <span class="card__arrow">→</span>
      </router-link>
    </div>
  </div>
</template>

<script setup>
const cards = [
  { to: '/admin/hero',      label: 'Hero секція' },
  { to: '/admin/routes',    label: 'Маршрути' },
  { to: '/admin/equipment', label: 'Спорядження' },
  { to: '/admin/prices',    label: 'Ціни' },
  { to: '/admin/faq',       label: 'FAQ' },
]
</script>

<style scoped>
.page-title {
  font-size: 24px;
  font-weight: 700;
  letter-spacing: -0.01em;
  margin-bottom: 32px;
  color: var(--color-white);
}

.cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 16px;
}

.card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 24px;
  border: 1px solid var(--color-border);
  color: var(--color-white);
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  transition: border-color 0.2s, background-color 0.2s;
}

.card:hover {
  border-color: rgba(255,255,255,0.5);
  background-color: rgba(255,255,255,0.03);
}

.card__arrow {
  opacity: 0.4;
}
</style>
