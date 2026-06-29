<template>
  <section class="activity-selector" id="routes" aria-label="Наші активності">
    <ActivityCard
      v-for="activity in activities"
      :key="activity.type"
      v-bind="activity"
      :isOpen="openType === activity.type"
      @select="toggle(activity.type)"
    />
  </section>
</template>

<script setup>
import { ref } from 'vue'
import ActivityCard from './ActivityCard.vue'

const openType = ref(null)

const activities = [
  {
    type:  'avia',
    label: 'Допомога в купівлі авіаквитків для туристів не з України',
    icon:  '/icons/airplane.svg',
  },
  {
    type:  'walk',
    label: 'Планування піших маршрутів',
    icon:  '/icons/walk.svg',
  },
  {
    type:  'bicycle',
    label: 'Оренда велосипедів і планування маршрутів',
    icon:  '/icons/bicycle.svg',
  },
  {
    type:  'jeeping',
    label: 'Ми не займаємось джипінгом, бо це ницо',
    icon:  '/icons/car.svg',
  },
  {
    type:  'fishing',
    label: 'Яхт-тури Ужем і Тисою',
    icon:  '/icons/boat.svg',
  },
]

function toggle(type) {
  openType.value = openType.value === type ? null : type
}
</script>

<style scoped>
.activity-selector {
  display: flex;
  height: 440px;
  border-top: 1px solid var(--color-border);
  border-bottom: 1px solid var(--color-border);
  overflow: hidden;
}

@media (max-width: 768px) {
  .activity-selector {
    height: auto;
    flex-direction: column;
  }
}
</style>
