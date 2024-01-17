import { isAuthenticated } from '@/services/authService';
import { createWebHistory, createRouter } from 'vue-router';

const routes = [
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/LoginView.vue'),
  },
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/tasks/IndexTaskView.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/tasks',
    name: 'tasks.index',
    component: () => import('@/views/tasks/IndexTaskView.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/tasks/criar',
    name: 'tasks.create',
    component: () => import('@/views/tasks/CreateTaskView.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/tasks/:id',
    name: 'tasks.find',
    component: () => import('@/views/tasks/FindTaskView.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: '/not-found',
    name: 'notFound',
    component: () => import('@/views/NotFoundView.vue'),
  },
  {
    path: '/:catchAll(.*)',
    component: () => import('@/views/NotFoundView.vue'),
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) =>{
  if (to.meta.requiresAuth) {
    if (isAuthenticated()) {
      next();
    } 
    next('/login');
  } 
  next();
});

export default router;