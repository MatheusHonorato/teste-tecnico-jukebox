<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            $token = auth()->user()->createToken('authToken')->plainTextToken;

            return response()->json(
                ['status' => true,'token_type' => 'Bearer','access_token' => $token],
                JsonResponse::HTTP_OK
            );
        }

        return response()->json(['status' => false, 'error' => 'Unauthorized'], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
