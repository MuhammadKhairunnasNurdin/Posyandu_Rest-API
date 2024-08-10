<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Shared\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticate login request.
     */
    public function authenticate(LoginRequest $request): JsonResponse
    {
        $token = $request->authenticate();
        return (new UserResource(Auth::user()))
            ->additional([
                'data' => [
                    'token' => $token
                ]
            ])
            ->response();
    }

    /**
     * Logout current user.
     */
    public function logout(User $user): JsonResponse
    {
       auth()->logout();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
