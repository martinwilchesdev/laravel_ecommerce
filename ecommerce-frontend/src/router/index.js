import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

import Dashboard from '@/components/Dashboard.vue'

// componentes de autenticacion
import Register from '@/components/auth/Register.vue'
import Login from '@/components/auth/Login.vue'

const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            guestOnly: true,
        },
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {
            guestOnly: true,
        },
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true,
        },
    },
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()

    // si el usuario no ha sido cargado, se intenta obtener mediante la funcion `fetchUser` del store
    if (authStore.user === null) {
        await authStore.fetchUser()
    }

    // si el usuario esta autenticado, bloquear el acceso a rutas publicas
    if (to.meta.guestOnly && authStore.user) {
        return next({ name: 'dashboard' }) // se redirige el usuario autenticado al dashboard
    }

	// si el usuario no esta autenticado, bloquear el acceso a rutas donde se solicita autenticacion
    if (to.meta.requiresAuth && !authStore.user) {
        return next({ name: 'login' })
    }

    next()
})

export default router
