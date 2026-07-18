<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthReport;
use Illuminate\Http\Request;

class HealthReportController extends Controller
{
public function index()
{
    return auth()->user()->healthReports;

    $query = $request->user()->reports(); //Only user's reports

    // Filter by severity
    if ($request->has('severity')) {
        $query->where('severity', strtolower($request->severity));
    }

    // Filter by location
    if ($request->has('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
    }

    // Filter by disease
    if ($request->has('disease')) {
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

    // ✅ Attach logged-in user
    $validated['user_id'] = auth()->id();

    $report = HealthReport::create($validated);

    return response()->json([
        'status' => 'success',
        'message' => 'Health report created successfully',
        'data' => $report
        ], 201);
    }

    // GET SINGLE REPORT
    public function show(Request $request, int $id)
    {
    $report = $request->user()->reports()->findOrFail($id);

        return response()->json([
        'status' => 'success',
        'data' => $report
        ]);
    }

    // UPDATE REPORT
    public function update(Request $request, int $id)
    {
        $report = $request->user()->reports()->findOrFail($id);

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
   public function destroy(Request $request, int $id)
        {
        $report = $request->user()->reports()->findOrFail($id);

        $report->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Report deleted successfully'
        ]);
    }
}
