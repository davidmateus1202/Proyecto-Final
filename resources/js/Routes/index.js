import {createRouter, createWebHistory} from 'vue-router';

// pages
import Home from '../Pages/Home.vue';
import Welcome from '../Pages/Welcome.vue';
import Login from '../Pages/Login.vue';
import Error from '../Error/Error.vue';
import Page1 from '../Pages/Page1.vue';

const routes = [
    {
        path: '/',
        name: 'Welcome',
        component: Welcome
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/:pathMatch(.*)*',
        component: Error
    },
    {
        path: '/home',
        name: 'Home',
        component: Home,
        meta: { requiresAuth: true, roles: ['admin'] }
    },
    {
        path: '/page1',
        name: 'Page1',
        component: Page1,
        meta: { requiresAuth: true, roles: ['admin'] }
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
    const role = localStorage.getItem('role');

    if (to.matched.some(record => record.meta.requiresAuth) && !token) {
        return next({ name: 'Login' });
    }

    if (to.name === 'Login' && token) {
        return next({ name: 'Home' });
    }

    if (to.meta.roles && !to.meta.roles.includes(role)) {
        return next({ name: 'Home' });
    }

    next();
})

export default router;