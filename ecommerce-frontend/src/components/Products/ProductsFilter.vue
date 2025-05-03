<script setup>
import { ref } from 'vue'
import { useProductStore } from '@/stores/products'
import { storeToRefs } from 'pinia'

// store de productos
const productsStore = useProductStore()

const { categories } = storeToRefs(productsStore)

// filtros de busqueda que se pueden aplicar en la vista
const localFilters = ref({
    busqueda: '',
    categoria_id: null,
    precio_minimo: null,
    precio_maximo: null,
})
</script>

<template>
    <form @submit.prevent="applyFilters" class="space-y-4 mb-6">
        <div class="flex gap-2">
            <!-- busqueda por nombre -->
            <input
                v-model="localFilters.search"
                type="text"
                placeholder="Buscar producto..."
                class="w-full border px-3 py-2 rounded"
            />

            <!-- filtro por categoria -->
            <select
                v-model="localFilters.categoria_id"
                class="w-full border px-3 py-2 rounded"
            >
                <option :value="null">Todas las categorias</option>
                <option v-for="category in categories" :key="category.id">
                    {{ category.nombre }}
                </option>
            </select>
        </div>

        <!-- precio minimo y maximo -->
        <div class="flex gap-2">
            <input
                v-model="localFilters.precio_minimo"
                class="w-full border px-3 py-2 rounded"
                placeholder="Precio minimo"
                type="number"
            />
            <input
                v-model="localFilters.precio_maximo"
                class="w-full border px-3 py-2 rounded"
                placeholder="Precio maximo"
                type="number"
            />
        </div>

        <button
            type="submit"
            class="bg-emerald-500 text-white px-4 py-2 rounded cursor-pointer hover:bg-emerald-600"
        >
            Aplicar filtros
        </button>
    </form>
</template>
