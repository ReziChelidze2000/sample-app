<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('books/latest-published', [BookController::class, 'latestPublishedBooks']);
        Route::apiResource('books', BookController::class);
    });
});
