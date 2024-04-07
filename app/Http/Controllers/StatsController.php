<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Disease;
use App\Models\Medics;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function monthlyRegistrations()
    {
        $patients = User::where('role', 'patient')->select(DB::raw("EXTRACT(MONTH FROM created_at) as month"), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get()
            ->pluck('count');

        $users = User::select(DB::raw("EXTRACT(MONTH FROM created_at) as month"), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get()
            ->pluck('count');

        return response()->json([
            'patients' => $patients,
            'users' => $users
        ]);
    }
    public function patients_disease()
    {
        $diseases_count = Disease::withCount('patients')->get()
            ->pluck('patients_count');
        $names = Disease::with('patients')->get()
            ->pluck('name');
        return response()->json([
            'diseases' => $diseases_count,
            'names' => $names
        ]);
    }
    public function roles()
    {
        $rolesOfInterest = ['admin', 'doctor', 'patient'];

        // Fetch the count and percentage for each role
        $results = User::select(
            'role',
            User::raw('COUNT(*) as count'),
            User::raw('ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM users), 2) as percentage')
        )
            ->whereIn('role', $rolesOfInterest)
            ->groupBy('role')
            ->get();

        $count = $results->pluck('count');
        $roles = $results->pluck('role');
        $percentage = $results;

        return response()->json([
            'count' => $count,
            'roles' => $roles,
            'percentage' => $percentage
        ]);
    }

    public function counts()
    {
        $users = User::count();
        $associations = Association::count();
        $diseases = Disease::count();
        $medics = Medics::count();
        return response()->json([
            'users' => $users,
            'associations' => $associations,
            'diseases' => $diseases,
            'medics' => $medics
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
