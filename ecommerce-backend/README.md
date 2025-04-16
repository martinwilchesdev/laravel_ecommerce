## Sanctum

Sanctum permite manejar el login y registro con tokens.

### Instalacion de Sanctum

```bash
php artisan install:api
```

### Configuracion

#### Middleware Sanctum

Se le debe indicar a Laravel que las solicitudes entrantes de la `SPA` pueden autenticarse utilizando las cookies de sesion de Laravel.

```php
// bootstrap/app.php

->withMiddleware(function(Middleware $middleware) {
    $middleware->statefulApi();
})
```

#### CORS y Cookies

El archivo `config/cors.php` no se publica de forma predeterminada.

```php
php artisan config:publish cors
```

Se debe asegurar que la configuracion CORS de la aplicacion retorne el encabezado `Access-Control-Allow-Credentials` con un valor `true`.

```php
// config/cors.php

'support_credentials' => true
```

Incluir los dominios locales y de produccion a los cuales tendra acceso la API via el frontend SPA

```php
// config/sanctum.php

'stateful' => 'localhost:5173'
```

#### .env

```bash
SESSION_DRIVER=cookie
SESSION_DOMAIN=localhost
```
