import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('../views/HomeView.vue')
  },
  {
    path: '/proyectos',
    name: 'portfolio',
    component: () => import('../views/PortfolioView.vue')
  },
  {
    path: '/proyectos/:id',
    name: 'project-detail',
    component: () => import('../views/ProjectDetailView.vue'),
    props: true
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior() {
    return { top: 0 }
  }
})

export default router
