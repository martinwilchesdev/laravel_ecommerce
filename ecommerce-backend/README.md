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

## Relaciones

Las relaciones permiten definir como se conectan los registros entre distintas tablas de la base de datos utilizando Eloquent.

- Un producto pertenece a una categoria
- Una categoria tiene muchos productos
- Un usuario puede tener muchas ordenes

### Relaciones mas comunes

#### Uno a uno (one to one)

```php
// User.php
public function profile() {
    $this->hasOne(Profile::class); // un usuario tiene un perfil
}

// Profile.php
public function User() {
    $this->belongsTo(User::class); // un perfil pertenece a un usuario
}
```

#### Uno a muchos (one to many)

```php
// Category.php
public function product() {
    $this->hasMany(Product::class); // una categoria tiene muchos productos
}

// Product.php
public function category() {
    $this->belongsTo(Category::class); // un producto pertenece a una categoria
}
```

### Acceso a relaciones

```php
$product = Product::find(1);
$product->category->name;
```

#### Carga con eager loading

Cargar el producto y sus categorias en una sola consulta

```php
$products = Product::with('category')->get();
```
