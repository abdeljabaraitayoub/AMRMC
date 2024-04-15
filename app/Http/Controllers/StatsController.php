<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Disease;
use App\Models\Medics;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
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

        $userGrowthRate = $this->calculateGrowthRate(User::class);
        $associationGrowthRate = $this->calculateGrowthRate(Association::class);
        $diseaseGrowthRate = $this->calculateGrowthRate(Disease::class);
        $medicsGrowthRate = $this->calculateGrowthRate(Medics::class);
        return response()->json([
            'users' => $users,
            'associations' => $associations,
            'diseases' => $diseases,
            'medics' => $medics,
            'userGrowthRate' => $userGrowthRate,
            'associationGrowthRate' => $associationGrowthRate,
            'diseaseGrowthRate' => $diseaseGrowthRate,
            'medicsGrowthRate' => $medicsGrowthRate
        ]);
    }

    public function calculateGrowthRate($model)
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();

        $countByMonth = $model::selectRaw('COUNT(*) as total, EXTRACT(MONTH FROM created_at) as month')
            ->whereBetween('created_at', [$lastMonthStart, $thisMonthEnd])
            ->groupBy('month')
            ->get();
        if ($countByMonth->count() == 2 && $countByMonth[0]['total'] > 0) {
            $growthRate = (($countByMonth[1]['total'] - $countByMonth[0]['total']) / $countByMonth[0]['total']) * 100;
            return number_format($growthRate, 2);
        }
    }
    /**
     * Display the specified resource.
     */
    public function associations()
    {
        $associations = Association::select('associations.*')
            ->selectRaw('COUNT(associations.id) as patients_count')
            ->join('patients', 'associations.id', '=', 'patients.association_id')
            ->groupBy('associations.id')
            ->orderByRaw('COUNT(associations.id) DESC')
            ->limit(5)
            ->get();
        return response()->json($associations);
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
