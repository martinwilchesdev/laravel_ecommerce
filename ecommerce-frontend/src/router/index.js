import { createRouter, createWebHistory } from 'vue-router'

// componentes
import Register from '@/components/Register.vue'
import Login from '@/components/Login.vue'

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
    }
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

export default router
