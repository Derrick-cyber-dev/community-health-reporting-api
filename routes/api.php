<?php

use App\Http\Controllers\Api\HealthReportController;
use Illuminate\Support\Facades\Route;
use App\Models\HealthReport;

Route::get('/reports', function () {
    return response()->json([
        'status' => 'success',
        'data' => HealthReport::where('severity', 'high')->get()
    ]);
});

Route::post('/reports', [HealthReportController::class, 'store']);



