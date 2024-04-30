<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\LoginController;
use App\Http\Controllers\API\v1\LogoutController;


Route::name('api.')->prefix('v1')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::middleware('jwt')->group(function () {
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});

