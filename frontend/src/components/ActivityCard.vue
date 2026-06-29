<template>
  <button
    class="activity-card"
    :class="[`activity-card--${type}`, { 'is-open': isOpen }]"
    @click="$emit('select')"
    :aria-expanded="isOpen"
  >
    <div class="activity-card__inner">
      <!-- Icon -->
      <div class="activity-card__icon">
        <img
          :src="icon"
          :alt="label"
          class="activity-card__icon-img"
          :class="{ 'is-filled': isOpen }"
        />
      </div>

      <!-- Label — visible only when open -->
      <p v-if="isOpen" class="activity-card__label">{{ label }}</p>
    </div>
  </button>
</template>

<script setup>
defineProps({
  type:   { type: String,  required: true },
  label:  { type: String,  required: true },
  icon:   { type: String,  required: true },
  isOpen: { type: Boolean, default: false },
})
defineEmits(['select'])
</script>

<style scoped>
.activity-card {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  overflow: hidden;
  transition: width 0.45s cubic-bezier(0.4, 0, 0.2, 1),
              flex 0.45s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  border: none;
  background: transparent;
  border-right: 1px solid var(--color-border);
  flex: 1 0 0;
  min-width: 0;
  padding: 40px;
}

.activity-card:last-child {
  border-right: none;
}

/* Open = fixed wide width + colored bg */
.activity-card.is-open {
  flex: 0 0 auto;
  width: 420px;
}

.activity-card--avia.is-open    { background-color: var(--color-avia); }
.activity-card--walk.is-open    { background-color: var(--color-walk); }
.activity-card--bicycle.is-open { background-color: var(--color-bicycle); }
.activity-card--jeeping.is-open { background-color: var(--color-jeeping); }
.activity-card--fishing.is-open { background-color: var(--color-fishing); }

.activity-card__inner {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 24px;
}

.activity-card__icon {
  width: 80px;
  height: 80px;
  flex-shrink: 0;
}

.activity-card__icon-img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  filter: brightness(0) invert(1);
  opacity: 0.6;
  transition: opacity 0.3s;
}

.activity-card.is-open .activity-card__icon-img {
  opacity: 1;
}

.activity-card__label {
  font-family: var(--font-primary);
  font-weight: 600;
  font-size: 15px;
  line-height: 1.2;
  letter-spacing: -0.02em;
  text-transform: uppercase;
  text-align: center;
  color: var(--color-white);
  max-width: 240px;
}
</style>
