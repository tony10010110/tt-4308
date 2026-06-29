import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
  const token = ref(localStorage.getItem('admin_token') || null)
  const user  = ref(null)

  const isLoggedIn = computed(() => !!token.value)

  function setToken(t) {
    token.value = t
    if (t) {
      localStorage.setItem('admin_token', t)
      axios.defaults.headers.common['Authorization'] = `Bearer ${t}`
    } else {
      localStorage.removeItem('admin_token')
      delete axios.defaults.headers.common['Authorization']
    }
  }

  async function login(email, password) {
    const { data } = await axios.post('/api/v1/auth/login', { email, password })
    setToken(data.token)
    user.value = data.user
  }

  async function logout() {
    try { await axios.post('/api/v1/auth/logout') } catch {}
    setToken(null)
    user.value = null
  }

  async function fetchMe() {
    if (!token.value) return
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
    try {
      const { data } = await axios.get('/api/v1/auth/me')
      user.value = data
    } catch {
      setToken(null)
    }
  }

  return { token, user, isLoggedIn, login, logout, fetchMe }
})
