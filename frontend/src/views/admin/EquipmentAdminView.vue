<template>
  <div>
    <h2 class="page-title">Спорядження</h2>

    <div class="toolbar">
      <button class="btn btn--primary" @click="openCreate">+ Додати</button>
    </div>

    <div v-if="loading" class="state">Завантаження...</div>
    <div v-else-if="!items.length" class="state">Немає записів</div>

    <table v-else class="table">
      <thead>
        <tr><th>Назва</th><th>Ціна/день</th><th>Активний</th><th></th></tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.title }}</td>
          <td>{{ item.price_per_day ? item.price_per_day + ' грн' : '—' }}</td>
          <td>{{ item.is_active ? '✓' : '—' }}</td>
          <td style="width:120px; text-align:right">
            <button class="btn btn--sm btn--secondary" @click="openEdit(item)">Ред.</button>
            <button class="btn btn--sm btn--danger" style="margin-left:8px" @click="remove(item.id)">✕</button>
          </td>
        </tr>
      </tbody>
    </table>

    <div v-if="modal" class="modal-overlay" @click.self="modal = false">
      <div class="modal">
        <h3 class="modal__title">{{ editing ? 'Редагувати' : 'Нове спорядження' }}</h3>
        <div class="form__field"><label>Назва</label><input v-model="form.title" type="text" required /></div>
        <div class="form__field"><label>Опис</label><textarea v-model="form.description" rows="3" /></div>
        <div class="form__field"><label>Ціна/день (грн)</label><input v-model.number="form.price_per_day" type="number" min="0" /></div>
        <div class="form__field">
          <label><input v-model="form.is_active" type="checkbox" style="margin-right:8px" />Активний</label>
        </div>
        <div class="modal__actions">
          <button class="btn btn--secondary" @click="modal = false">Скасувати</button>
          <button class="btn btn--primary" :disabled="saving" @click="save">{{ saving ? '...' : 'Зберегти' }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const items   = ref([])
const loading = ref(true)
const modal   = ref(false)
const editing = ref(null)
const saving  = ref(false)
const form    = ref({ title: '', description: '', price_per_day: null, is_active: true })

async function load() {
  loading.value = true
  try { const { data } = await axios.get('/api/v1/admin/equipment'); items.value = data?.data ?? data }
  finally { loading.value = false }
}
onMounted(load)

function openCreate() { editing.value = null; form.value = { title: '', description: '', price_per_day: null, is_active: true }; modal.value = true }
function openEdit(item) { editing.value = item.id; form.value = { ...item }; modal.value = true }

async function save() {
  saving.value = true
  try {
    editing.value
      ? await axios.put(`/api/v1/admin/equipment/${editing.value}`, form.value)
      : await axios.post('/api/v1/admin/equipment', form.value)
    modal.value = false; await load()
  } finally { saving.value = false }
}

async function remove(id) {
  if (!confirm('Видалити?')) return
  await axios.delete(`/api/v1/admin/equipment/${id}`); await load()
}
</script>

<style scoped src="./admin-form.css" />
