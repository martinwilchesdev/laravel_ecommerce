<script setup>
import { ref } from 'vue'

// componentes
import AppLayout from '@/layouts/AppLayout.vue'

import { useAuthStore } from '@/stores/auth'

const authStore = useAuthStore()

const orders = ref([])
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

                <div v-if="orders.length === 0" class="text-gray-500">
                    Aún no tienes pedidos. Comienza a comprar productos en la
                    tienda.
                </div>

                <!-- lista de pedidos -->
                <ul v-else class="divide-y divide-gray-200">
                    <li v-for="(order, index) in orders" :key="index">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-700">
                                    Pedido #{{ order.id }}
                                </p>
                                <p class="font-meium text-gray-500">
                                    Fecha {{ order.fecha }}
                                </p>
                            </div>
                            <span
                                class="text-sm font-medium text-emerald-500"
                                >{{ order.estado }}</span
                            >
                        </div>
                    </li>
                </ul>

                <!-- ver productos -->
                <section class="text-center mt-8">
                    <RouterLink
                        to="/productos"
                        class="inline-block bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl transition hover:bg-emerald-400"
                        >Ver productos</RouterLink
                    >
                </section>
            </section>
        </div>
    </AppLayout>
</template>
