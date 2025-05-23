<script setup>
import { onMounted } from 'vue'

// componentes
import AppLayout from '@/layouts/AppLayout.vue'

import { useRouter } from 'vue-router'

import { useAuthStore } from '@/stores/auth'
import { useOrderStore } from '@/stores/order'

const authStore = useAuthStore()
const orderStore = useOrderStore()

const router = useRouter() // enrutador

// actualizar la orden a pagar en el store
const paymentOrder = (order) => {
	orderStore.setOrder(order)
	router.push({ name: 'checkout' }) // redirigir al usuario a la ruta `/dashboard`
}

onMounted(async () => {
	// se obtienen las ordenes existentes
    await orderStore.fetchOrders()
})
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto mt-8 space-y-6">
            <!-- seccion de bienvenida -->
            <section>
                <h1 class="text-3xl font-bold text-gray-800">
                    Hola,
                    <span class="text-emerald-500">{{
                        authStore.user.name
                    }}</span>
                </h1>
                <p class="text-gray-600 mt-1">
                    Bienvenido a tu panel de usuario. Aquí puedes revisar tu
                    actividad reciente.
                </p>
            </section>

            <!-- seccion de ultimos pedidos -->
            <section class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Últimos pedidos
                </h2>

                <div v-if="orderStore.orders.length === 0" class="text-gray-500">
                    Aún no tienes pedidos. Comienza a comprar productos en la
                    tienda.
                </div>

                <!-- lista de pedidos -->
                <ul v-else class="divide-y divide-gray-200">
                    <li v-for="order in orderStore.orders" :key="order.id">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-700">
                                    Pedido #{{ order.id }}
                                </p>
                                <p class="font-medium text-gray-500">
                                    Fecha {{ order.fecha }}
                                </p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <span
                                    class="text-sm font-medium text-emerald-500"
                                    >{{ order.estado }}</span
                                >
                                <button
                                    v-if="order.estado === 'pendiente'"
									@click="paymentOrder(order)"
                                    class="px-3 py-2 rounded-md bg-emerald-500 text-white cursor-pointer transition hover:bg-emerald-600"
                                >
                                    Ir a pagar
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- ver productos -->
                <section class="text-center mt-8">
                    <RouterLink
                        :to="{ name: 'products' }"
                        class="inline-block bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl transition hover:bg-emerald-600"
                        >Ver productos</RouterLink
                    >
                </section>
            </section>
        </div>
    </AppLayout>
</template>
