<template>
  <div class="faq-grid">
    <div
      v-for="(item, i) in visibleItems"
      :key="item.id"
      class="faq-grid__cell"
      :class="{
        'faq-grid__cell--row-last': isLastInRow(i),
        'faq-grid__cell--empty': !item.question,
      }"
    >
      <p class="faq-grid__question">{{ item.question }}</p>
      <p class="faq-grid__answer">{{ item.answer }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    default: () => [],
  },
  columns: {
    type: Number,
    default: 3,
  },
})

// Fill to a full grid (multiple of columns), last cell may be empty placeholder
const visibleItems = computed(() => {
  const list = [...props.items]
  const remainder = list.length % props.columns
  if (remainder !== 0) {
    const fill = props.columns - remainder
    for (let i = 0; i < fill; i++) {
      list.push({ id: `empty-${i}`, question: '', answer: '' })
    }
  }
  return list
})

function isLastInRow(index) {
  return (index + 1) % props.columns === 0
}
</script>

<style scoped>
.faq-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  border-top: 1px solid var(--color-border);
}

.faq-grid__cell {
  display: flex;
  flex-direction: column;
  gap: 24px;
  padding: 40px;
  border-right: 1px solid var(--color-border);
  border-bottom: 1px solid var(--color-border);
}

.faq-grid__cell--row-last {
  border-right: none;
}

.faq-grid__cell--empty {
  opacity: 0;
  pointer-events: none;
}

.faq-grid__question {
  font-family: var(--font-tactic);
  font-weight: 500;
  font-size: 24px;
  line-height: 1;
  letter-spacing: -0.48px;
  text-transform: uppercase;
  color: var(--color-white);
}

.faq-grid__answer {
  font-family: var(--font-tektur);
  font-weight: 400;
  font-size: 16px;
  line-height: 1.2;
  letter-spacing: -0.32px;
  color: var(--color-white);
  font-variation-settings: 'wdth' 100;
}

/* Hide on mobile — accordion takes over */
@media (max-width: 768px) {
  .faq-grid {
    display: none;
  }
}
</style>
