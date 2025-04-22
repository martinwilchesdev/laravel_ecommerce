import { defineStore } from 'pinia'
import { computed, ref } from 'vue'

export const useCartStore = defineStore('cart', () => {
    // productos agregados al carrito
    const items = ref([])

    /**
     * Getters
     */
    // obtener el total del productos añadidos al carrito
    const totalItems = computed(() =>
        items.value.reduce((acc, item) => acc + item.cantidad, 0)
    )

    // obtener el precio total de los productos añadidos al carrito
    const totalPrice = computed(() =>
        items.value
            .reduce((acc, item) => {
                return acc + item.precio * item.cantidad
            }, 0)
            .toFixed(2)
    )

    /**
     * Acciones
     */
    // añadir un producto al carrito o actualizar la cantidad de un producto ya añadido
    const addToCart = (product) => {
        const existing = items.value.find((item) => item.id === product.id)

        if (existing) {
            existing.cantidad++
        } else {
            items.value.push({ ...product, cantidad: 1 })
        }
    }

    // remover un producto del carrito
    const removeFromCart = (product) => {
        const index = items.value.findIndex((item) => item.id === product.id)
        if (index !== -1) {
            items.value.splice(index, 1) // se remueve el elemento ubicado en el indice `index`
        }
    }

    // eliminar todos los productos del carrito
    const clearCart = () => {
        items.value.splice(0) // se remueven los elementos del array desde el primer indice hasta el ultimo
    }

    return {
        items,
        totalItems,
        totalPrice,
        addToCart,
        removeFromCart,
        clearCart,
    }
})
