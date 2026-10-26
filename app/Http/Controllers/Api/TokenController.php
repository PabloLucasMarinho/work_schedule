<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response(null, Response::HTTP_UNAUTHORIZED);
        }

        $token = Auth::user()->createToken('auth', expiresAt: now()->addWeek())->plainTextToken;

        return response([
            'data' => ['token' => $token],
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $request->user()->tokens()->delete();

        return response(null, Response::HTTP_OK);
    }
}
