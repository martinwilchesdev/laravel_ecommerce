<script setup>
import { ref, onMounted } from 'vue'
import { loadStripe } from '@stripe/stripe-js' // se importa la funcion de stripe para cargar la libreria
import { api } from '@/resources/js/axios' // instancia de axios

import AppLayout from '@/layouts/AppLayout.vue'

// clave publica
const stripePublicKey = import.meta.env.VITE_STRIPE_KEY

const stripe = ref(null) // objeto principal de stripe
const elements = ref(null) // contenedor de los elementos de la UI de stripe
const cardElement = ref(null) // el campo de tarjeta (input especial de stripe)
const loading = ref(false) // estado para habilitar/deshabilitar el boton de pago

const handleSubmit = async () => {
    loading.value = true

    try {
        const amount = 200 // monto simulado

        // se crea un payment intent y se obtiene el clientSecret
        const response = await api.post('/payment-intent', { amount })
        const clientSecret = response.data.clientSecret

        // se confirma el pago en el frontend usando la tarjeta ingresada por el usuario
        const { error, paymentIntent } = await stripe.value.confirmCardPayment(
            clientSecret,
            {
                payment_method: {
                    card: cardElement.value, // se envia el elemento montado de stripe
                },
            }
        )

		// validaciones de pago
		if (error) {
			alert(error.message)
		} else if (paymentIntent.status === 'succeeded') {
			alert('Pago exitoso')
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
