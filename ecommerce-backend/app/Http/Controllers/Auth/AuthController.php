<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    // registro
    public function register(Request $request): JsonResponse
    {
        // se validan los datos de entrada para el registro del usuario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed' // confirmed garantiza que la contraseña haya sido confirmada desde el cliente (password_confirmation)
        ]);

        // se crea el usuario en la tabla users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // se inicia sesion automaticamente luego del registro del usuario
        Auth::login($user);

        // se retorna el usuario autenticado como JSON
        return response()->json([
            'message' => 'Usuario registrado. Revisa tu correo para verificar tu cuenta',
            'user' => $user
        ]);
    }

    // inicio de sesion
    public function login(Request $request) {
        // se validan los datos de entrada para autenticar el usuario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // intentar autenticar con email y password
        if (!Auth::attempt($request->only('email', 'password'))) {
            // si falla la autenticacion, se retorna un 401 UNAUTHORIZED
            return response()->json(['message' => 'Credenciales invalidas'], 401);
        }

        // si la autenticacion fue exitosa se regenera la sesion
        $request->session()->regenerate(); // previene session fixation (regenera el id de la sesion)
        return response()->json(Auth::user()); // se retorna el usuario autenticado como JSON
    }

    public function logout(Request $request) {
        // cierra la sesion actual (config/auth.php, guard debe tener el valor web)
        Auth::guard('web')->logout();

        // invalida la sesion del usuario actual
        $request->session()->invalidate();

        // regenera el token CSRF para evitar ataques de falsificacion
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada']); // se retorna una respuesta de exito
    }
}
