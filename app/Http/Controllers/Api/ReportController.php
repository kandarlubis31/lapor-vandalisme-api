<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->reports()->latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|in:vandalisme,pembakaran,perusakan,lainnya',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'media' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mediaPath = $request->file('media')->store('reports_media', 'public');

        $report = $request->user()->reports()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'media_url' => $mediaPath,
        ]);

        return response()->json($report, 201);
    }

    public function show(Request $request, Report $report)
    {
        if ($request->user()->id !== $report->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($report);
    }

    public function update(Request $request, Report $report)
    {
        if ($request->user()->id !== $report->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'category' => 'sometimes|required|string|in:vandalisme,pembakaran,perusakan,lainnya',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $report->update($validator->validated());

        return response()->json($report);
    }

    public function destroy(Request $request, Report $report)
    {
        if ($request->user()->id !== $report->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($report->media_url);
        $report->delete();

        return response()->json(['message' => 'Report successfully deleted']);
    }
}