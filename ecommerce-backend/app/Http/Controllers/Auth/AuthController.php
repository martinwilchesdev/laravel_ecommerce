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
            'password' => Hash::make($request->password) // la contraseña se almacena encriptada usando el formato `bcrypt`
        ]);

        // se autentica el usuario automaticamente luego del registro del mismo
        Auth::login($user);

        // se retorna una respuesta en formato JSON, con la informacion del usuario creado
        return response()->json([
            'message' => 'Usuario registrado. Revisa tu correo para verificar tu cuenta',
            'user' => $user
        ]);
    }

    // inicio de sesion
    public function login(Request $request): JsonResponse
    {
        // se validan los datos de entrada para autenticar el usuario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // intentar autenticar con email y password
        if (!Auth::attempt($request->only('email', 'password'))) { // `$request->only()` permite obtener datos especificos de la `$request`
            // si falla la autenticacion, se retorna un 401 UNAUTHORIZED
            return response()->json(['message' => 'Contraseña o nombre de usuario incorrecto'], 401);
        }

        // si la autenticacion fue exitosa se regenera la sesion
        $request->session()->regenerate(); // previene session fixation (regenera el id de la sesion)

        return response()->json(Auth::user()); // se retorna una respuesta con el formato JSON, con la informacion del usuario autenticado
    }

    public function logout(Request $request): JsonResponse
    {
        // cierra la sesion actual (config/auth.php, guard debe tener el valor web)
        Auth::guard('web')->logout();

        // invalida la sesion del usuario actual
        $request->session()->invalidate();

        // regenera el token CSRF para evitar ataques de falsificacion
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada']); // se retorna una respuesta de exito
    }
}
