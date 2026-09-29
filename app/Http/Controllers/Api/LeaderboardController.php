<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaderboard = User::select('id', 'name', 'points')
                           ->where('role', 'user')
                           ->orderByDesc('points')
                           ->take(10)
                           ->get();

        return response()->json($leaderboard);
    }
}