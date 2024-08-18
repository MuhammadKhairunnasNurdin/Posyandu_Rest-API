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
