import { defineStore } from 'pinia'
import { ref } from 'vue'

import { useCartStore } from './cart'

import { api } from '@/resources/js/axios'

export const useOrderStore = defineStore('order', () => {
	const order = ref(null) // orden seleccionada para realizar el pago
	const orders = ref([])

	// enviar orden de compra
	const submitOrder = async (user) => {
		try {
			if (!user) {
				console.log('Usuario no autenticado')
				return
			} else {
				const cartStore = useCartStore()

				const payload = {
					items: cartStore.items.value.map(item => ({
						producto_id: item.id,
						cantidad: item.cantidad
					}))
				}

				await api.post('/orders', payload)
			}
		} catch(e) {
			console.log('Ocurrio un error al enviar la orden ', e)
		}
	}

    async function fetchOrders() {
        try {
            const response = await api.get('/orders')
            orders.value = response.data.orders
        } catch (e) {
            console.log('Ocurrio un error al consultar las ordenes ', e)
        }
    }

	function setOrder(orderToPay) {
		order.value = orderToPay // orden seleccionada para realizar el pago
	}

    return {
        orders,
        fetchOrders,
		submitOrder,
		setOrder,
		order
    }
})
