<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class APIAuthController extends Controller
{
    /**
     * Iniciar sesión y crear un token.
     */
    public function login(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verificar las credenciales
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        //Auth::loginUsingId($user->id);

        // Obtener la lista de permisos del usuario
        $permissions = $user->getAllPermissions()->pluck('name')->toArray();

        // Crear un token con todos los permisos del usuario
        $token = $user->createToken('API Token', $permissions)->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'permissions' => $permissions,
        ], 200);
    }

    /**
     * Cerrar sesión y revocar el token actual.
     */
    public function logout(Request $request)
    {
        // Revocar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Token revocado exitosamente.',
        ], 200);
    }
}
