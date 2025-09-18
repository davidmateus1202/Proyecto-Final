import {createRouter, createWebHistory} from 'vue-router';

// pages
import Home from '../Pages/Home.vue';
import Welcome from '../Pages/Welcome.vue';
import Login from '../Pages/Login.vue';
import Error from '../Error/Error.vue';
import About from '../Pages/About.vue';
import Project from '../Pages/Project.vue';
import ProjectResult from '../Pages/ProjectResult.vue';
import axios from 'axios';
import { useAuthStore } from '../store/authStore';

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
        path: '/about',
        name: 'About',
        component: About
    },
    {
        path: '/project',
        name: 'Project',
        component: Project
    },
    {
        path: '/project/result/:id',
        name: 'ProjectResult',
        component: ProjectResult
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,

    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    }
})

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    const token = localStorage.getItem('token');
    const role = localStorage.getItem('role');

    if (to.matched.some(record => record.meta.requiresAuth)) {
        try {

            if (!token) {
                authStore.authUser = false;
                return next({ name: 'Login' });
            }

            await axios.get('/api/validate-token', {
                headers: { 'Authorization': `Bearer ${token}` }
            });

            return next();

        } catch (e) {
            if (e.response && e.response.status === 401) {
                localStorage.removeItem('token');
                authStore.authUser = false;
                return next({ name: 'Login' });
            }
            next(false);
        }
    }

    if (to.matched.some(record => record.meta.requiresAuth) && !token) {
        return next({ name: 'Login' });
    }

    if (to.name === 'Login' && token) {
        return next({ name: 'Home' });
    }

    if (to.meta.roles && !to.meta.roles.includes(role)) {
        return next({ name: 'Home' });
    }

    if (to.name === 'Welcome' && token) {
        return next({ name: 'Home' });
    }

    next();
})

export default router;