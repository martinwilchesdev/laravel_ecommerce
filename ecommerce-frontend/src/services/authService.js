import { getCsrfCookie, api } from '@/resources/js/axios'

const register = async (credentials) => {
    // se obtiene la cookie CSRF
    await getCsrfCookie()

    // peticion HTTP POST a la ruta `/register` realizada mediante la instancia de `axios (api)`
    const response = await api.post('/register', credentials)

	return response
}

const login = async (credentials) => {
    // se obtiene la cookie CSRF|
    await getCsrfCookie()

    // a traves de la instancia de axios `api` se realiza una peticion HTTP POST a la ruta `/login`
    const response = await api.post('/login', credentials)

    return response
}

const logout = async () => {
    // se obtiene la cookie CSRF
    await getCsrfCookie()

    // a traves de la instancia de axios `api` se realiza una peticion HTTP POST a la ruta `/logout`
    await api.post('/logout')
}

export { register, login, logout }
