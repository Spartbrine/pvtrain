<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponseWithData(
                [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ],
                'Usuario autenticado correctamente.'
            );
        }

        return $this->errorResponseWithMessage(
            'No autorizado.',
            401,
            'Credenciales inválidas.'
        );
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $this->successResponseWithData(
            [],
            'Usuario registrado correctamente.'
        );
    }
}
