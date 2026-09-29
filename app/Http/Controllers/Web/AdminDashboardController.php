<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $pendingReports = Report::with('user:id,name')
                                ->where('status', 'pending')
                                ->latest()
                                ->get();

        return view('admin.dashboard', ['reports' => $pendingReports]);
    }
}