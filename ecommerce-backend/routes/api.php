<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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
