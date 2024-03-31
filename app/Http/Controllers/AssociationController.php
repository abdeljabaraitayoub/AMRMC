<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssociationRequest;
use App\Http\Requests\UpdateAssociationRequest;
use App\Models\Association;
use Illuminate\Support\Facades\DB;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $associations = Association::all();
        return $associations;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssociationRequest $request)
    {
        $association = Association::create($request->all());
        return response()->json($association, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Association $association)
    {
        return $association;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssociationRequest $request, Association $association)
    {
        $association->update($request->all());
        return response()->json($association, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Association $association)
    {
        $association->delete();
        return response()->json(['message' => 'Association deleted successfully', 'query' => DB::getQueryLog()], 200);
    }
}
