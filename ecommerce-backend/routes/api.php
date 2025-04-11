<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// registro de usuarios
Route::post('/register', [AuthController::class, 'register'])
    ->name('register');

// login de usuarios
Route::post('/login', [AuthController::class, 'login'])
    ->name('login');

// logout de usuarios (solo para usuarios autenticados)
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

// obtener el usuario (solo para usuarios autenticados)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function() {
    // mostrar mensaje que indique que el usuario debe verificar el mensaje enviado a su correo
    Route::get('/email/verify', function() {
        return response()->json(['message' => 'Debes verificar tu correo electrónico']);
    })->name('verification.notice');

    // endpoint par procesar la verificacion
    Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request) {
        $request->fulfill(); // marcar el email como verificado

        return response()->json(['message' => 'Correo verificado', 'data' => $request->user()]);
    })->middleware('signed')->name('verification.verify');

    // reenviar email de verificacion
    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Ya se ha verificado el correo']);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Correo de verificacion enviado']);
    })->name('verification.send');
});
