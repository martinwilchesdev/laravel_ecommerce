import { defineStore } from 'pinia'
import { ref } from 'vue'

import { api } from '@/resources/js/axios'

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
        } finally {
            loading.value = false
        }
    }

    // comprobar si el usuario tiene un valor valido
    const isLoggedIn = () => !user.value

    return {
        user,
        setUser,
        fetchUser,
        isLoggedIn,
    }
})
