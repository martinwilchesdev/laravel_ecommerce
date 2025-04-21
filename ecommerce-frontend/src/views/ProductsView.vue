<script setup>
import { ref, onMounted } from 'vue'

// componentes
import AppLayout from '@/layouts/AppLayout.vue'

// instancia de axios
import { api } from '@/resources/js/axios'

// productos a mostrar en la vista
const products = ref([])

// obtner los productos realizando una peticion HTTP GET a `/products`
const fetchProducts = async () => {
    try {
        const response = await api.get('/products')
        products.value = response.data // se asignan los productos consultados a la variable `products`
    } catch (e) {
        console.log('Error al cargar los productos: ', e)
    }
}

// se ejecuta al montarse el componente
onMounted(async () => {
    await fetchProducts() // se invoca la funcion `fetchProducts()`
})
</script>

<template>
    <AppLayout>
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
                        class="mt-auto bg-emerald-500 hover:bg-emerald-400 text-white font-medium py-2 px-4 rounded-lg transition"
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
    </AppLayout>
</template>
