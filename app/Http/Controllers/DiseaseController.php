<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiseaseRequest;
use App\Http\Requests\UpdateDiseaseRequest;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Disease::query();
        if ($request->has('all') && $request->get('all') == 'true') {
            $diseases = $query->get();
        } else {
            $diseases = $query->paginate(5);
        }
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
        return response()->json(['message' => 'Disease created successfully', 'disease' => $disease], 201);
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
        return response()->json(['message' => 'Disease updated successfully', 'disease' => $disease], 200);
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
