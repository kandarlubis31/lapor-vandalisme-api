<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportValidationController extends Controller
{
    public function index()
    {
        return Report::with('user:id,name,email')
                     ->where('status', 'pending')
                     ->latest()
                     ->paginate(15);
    }

    public function validateReport(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|string|in:valid,ditolak',
        ]);

        if ($report->status !== 'pending') {
            return response()->json(['message' => 'This report has already been processed.'], 409);
        }

        $report->status = $request->status;
        $report->save();

        if ($report->status === 'valid') {
            $reporter = $report->user;
            $reporter->points += 10; // Kasih 10 poin untuk laporan valid
            $reporter->save();
        }

        return response()->json([
            'message' => "Report status updated to {$report->status}",
            'report' => $report,
        ]);
    }
}