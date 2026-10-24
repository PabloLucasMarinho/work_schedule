<?php

use App\Http\Controllers\Api\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', [TokenController::class, 'store'])->name('auth.store');
    });

    // Route::middleware('auth:sanctum')->group(function() {
    //     Route::post()
    // });
});
