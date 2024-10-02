<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 



class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Retornar errores de validación si los hay
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['message' => 'Usuario registrado con éxito', 'user' => $user], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken; // Asegúrate de tener Sanctum configurado
            return response()->json([
                'token' => $token,
                'user' => $user, // Incluye el usuario
                'message' => 'Inicio de sesión exitoso' // Mensaje de éxito
            ]);
        }
    
        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    public function getUser(Request $request)
    {
        return response()->json($request->user()); // Devuelve los datos del usuario autenticado
    }
    
}
