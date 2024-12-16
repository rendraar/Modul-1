import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import AdminView from '../views/AdminView.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomeView,
  },
  {
    path: '/admin',
    name: 'Admin',
    component: AdminView,
    // optional: Check if user is admin before showing this route
    // beforeEnter: (to, from, next) => {
    //   if (isAdminAuthenticated()) {
    //     next();
    //   } else {
    //     next('/');
    //   }
    // }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
