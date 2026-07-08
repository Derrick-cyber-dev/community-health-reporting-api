<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use Illuminate\Http\Request;

class HealthReportController extends Controller
{
    // GET ALL REPORTS
    public function index(Request $request)
    {
        $query = HealthReport::query();

        // Filter by severity
        if($request->has('severity')){
            $query->where('severity', strtolower($request->severity));
        }

        // Filter by location
        if($request->has('location')){
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by disease
        if($request->has('disease')){
            $query->where('disease_reported', 'like', '%' . $request->disease . '%');
        }

        $reports = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $reports
        ]);
    }

    // CREATE REPORT
    public function store(Request $request)
    {
        $validated = $request->validate([
            'worker_name' => 'required|string|max:255',
            'patient_count' => 'required|integer|min:1',
            'disease_reported' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'report_date' => 'required|date',
            'severity' => 'required|in:low,medium,high',
        ]);

        // Normalize severity
        $validated['severity'] = strtolower(trim($validated['severity']));

        $report = HealthReport::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Health report created successfully',
            'data' => $report
        ], 201);
    }

    // GET SINGLE REPORT
    public function show(int $id)
    {
        $report = HealthReport::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $report
        ]);
    }

    // UPDATE REPORT
    public function update(Request $request, int $id)
    {
        $report = HealthReport::findOrFail($id);

        $validated = $request->validate([
            'worker_name' => 'sometimes|string|max:255',
            'patient_count' => 'sometimes|integer|min:0',
            'disease_reported' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'report_date' => 'sometimes|date',
            'severity' => 'sometimes|in:low,medium,high',
        ]);

        if (isset($validated['severity'])) {
            $validated['severity'] = strtolower(trim($validated['severity']));
        }

        $report->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Health report updated successfully',
            'data' => $report
        ]);
    }

    // DELETE REPORT
    public function destroy(int $id)
    {
        $report = HealthReport::findOrFail($id);
        $report->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Report deleted successfully'
        ]);
    }
}
