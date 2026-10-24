<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return new JsonResponse([
                'data' => [
                    'type' => 'error',
                    'attributes' => [
                        'success' => false,
                        'message' => 'Credenciais inválidas.',
                    ],
                ],
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = Auth::user()->createToken('auth', expiresAt: now()->addWeek())->plainTextToken;

        return new JsonResponse([
            'data' => [
                'type' => 'token',
                'attributes' => [
                    'success' => true,
                    'message' => 'Logado com sucesso.',
                    'token' => $token,
                ],
            ],
        ], Response::HTTP_CREATED);
    }
}
