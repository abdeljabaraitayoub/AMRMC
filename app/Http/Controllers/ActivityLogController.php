<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::with('causer', 'subject')->orderBy('id', 'desc')->paginate(6);
        foreach ($activities as $activity) {
            $activity->time_passed = Carbon::parse($activity->created_at)->diffForHumans();
        }
        return ActivityResource::collection($activities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        DB::enableQueryLog();
        $Activity = Activity::with('causer')->where('causer_id', $id)->get();
        return response()->json($Activity, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
