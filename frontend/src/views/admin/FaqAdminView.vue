<template>
  <div>
    <h2 class="page-title">FAQ</h2>

    <div class="toolbar">
      <button class="btn btn--primary" @click="openCreate">+ Додати питання</button>
    </div>

    <div v-if="loading" class="state">Завантаження...</div>
    <div v-else-if="!items.length" class="state">Немає записів</div>

    <table v-else class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Питання</th>
          <th>Відповідь</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td style="opacity:0.4; width:40px">{{ item.sort_order ?? item.id }}</td>
          <td>{{ item.question }}</td>
          <td style="opacity:0.6; max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">
            {{ item.answer }}
          </td>
          <td style="width:120px; text-align:right">
            <button class="btn btn--sm btn--secondary" @click="openEdit(item)">Ред.</button>
            <button class="btn btn--sm btn--danger" style="margin-left:8px" @click="remove(item.id)">✕</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div v-if="modal" class="modal-overlay" @click.self="modal = false">
      <div class="modal">
        <h3 class="modal__title">{{ editing ? 'Редагувати' : 'Нове питання' }}</h3>

        <div class="form__field">
          <label>Питання</label>
          <input v-model="form.question" type="text" required />
        </div>
        <div class="form__field">
          <label>Відповідь</label>
          <textarea v-model="form.answer" rows="5" required />
        </div>
        <div class="form__field">
          <label>Порядок сортування</label>
          <input v-model.number="form.sort_order" type="number" min="0" />
        </div>

        <div class="modal__actions">
          <button class="btn btn--secondary" @click="modal = false">Скасувати</button>
          <button class="btn btn--primary" :disabled="saving" @click="save">
            {{ saving ? 'Збереження...' : 'Зберегти' }}
          </button>
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
const form    = ref({ question: '', answer: '', sort_order: 0 })

async function load() {
  loading.value = true
  try {
    const { data } = await axios.get('/api/v1/admin/faqs')
    items.value = data?.data ?? data
  } finally {
    loading.value = false
  }
}

onMounted(load)

function openCreate() {
  editing.value = null
  form.value    = { question: '', answer: '', sort_order: items.value.length }
  modal.value   = true
}

function openEdit(item) {
  editing.value = item.id
  form.value    = { ...item }
  modal.value   = true
}

async function save() {
  saving.value = true
  try {
    if (editing.value) {
      await axios.put(`/api/v1/admin/faqs/${editing.value}`, form.value)
    } else {
      await axios.post('/api/v1/admin/faqs', form.value)
    }
    modal.value = false
    await load()
  } finally {
    saving.value = false
  }
}

async function remove(id) {
  if (!confirm('Видалити запис?')) return
  await axios.delete(`/api/v1/admin/faqs/${id}`)
  await load()
}
</script>

<style scoped src="./admin-form.css" />
