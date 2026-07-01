<?php

use Illuminate\Support\Facades\Route;
use App\Models\HealthReport;

Route::get('/reports', function () {
    return response()->json([
        'status' => 'success',
        'message' => HealthReport::where('severity', 'high')->get()
    ]);
});


