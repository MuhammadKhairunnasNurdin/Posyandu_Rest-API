<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Authenticate login request.
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
        $token = $request->authenticate();
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60 . ' second'
            ],
        ]);
    }

    /**
     * Logout current user.
     */
    public function logout(): JsonResponse
    {
       auth()->logout();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
