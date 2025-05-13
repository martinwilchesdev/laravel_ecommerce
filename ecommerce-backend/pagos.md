# Stripe (pasarela de pagos)

## Instalar Stripe en Laravel

```bash
composer require stripe/php-stripe
```

## Variables de entorno .env

```php
'services' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET_KEY')
];
```

## Instalar Stripe en el frontend

```
npm i @stripe/stripe-js
```

> Componente de Stripe para Vue3
