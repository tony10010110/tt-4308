<template>
  <div>
    <h2 class="page-title">Hero секція</h2>

    <div v-if="loading" class="state">Завантаження...</div>
    <div v-else-if="error" class="state state--error">{{ error }}</div>

    <form v-else class="form" @submit.prevent="save">
      <div class="form__field">
        <label>Заголовок</label>
        <textarea v-model="form.title" rows="3" placeholder="МААААМ, Я&#10;В КАРПАТИ" />
        <span class="form__hint">Новий рядок = новий рядок в заголовку</span>
      </div>

      <div class="form__field">
        <label>Текст кнопки</label>
        <input v-model="form.button_text" type="text" />
      </div>

      <div class="form__field">
        <label>URL кнопки</label>
        <input v-model="form.button_url" type="text" placeholder="#routes" />
      </div>

      <div class="form__field">
        <label>Фонове зображення</label>
        <input v-model="form.background" type="text" placeholder="URL або залиш порожнім для дефолтного" />
      </div>

      <div class="form__actions">
        <button type="submit" class="btn btn--primary" :disabled="saving">
          {{ saving ? 'Збереження...' : 'Зберегти' }}
        </button>
        <span v-if="saved" class="form__saved">✓ Збережено</span>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const form    = ref({ title: '', button_text: '', button_url: '', background: '' })
const loading = ref(true)
const saving  = ref(false)
const saved   = ref(false)
const error   = ref('')

onMounted(async () => {
  try {
    const { data } = await axios.get('/api/v1/admin/hero')
    const item = Array.isArray(data?.data) ? data.data[0] : data?.data ?? data
    if (item) Object.assign(form.value, item)
  } catch (e) {
    error.value = 'Помилка завантаження'
  } finally {
    loading.value = false
  }
})

async function save() {
  saving.value = true
  saved.value  = false
  try {
    const id = form.value.id
    if (id) {
      await axios.put(`/api/v1/admin/hero/${id}`, form.value)
    } else {
      const { data } = await axios.post('/api/v1/admin/hero', form.value)
      form.value.id = data?.data?.id ?? data?.id
    }
    saved.value = true
    setTimeout(() => { saved.value = false }, 2500)
  } catch {
    error.value = 'Помилка збереження'
  } finally {
    saving.value = false
  }
}
</script>

<style scoped src="./admin-form.css" />
