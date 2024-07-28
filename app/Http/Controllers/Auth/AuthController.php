<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Shared\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Authenticate login request.
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate();
        return (new UserResource($user))
            ->additional([
                'data' => [
                    'token' => $user->createToken('auth_token')->plainTextToken
                ]
            ])
            ->response();
    }

    /**
     * Logout current user.
     */
    public function logout(User $user): JsonResponse
    {
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
