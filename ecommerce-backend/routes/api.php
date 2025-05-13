<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\PaymentController;

/**
 * el middleware `guest` permite que unicamente usuarios no autenticados accedan a la ruta
 * el middleware `auth` permite que unicamente usuarios autenticados accedan a la ruta
*/

// login de usuarios
Route::middleware('guest')->post('/login', [AuthController::class, 'login'])
    ->name('login');

// registro de usuarios
Route::middleware('guest')->post('/register', [AuthController::class, 'register'])
    ->name('register');

// logout de usuarios (ruta accesible solo por usuarios autenticados)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// obtener informacion del usuario (ruta accesible solo por usuarios autenticados)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// productos
Route::get('/products', [ProductController::class, 'index']);

// obtener un producto especifico
Route::get('/products/{id}', [ProductController::class, 'show']);

// categorias
Route::get('/categories', [CategoryController::class, 'index']);

// crear una nueva orden
Route::middleware('auth:sanctum')->post('/orders', [OrderController::class, 'store']);

// generar un payment intent con Stripe
Route::middleware('auth:sanctum')->post('/payment-intent', [PaymentController::class, 'createPaymentIntent']);
