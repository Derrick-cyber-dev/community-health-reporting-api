<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthReportController;
use App\Http\Controllers\Api\AuthController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('reports', HealthReportController::class);
});
