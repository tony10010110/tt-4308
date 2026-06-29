<template>
  <div class="faq-accordion">
    <div
      v-for="item in items"
      :key="item.id"
      class="faq-accordion__item"
      :class="{ 'is-open': openId === item.id }"
    >
      <button
        class="faq-accordion__trigger"
        :aria-expanded="openId === item.id"
        @click="toggle(item.id)"
      >
        <span class="faq-accordion__question">{{ item.question }}</span>
        <span class="faq-accordion__icon" aria-hidden="true">
          <svg v-if="openId === item.id" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="11" width="16" height="2" fill="white"/>
          </svg>
          <svg v-else width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="4" y="11" width="16" height="2" fill="white"/>
            <rect x="11" y="4" width="2" height="16" fill="white"/>
          </svg>
        </span>
      </button>

      <div class="faq-accordion__body" :class="{ 'is-visible': openId === item.id }">
        <p class="faq-accordion__answer">{{ item.answer }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  items: { type: Array, default: () => [] },
})

const openId = ref(null)

function toggle(id) {
  openId.value = openId.value === id ? null : id
}
</script>

<style scoped>
/* Only visible on mobile */
.faq-accordion {
  display: none;
}

@media (max-width: 768px) {
  .faq-accordion {
    display: flex;
    flex-direction: column;
  }
}

.faq-accordion__item {
  border-bottom: 1px solid var(--color-border);
}

.faq-accordion__trigger {
  display: flex;
  align-items: flex-start;
  gap: 24px;
  width: 100%;
  padding: 24px;
  text-align: left;
  cursor: pointer;
}

.faq-accordion__question {
  flex: 1;
  font-family: var(--font-tactic);
  font-weight: 700;
  font-size: 20px;
  line-height: 1;
  letter-spacing: -0.4px;
  text-transform: uppercase;
  color: var(--color-white);
}

.faq-accordion__icon {
  flex-shrink: 0;
  width: 24px;
  height: 24px;
  margin-top: 2px;
}

.faq-accordion__body {
  display: grid;
  grid-template-rows: 0fr;
  transition: grid-template-rows 0.3s ease;
  overflow: hidden;
}

.faq-accordion__body.is-visible {
  grid-template-rows: 1fr;
}

.faq-accordion__answer {
  overflow: hidden;
  padding: 0 24px 24px;
  font-family: var(--font-tektur);
  font-weight: 400;
  font-size: 16px;
  line-height: 1.2;
  letter-spacing: -0.32px;
  color: var(--color-white);
  font-variation-settings: 'wdth' 100;
}
</style>
