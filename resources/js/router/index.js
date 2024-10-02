import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import About from '../views/About.vue';
import Login from '../components/Login.vue';
import Register from '../components/Register.vue';
import Notes from '../components/Notes.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/about',
        name: 'About',
        component: About
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
      },
      {
        path: '/register',
        name: 'Register',
        component: Register,
      },
      {
        path: '/notes',
        name: 'Notes',
        component: Notes,
      },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
