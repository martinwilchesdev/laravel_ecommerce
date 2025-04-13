<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// obtener el usuario (solo para usuarios autenticados)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// registro de usuarios
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

// login de usuarios
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

// logout de usuarios (solo para usuarios autenticados)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])
    ->name('logout');
