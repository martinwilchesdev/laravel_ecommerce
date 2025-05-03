<script setup>
import { onMounted } from 'vue'

// store Pinia de los productos
import { useProductStore } from '@/stores/products'

// componentes
import AppLayout from '@/layouts/AppLayout.vue'
import ProductsList from '@/components/Products/ProductsList.vue'

// productos a mostrar en la vista
const productsStore = useProductStore()

// se ejecuta al montarse el componente
onMounted(async () => {
    await productsStore.fetchProducts() // se invoca la funcion `fetchProducts()`
})
</script>

<template>
    <AppLayout>
        <!-- lista de productos -->
        <ProductsList />
    </AppLayout>
</template>
