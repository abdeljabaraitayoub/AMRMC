<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicsRequest;
use App\Http\Requests\UpdateMedicsRequest;
use App\Models\Medics;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MedicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medics = Medics::paginate(5);
        return $medics;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicsRequest $request)
    {
        $file = $request->file('file');
        $name = $request->name;
        Storage::disk('medics')->put($name, file_get_contents($file));
        $url = Storage::disk('medics')->url($name);
        $request->merge(['image' => $url]);
        $medics = Medics::create($request->all());
        activity('create Medics')
            ->performedOn($medics)
            ->causedBy(auth()->user())
            ->withProperties($request->all())
            ->log('Medics created successfully');
        return response()->json(['url' => $url, 'medics' => $medics], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medics = Medics::findOrFail($id);
        return $medics;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicsRequest $request, $id)
    {
        $medics = Medics::findOrFail($id);
        $medics->update($request->all());
        activity('update Medics')
            ->performedOn($medics)
            ->causedBy(auth()->user())
            ->withProperties($request->all())
            ->log('Medics updated successfully');
        return response()->json($medics, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medics = Medics::findOrFail($id);
        $medics->delete();
        Storage::disk('medics')->delete($medics->image);
        activity('delete Medics')
            ->performedOn($medics)
            ->causedBy(auth()->user())
            ->log('Medics deleted successfully');
        return response()->json(['message' => 'Medics deleted successfully'], 200);
    }
}
