import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import AdminView from '../views/posts/AdminView.vue';
import AdminAnimeView from '../views/posts/AdminAnimeView.vue';
import AdminGenreView from '../views/posts/AdminGenreView.vue';

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
    children: [
      {
        path: 'anime',
        name: 'AdminAnime',
        component: AdminAnimeView,
      },
      {
        path: 'genre',
        name: 'AdminGenre',
        component: AdminGenreView,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
