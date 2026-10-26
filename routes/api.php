<?php

use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', [TokenController::class, 'store'])->name('auth.store');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [TokenController::class, 'destroy'])->name('auth.destroy');

        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
        Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/employee/{employee}', [EmployeeController::class, 'show'])->name('employee.show');
        Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/{employee}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    });
});
