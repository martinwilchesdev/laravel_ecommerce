import axios from 'axios'

// se crea una instancia de axios utilizando `axios.create`
const instance = axios.create({
    baseURL: '/api', // ruta base eg, al realizar el registro de un usuario la ruta seria `/api/register`
    withCredentials: true,
    headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
    },
})

export default instance
