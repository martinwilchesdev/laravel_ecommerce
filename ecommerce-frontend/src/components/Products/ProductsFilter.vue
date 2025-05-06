<script setup>
import { onMounted, reactive, watchEffect } from 'vue'
import { useProductStore } from '@/stores/products'
import { storeToRefs } from 'pinia'

// store de productos
const productsStore = useProductStore()

// se desestructura la variable reactive del store
const { categories, filters } = storeToRefs(productsStore)
const { fetchProducts, fetchCategories } = productsStore // se desestructura la funcion de consulta de productos

// filtros de busqueda que se pueden aplicar en la vista
const localFilters = reactive({ // `reactive` permite que el formulario sea reactivo, sin necesidad de usar `ref` para cada campo
    busqueda: '',
    categoria_id: null,
    precio_minimo: null,
    precio_maximo: null,
})

// `watchEffect()` es una funcion que se ejecuta automaticamente cada vez que se usan valores reactivos dentro de ella
watchEffect(() => {
	// se actualiza el valor de la variable `localFilters` desde la variable reactiva del store `filters`
    Object.assign(localFilters, filters.value) // cada vez que cambie el valor de `filters`, se ejecuta la funcion `watchEffect()`
})

// aplicar filtros actualizando la variable reactiva del store `filters`
async function applyFilters() {
	// `Object.assign(target, source)` copia los valores de un objeto a otro de forma rapida
    Object.assign(filters.value, localFilters) // se actualizan los filtros del store con los valores obtenidos del filtro local en la variable `localFilters`
    await fetchProducts() // se realiza la consulta de los productos con los filtros aplicados, ejecutando la funcion del store `fetchProducts`
}

onMounted(async () => {
	await fetchCategories() // nobtener las categorias de los productos
})
</script>

<template>
    <form @submit.prevent="applyFilters" class="space-y-4 mb-6">
        <div class="flex gap-2">
            <!-- busqueda por nombre -->
            <input
                v-model="localFilters.busqueda"
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
                <option
                    v-for="category in categories"
                    :value="category.id"
                    :key="category.id"
                >
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
