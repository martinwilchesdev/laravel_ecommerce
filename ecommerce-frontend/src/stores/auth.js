import { defineStore } from 'pinia'
import { ref } from 'vue'

import { api } from '@/resources/js/axios'

import {
    login as loginService,
    logout as logoutService,
    register as registerService,
} from '@/services/authService'

/**
 * setup stores
 * la forma de definir la store es similar a `Vue Composition API setup`
 * retorna un objeto con las propiedades y metodos que se quieren exponer
 */
export const useAuthStore = defineStore('auth', () => {
    // usuario
    const user = ref(null)
    const loading = ref(true)

    // setear datos del usuario
    const setUser = (data) => {
        user.value = data
    }

    // obtener los datos del usuario autenticado
    const fetchUser = async () => {
        loading.value = true
        try {
            const response = await api.get('/user')
            user.value = response.data // se obtiene el usuario autenticado y se actualiza la variable `user` del store
        } catch (e) {
            user.value = null // usuario no autenticado
            console.log('Usuario no autenticado: ', e)
        } finally {
            loading.value = false
        }
    }

    // registrar el usuario
    const register = async (credentials) => {
        // se realiza la peticion HTTP a `/register` utilizando el servicio de autenticacion definido
		await registerService(credentials)
		await fetchUser() // se llama la funcion `fetchUser` mediante la cual se obtienen los datos del usuario autenticado
    }

    // autenticar el usuario
    const login = async (credentials) => {
        // se realiza la peticicion HTTP a `/login` utilizando el servicio de autenticacion definido
		await loginService(credentials)
		await fetchUser() // se llama la funcion `fetchUser` mediante la cual se obtienen los datos del usuario autenticado
    }

    // finalizar la sesion del usuario autenticado
    const logout = async () => {
        // se realiza la peticion HTTP a `/logout` utilizando el servicio de autenticacion definido
        await logoutService()
        user.value = null
    }

    // comprobar si el usuario tiene un valor valido
    const isLoggedIn = () => !user.value

    return {
        user,
        setUser,
        fetchUser,
        isLoggedIn,
        login,
        logout,
        register,
    }
})
