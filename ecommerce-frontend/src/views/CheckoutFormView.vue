<script setup>
import { ref, onMounted } from 'vue'
import { storeToRefs } from 'pinia'

import { loadStripe } from '@stripe/stripe-js' // se importa la funcion de stripe para cargar la libreria

import AppLayout from '@/layouts/AppLayout.vue'

import { api } from '@/resources/js/axios' // instancia de axios

import { useRouter } from 'vue-router'

import { useOrderStore } from '@/stores/order'

const orderStore = useOrderStore()
const { order } = storeToRefs(orderStore)

const router = useRouter() // enrutador

// clave publica
const stripePublicKey = import.meta.env.VITE_STRIPE_KEY

const stripe = ref(null) // objeto principal de stripe
const elements = ref(null) // contenedor de los elementos de la UI de stripe
const cardElement = ref(null) // el campo de tarjeta (input especial de stripe)
const loading = ref(false) // estado para habilitar/deshabilitar el boton de pago

const handleSubmit = async () => {
    loading.value = true

    try {
        // orden seleccionada para pago
        const orderToPay = order.value

        if (!orderToPay) return alert('La orden no es valida')

        // se crea un payment intent y se obtiene el clientSecret
        const response = await api.post('/payment-intent', { orderToPay })
        const clientSecret = response.data.clientSecret

        // se confirma el pago en el frontend usando el `clientSecret` enviado desde el backend
        const { error, paymentIntent } = await stripe.value.confirmCardPayment( // finalizar el pago
            clientSecret,
            {
                payment_method: {
                    card: cardElement.value, // se envia el elemento de la tarjeta montado en el DOM con Stripe elements
                },
            }
        )

        // validaciones de pago
        if (error) {
            alert(error.message)
        } else if (paymentIntent.status === 'succeeded') {
            alert('Pago exitoso')
			// si el pago realizado es exitoso se retorna el usuario a la ruta `dashboard`
            router.push({ name: 'dashboard' })
        }
    } catch (e) {
        console.log('Ocurrio un error al realizar el pago: ', e)
    } finally {
        loading.value = false
    }
}

onMounted(async () => {
    // se carga la libreria de stripe utilizando la clave publica
    stripe.value = await loadStripe(stripePublicKey)
    // se inician los elementos de la UI de stripe
    elements.value = stripe.value.elements()
    // se crea el campo de tarjeta
    cardElement.value = elements.value.create('card')
    // se monta el campo de tarjeta dentro del `div` identificado con el `id` proporcionado
    cardElement.value.mount('#card-element')
})
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Formulario de pago</h2>
            <form @submit.prevent="handleSubmit">
                <!-- aqui stripe montara su propio campo de tarjeta -->
                <div id="card-element" class="p-4 border rounded mb-4"></div>
                <button
                    type="submit"
                    class="w-full bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600"
                >
                    {{ loading ? 'Procesando...' : 'Pagar' }}
                </button>
            </form>
        </div>
    </AppLayout>
</template>
