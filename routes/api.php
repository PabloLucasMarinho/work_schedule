<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', [TokenController::class, 'store'])->name('auth.store');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [TokenController::class, 'destroy'])->name('auth.destroy');

        Route::apiResource('employee', EmployeeController::class);

        Route::apiResource('schedule', ScheduleController::class);
    });
});
