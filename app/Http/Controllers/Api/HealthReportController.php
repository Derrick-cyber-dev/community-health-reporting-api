<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use Illuminate\Http\Request;

class HealthReportController extends Controller
{
    public function store(Request $request){
    $validated = $request->validate([
    'worker_name' => 'required|string|max:255',
    'patient_count' => 'required|integer|min:1',
    'disease_reported' => 'required|string',
    'location' => 'required|string',
    'report_date' => 'required|date',
    'severity' => 'required|string'
]);

    // Normalize input
    $validated['severity'] = strtolower(trim($validated['severity']));

    // Validate again manually
    if (!in_array($validated['severity'], ['low', 'medium', 'high'])) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid severity value'
        ], 422);
    }

    $report = HealthReport::create($validated);
    }
}
