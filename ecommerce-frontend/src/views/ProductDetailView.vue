<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

// store para gestionar el carrito de compras
import { useCartStore } from '@/stores/cart'

// componentes
import AppLayout from '@/layouts/AppLayout.vue'
import { api } from '@/resources/js/axios'

const cartStore = useCartStore()

// `useRoute()` permite obtener informacion de la ruta a la que se accede, en este caso al valor del parametro `id`
const route = useRoute()

const product = ref(null)

// consultar la informacion de un producto en especifico
const fetchProduct = async () => {
    try {
        const response = await api.get(`/products/${route.params.id}`)
        product.value = response.data // se asigna la informacion del producto consultado a la variable `product`
    } catch (e) {
        console.log('Error al consultar el producto ', e)
    }
}

const addToCart = () => {
	cartStore.addToCart(product.value)
}

// se ejecuta al montarse el componente
onMounted(async () => {
    await fetchProduct() // se ejecuta la funcion que consulta la informacion del producto
})
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div
                v-if="product"
                class="bg-white rounded-xl shadow p-6 flex flex-col gap-6 md:flex-row"
            >
                <!-- imagen -->
                <img
                    :src="product.imagen"
                    :alt="product.nombre"
                    class="w-full md:w-1/2 rounded-lg object-cover"
                />

                <!-- detalles del producto -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800">
                        {{ product.nombre }}
                    </h1>
                    <p class="text-xl text-emerald-500 font-semibold mt-2">
                        ${{ product.precio }}
                    </p>
                    <p class="text-gray-700 mt-4">{{ product.descripcion }}</p>
                    <button
                        class="mt-6 bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl transition cursor-pointer hover:bg-emerald-600"
						@click="addToCart"
                    >
                        Agregar al carrito
                    </button>
                </div>
            </div>
            <div v-else class="text-center text-gray-500">
                Cargando producto...
            </div>
        </div>
    </AppLayout>
</template>
