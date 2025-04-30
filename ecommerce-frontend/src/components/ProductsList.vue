<script setup>
import { storeToRefs } from 'pinia'

// store Pinia de los productos
import { useProductStore } from '@/stores/products'

// productos a mostrar en la vista
const productsStore = useProductStore()

// `storeToRefs(store)` convierte las propiedades reactivas del store en `ref()` individuales, manteniendo la reactividad
const { products } = storeToRefs(productsStore) // esto asegura que cuando los productos cambien en el store, el componente se actualice correctamente
</script>

<template>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- titulo principal -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6">
            Productos disponibles
        </h1>

        <!-- grilla de productos -->
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
        >
            <div
                v-for="product in products"
                :key="product.id"
                class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 flex flex-col"
            >
                <!-- imagen -->
                <img
                    :src="product.imagen"
                    :alt="product.nombre"
                    class="rounded-lg w-full h-48 object-cover mb-4"
                />

                <!-- nombre y precio -->
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ product.nombre }}
                </h2>
                <p class="text-emerald-500 font-bold mt-1">
                    ${{ product.precio }}
                </p>

                <!-- ver mas o agregar al carrito -->
                <RouterLink
                    class="mt-2 bg-emerald-500 hover:bg-emerald-400 text-white text-center font-medium py-2 px-4 rounded-lg transition"
                    :to="{
                        name: 'product_detail',
                        params: { id: product.id },
                    }"
                >
                    Ver más
                </RouterLink>
            </div>
        </div>
    </div>
</template>
