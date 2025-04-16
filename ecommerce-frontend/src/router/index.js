import { createRouter, createWebHistory } from 'vue-router'

import Dashboard from '@/components/Dashboard.vue'

// componentes de autenticacion
import Register from '@/components/auth/Register.vue'
import Login from '@/components/auth/Login.vue'

const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
    },
	{
		name: 'dashboard',
		path: '/dashboard',
		component: Dashboard
	}
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

export default router
