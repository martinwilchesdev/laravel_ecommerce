import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

import Dashboard from '@/views/DashboardView.vue'

// componentes de autenticacion
import Register from '@/components/Auth/Register.vue'
import Login from '@/components/Auth/Login.vue'

// componentes de productos y carrito de compras
import ProductDetail from '@/views/ProductDetailView.vue'
import Products from '@/views/ProductsView.vue'
import Cart from '@/views/CartView.vue'

// componentes para la realizacion del pago
import CheckoutFormView from '@/views/CheckoutFormView.vue'

const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {
            guestOnly: true, // ruta publica
        },
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {
            guestOnly: true, // ruta publica
        },
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true, // ruta privada (solo accesible por usuarios autenticados)
        },
    },
    {
        name: 'products',
        path: '/products',
        component: Products,
        meta: {
            requiresAuth: true, // ruta privada (solo accesible para usuarios autenticados)
        },
    },
    {
        name: 'product_detail',
        path: '/products/:id',
        component: ProductDetail,
        meta: {
            requiresAuth: true, // ruta privada (solo accesible para usuarios autenticados)
        },
    },
    {
        name: 'cart',
        path: '/cart',
        component: Cart,
        meta: {
            requiresAuth: true, // ruta privada (solo accesible para usuarios autenticados)
        },
    },
    {
        name: 'checkout',
        path: '/checkout',
        component: CheckoutFormView,
        meta: {
            requiresAuth: true,
        },
    },
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
})

// ejecutar antes de cada enrutamiento
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
