<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

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

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $this->errorResponseWithMessage(
                'Error de validación.',
                422,
                $validator->errors()
            );
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponseWithData(
            [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ],
            'Usuario registrado correctamente.'
        );
    }
}
