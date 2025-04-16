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