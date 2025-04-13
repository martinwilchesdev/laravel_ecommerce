<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import axios from '@/resources/js/axios'

const router = useRouter()
const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})
const errors = ref({})

const register = async () => {
    try {
        errors.value = {}

        const response = await axios.post('/register', form)
        router.push({ name: 'login' })
    } catch (error) {
        if (error.response?.status == 422) {
            errors.value = error.response.data.errors
        }
    }
}
</script>

<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h2
                class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900"
            >
                Registrarse
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" @submit.prevent="register">
                <div>
                    <label
                        for="name"
                        class="block text-sm/6 font-medium text-gray-900"
                        >Nombre</label
                    >
                    <div class="mt-2">
                        <input
                            type="text"
                            name="name"
                            id="name"
                            autocomplete="name"
                            required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            v-model="form.name"
                        />
                        <span v-if="errors.name" class="text-red-500 text-sm">{{
                            errors.name[0]
                        }}</span>
                    </div>
                </div>

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
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            v-model="form.email"
                        />
                        <span
                            v-if="errors.email"
                            class="text-red-500 text-sm"
                            >{{ errors.email[0] }}</span
                        >
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
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            v-model="form.password"
                        />
                        <span
                            v-if="errors.password"
                            class="text-red-500 text-sm"
                            >{{ errors.password[0] }}</span
                        >
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label
                            for="password_confirmation"
                            class="block text-sm/6 font-medium text-gray-900"
                            >Confirmar contraseña</label
                        >
                    </div>
                    <div class="mt-2">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            v-model="form.password_confirmation"
                        />
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs cursor-pointer hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Crear cuenta
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                ¿Ya tienes una cuenta?
                <RouterLink :to="{ name: 'login' }">Iniciar sesión</RouterLink>
            </p>
        </div>
    </div>
</template>
