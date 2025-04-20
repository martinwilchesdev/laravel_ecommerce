<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'

import { useAuthStore } from '@/stores/auth'

// use de una instancia de `vue-router` para redirigir al usuario a una ruta especifica
const router = useRouter()

// store de pinia (auth)
const authStore = useAuthStore()

// mensaje de error en la autenticacion (credenciales incorrectas)
const errorMsg = ref('')

// mensajes de error en la autenticacion (validacion desde el backend)
const errors = ref({})

// datos del usuario utilizados para la autenticacion
const form = reactive({
    email: '',
    password: '',
})

const login = async () => {
    try {
        errors.value = {}

        // autenticacion en el formulario llamando a la funcion `login` definida en la `authStore`
        await authStore.login(form)
        router.push({ name: 'dashboard' })
    } catch (e) {
        if (e.response?.status === 401) {
            errorMsg.value =
                e.response?.data?.message
            setTimeout(() => {
                errorMsg.value = ''
            }, 5000)
        } else {
            console.log('Error al iniciar sesión')
        }
    }
}
</script>

<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div v-if="errorMsg" class="bg-red-500 text-center text-white px-2 py-3 sm:mx-auto sm:w-full sm:max-w-sm">
            {{ errorMsg }}
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2
                class="mt-10 text-center text-2xl/9 text-emerald-500 font-bold tracking-tight"
            >
                Iniciar sesión
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="login">
                <div>
                    <label
                        for="email"
                        class="block text-sm/6 font-medium text-gray-900"
                        >Correo electrónico</label
                    >
                    <div class="mt-2">
                        <input
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="email"
                            required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-emerald-500 sm:text-sm/6"
                            v-model="form.email"
                        />
                        <span v-if="errors.email">{{ errors.email[0] }}</span>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Contraseña</label
                        >
                    </div>
                    <div class="mt-2">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="current-password"
                            required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-emerald-500 sm:text-sm/6"
                            v-model="form.password"
                        />
                        <span v-if="errors.password">{{
                            errors.password[0]
                        }}</span>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-emerald-500 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs cursor-pointer hover:bg-emerald-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-500"
                    >
                        Iniciar sesión
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                ¿Aún no tienes una cuenta?
                <RouterLink :to="{ name: 'register' }" class="text-emerald-500 font-bold hover:text-emerald-400">Registrarse</RouterLink>
            </p>
        </div>
    </div>
</template>
