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
        $activities = Activity::with('causer', 'subject')->orderBy('id', 'desc')->paginate(4);
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
        return ActivityResource::collection($Activity);
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


    public function getactivityperassociation()
    {
        $association = AssociationController::getCurrentAssociation();
        $activityLogs = Activity::select('activity_log.*', 'users.*', 'association_agents.position')
            ->join('users', 'activity_log.causer_id', '=', 'users.id')
            ->join('association_agents', 'users.id', '=', 'association_agents.id')
            ->where('association_agents.association_id', '=', $association->id)
            ->paginate(5);
        return ActivityResource::collection($activityLogs);
    }
}
