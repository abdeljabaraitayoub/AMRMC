<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicsRequest;
use App\Http\Requests\UpdateMedicsRequest;
use App\Models\Medics;

class MedicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medics = Medics::all();
        return $medics;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Medics $medics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medics $medics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicsRequest $request, Medics $medics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medics $medics)
    {
        //
    }
}
