<template>
  <div class="admin">
    <!-- Sidebar -->
    <aside class="admin__sidebar">
      <div class="admin__logo">MOUNTY</div>

      <nav class="admin__nav">
        <router-link
          v-for="item in navItems"
          :key="item.to"
          :to="item.to"
          class="admin__nav-link"
          active-class="is-active"
          exact-active-class="is-active"
        >
          {{ item.label }}
        </router-link>
      </nav>

      <button class="admin__logout" @click="logout">Вийти</button>
    </aside>

    <!-- Main -->
    <main class="admin__main">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth   = useAuthStore()
const router = useRouter()

const navItems = [
  { to: '/admin',           label: 'Головна' },
  { to: '/admin/hero',      label: 'Hero секція' },
  { to: '/admin/routes',    label: 'Маршрути' },
  { to: '/admin/equipment', label: 'Спорядження' },
  { to: '/admin/prices',    label: 'Ціни' },
  { to: '/admin/faq',       label: 'FAQ' },
]

async function logout() {
  await auth.logout()
  router.push('/admin/login')
}
</script>

<style scoped>
.admin {
  display: flex;
  min-height: 100vh;
  background-color: var(--color-bg);
  color: var(--color-white);
  font-family: var(--font-primary);
}

.admin__sidebar {
  width: 220px;
  flex-shrink: 0;
  display: flex;
  flex-direction: column;
  border-right: 1px solid var(--color-border);
  padding: 0 0 24px 0;
}

.admin__logo {
  font-weight: 700;
  font-size: 18px;
  letter-spacing: 0.06em;
  color: var(--color-white);
  background-color: var(--color-red);
  padding: 16px 20px;
  margin-bottom: 24px;
}

.admin__nav {
  display: flex;
  flex-direction: column;
  flex: 1;
}

.admin__nav-link {
  padding: 12px 20px;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  color: var(--color-white);
  opacity: 0.5;
  transition: opacity 0.2s, background-color 0.2s;
  border-bottom: 1px solid var(--color-border);
}

.admin__nav-link:hover,
.admin__nav-link.is-active {
  opacity: 1;
  background-color: rgba(255, 255, 255, 0.05);
}

.admin__nav-link.is-active {
  border-left: 3px solid var(--color-red);
  padding-left: 17px;
}

.admin__logout {
  margin: 0 20px;
  padding: 10px;
  font-family: var(--font-primary);
  font-size: 12px;
  font-weight: 700;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  color: var(--color-white);
  opacity: 0.4;
  border: 1px solid var(--color-border);
  background: transparent;
  cursor: pointer;
  transition: opacity 0.2s;
}

.admin__logout:hover {
  opacity: 1;
}

.admin__main {
  flex: 1;
  overflow-y: auto;
  padding: 40px;
}
</style>
