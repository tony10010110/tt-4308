<template>
  <div class="login-page">
    <form class="login-form" @submit.prevent="submit">
      <div class="login-form__logo">MOUNTY</div>
      <h1 class="login-form__title">Адмін панель</h1>

      <div class="login-form__field">
        <label>Email</label>
        <input v-model="email" type="email" required autocomplete="username" />
      </div>

      <div class="login-form__field">
        <label>Пароль</label>
        <input v-model="password" type="password" required autocomplete="current-password" />
      </div>

      <p v-if="error" class="login-form__error">{{ error }}</p>

      <button type="submit" class="login-form__btn" :disabled="loading">
        {{ loading ? 'Вхід...' : 'Увійти' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth     = useAuthStore()
const router   = useRouter()
const email    = ref('')
const password = ref('')
const error    = ref('')
const loading  = ref(false)

async function submit() {
  error.value   = ''
  loading.value = true
  try {
    await auth.login(email.value, password.value)
    router.push('/admin')
  } catch (e) {
    error.value = e?.response?.data?.message || 'Невірний email або пароль'
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: var(--color-bg);
}

.login-form {
  width: 100%;
  max-width: 400px;
  padding: 48px 40px;
  border: 1px solid var(--color-border);
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.login-form__logo {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 18px;
  letter-spacing: 0.06em;
  color: var(--color-white);
  background-color: var(--color-red);
  align-self: flex-start;
  padding: 6px 12px;
}

.login-form__title {
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 22px;
  color: var(--color-white);
  letter-spacing: -0.01em;
}

.login-form__field {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.login-form__field label {
  font-family: var(--font-primary);
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  color: var(--color-white);
  opacity: 0.5;
}

.login-form__field input {
  background: transparent;
  border: 1px solid var(--color-border);
  color: var(--color-white);
  font-family: var(--font-primary);
  font-size: 14px;
  padding: 10px 14px;
  outline: none;
  transition: border-color 0.2s;
}

.login-form__field input:focus {
  border-color: rgba(255, 255, 255, 0.6);
}

.login-form__error {
  font-family: var(--font-primary);
  font-size: 13px;
  color: var(--color-red);
}

.login-form__btn {
  margin-top: 4px;
  padding: 12px;
  background-color: var(--color-red);
  color: var(--color-white);
  font-family: var(--font-primary);
  font-weight: 700;
  font-size: 13px;
  letter-spacing: 0.06em;
  text-transform: uppercase;
  cursor: pointer;
  border: none;
  transition: opacity 0.2s;
}

.login-form__btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
