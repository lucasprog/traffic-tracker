import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
      {
        path: '/',
        name: 'index',
        component: () => import('../pages/websites/page.vue'),
        meta: { requiresAuth: true },
      },
  ],
})

export default router
