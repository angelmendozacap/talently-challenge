<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::group(['prefix' => 'v1'], function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('logout');
});
