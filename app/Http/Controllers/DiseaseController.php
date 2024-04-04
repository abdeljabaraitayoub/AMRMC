<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiseaseRequest;
use App\Http\Requests\UpdateDiseaseRequest;
use App\Models\Disease;
use Illuminate\Support\Facades\DB;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diseases = Disease::withCount('patients')
            ->paginate(5);
        return $diseases;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiseaseRequest $request)
    {
        $disease = Disease::create($request->all());
        activity('create Disease')
            ->performedOn($disease)
            ->causedBy(auth()->user())
            ->withProperties($request->all())
            ->log('Disease created successfully');
        return response()->json($disease, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Disease $disease)
    {
        return $disease;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiseaseRequest $request, Disease $disease)
    {
        $disease->update($request->all());
        activity('update Disease')
            ->performedOn($disease)
            ->causedBy(auth()->user())
            ->withProperties($request->all())
            ->log('Disease updated successfully');
        return response()->json($disease, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disease $disease)
    {
        $disease->delete();
        activity('delete Disease')
            ->performedOn($disease)
            ->causedBy(auth()->user())
            ->log('Disease deleted successfully');
        return response()->json(['message' => 'Disease deleted successfully'], 200);
    }
}
