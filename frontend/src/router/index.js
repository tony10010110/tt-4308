import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import FaqView  from '@/views/FaqView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/',    name: 'home', component: HomeView },
    { path: '/faq', name: 'faq',  component: FaqView, meta: { bodyClass: 'faq-page' } },

    {
      path: '/admin/login',
      name: 'admin-login',
      component: () => import('@/views/admin/LoginView.vue'),
      meta: { bodyClass: 'faq-page' },
    },
    {
      path: '/admin',
      component: () => import('@/views/admin/AdminLayout.vue'),
      meta: { requiresAuth: true, bodyClass: 'faq-page' },
      children: [
        { path: '',          name: 'admin',           component: () => import('@/views/admin/DashboardView.vue') },
        { path: 'hero',      name: 'admin-hero',      component: () => import('@/views/admin/HeroAdminView.vue') },
        { path: 'routes',    name: 'admin-routes',    component: () => import('@/views/admin/RoutesAdminView.vue') },
        { path: 'equipment', name: 'admin-equipment', component: () => import('@/views/admin/EquipmentAdminView.vue') },
        { path: 'prices',    name: 'admin-prices',    component: () => import('@/views/admin/PricesAdminView.vue') },
        { path: 'faq',       name: 'admin-faq',       component: () => import('@/views/admin/FaqAdminView.vue') },
      ],
    },
  ],
  scrollBehavior(to) {
    if (to.hash) return { el: to.hash, behavior: 'smooth' }
    return { top: 0 }
  },
})

router.beforeEach((to) => {
  if (to.meta.requiresAuth && !localStorage.getItem('admin_token')) {
    return { name: 'admin-login' }
  }
})

export default router
