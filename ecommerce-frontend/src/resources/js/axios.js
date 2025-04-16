import axios from 'axios'

// la ruta de la api se almacena en una variable de entorno, se accede a ella mediante `import.meta.env.VARIABLE_NAME`
const baseURL = import.meta.env.VITE_API_BASE_URL

// se crea una instancia de axios utilizando `axios.create()` para realizar peticiones a la API
const api = axios.create({
    baseURL: '/api', // ruta base eg, al realizar el registro de un usuario la ruta seria `/api/register`
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
})

// obtener el CSRF cookie
const getCsrfCookie = async () => {
    return await axios.get(`${baseURL}/sanctum/csrf-cookie`, {
        withCredentials: true,
    })
}

export { api, getCsrfCookie }
