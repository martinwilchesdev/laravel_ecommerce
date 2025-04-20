# Autenticacion

## Registro persistente

### Guardar el usuario en el localstorage

- Desventajas:
    - Los datos son accesibles desde el navegador, aunque no la contraseña no sea visible.
    - Si el usuario cierra sesión desde otro lugar, la app no lo sabra.

### Obtener el usuario desde el backend al cargar la app

- Ventajas:
    - No expone el usuario en el localstorage.
    - Se sincroniza con la sesion real de Laravel.
    - Funciona si el usuario cambia de sesión desde otro dispositivo.

## Enrutamiento (vue-router)

`navigation guard` permite definir la logica para redirigir al usuario a distintas rutas depoendiendo de si esta autenticado o no.

```js
const route = [
    {
        path: '/login',
        name: 'login',
        meta: {
            guestOnly: true // solo podran acceder a la ruta usuarios que no esten autenticados
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        meta: {
            requiresAuth: true // solo podran acceder a la ruta usuarios autenticados
        }
    }
]

// ejecutar antes del acceso a la ruta
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()

    // si el usuario esta autenticado, se bloquea el acceso a rutas publicas
    if (to.meta.guestOnly && authStore.user) {
        return next({name: 'dashboard'})
    }

    next()
})
```