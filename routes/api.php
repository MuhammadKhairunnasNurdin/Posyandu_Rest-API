<?php

use Illuminate\Support\Facades\Route;

Route::post('user/login', [\App\Http\Controllers\Auth\AuthController::class, 'authenticate']);
Route::group(
    [
        'middleware' => 'jwt.auth',
        'prefix' => 'user',
    ],
    function () {
        Route::post('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
    }
);
Route::group(
    [
        'middleware' => [
            'jwt.auth',
            'authorization:' . \App\Enum\User\RoleEnum::ADMIN->value
        ],
        'prefix'=> 'user',
    ],
    function () {
        Route::get('users', [\App\Http\Controllers\User\UserController::class, 'index']);
    }
);
