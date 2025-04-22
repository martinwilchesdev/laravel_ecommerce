<script setup>
import { useCartStore } from '@/stores/cart'

import AppLayout from '@/layouts/AppLayout.vue'

const cartStore = useCartStore()
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">
                Carrito de compras
            </h1>

            <div v-if="cartStore.items.length === 0" class="text-gray-500">
                Tu carrito esta vacío.
            </div>

            <div v-else>
                <div
                    v-for="item in cartStore.items"
                    :key="item.id"
                    class="flex items-center justify-between mb-4 p-4 bg-white rounded-xl shadow"
                >
                    <div>
                        <h2 class="text-lg font-semibold">{{ item.nombre }}</h2>
                        <p>Cantidad: {{ item.cantidad }}</p>
                        <p>Precio: ${{ item.precio }}</p>
                    </div>
                    <button
                        class="text-red-500 font-medium cursor-pointer hover:text-red-600"
                        @click="cartStore.removeFromCart(item)"
                    >
                        Eliminar
                    </button>
                </div>

                <div class="mt-6 text-xl font-semibold">
                    Total: ${{ cartStore.totalPrice }}
                </div>

                <button
                    class="mt-4 bg-red-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-red-600"
                    @click="cartStore.clearCart()"
                >
                    Vaciar carrito
                </button>
            </div>
        </div>
    </AppLayout>
</template>
