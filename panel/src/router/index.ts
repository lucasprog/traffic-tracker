import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
      {
        path: '/',
        name: 'index',
        component: () => import('../pages/websites.vue'),
      },
      {
        path: '/pages/all',
        name: 'pages',
        component: () => import('../pages/pages.vue'),
      },
      {
        path: '/pages/:website',
        name: 'pages',
        component: () => import('../pages/pages.vue'),
      },
  ],
})

export default router
