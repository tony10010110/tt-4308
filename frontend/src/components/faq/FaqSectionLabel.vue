<template>
  <div class="faq-section-label">
    <span class="faq-section-label__text">{{ title }}</span>
  </div>
</template>

<script setup>
defineProps({
  title: { type: String, required: true },
})
</script>

<style scoped>
.faq-section-label {
  display: flex;
  align-items: center;
  height: 80px;
  padding: 0 40px;
  border-top: 1px solid var(--color-border);
  border-bottom: 1px solid var(--color-border);
}

.faq-section-label__text {
  font-family: var(--font-tactic);
  font-weight: 700;
  font-size: 28px;
  line-height: 1;
  letter-spacing: -0.56px;
  text-transform: uppercase;
  color: var(--color-white);
  white-space: nowrap;
}

@media (max-width: 768px) {
  .faq-section-label {
    height: 68px;
    padding: 0 24px;
  }
}
</style>
