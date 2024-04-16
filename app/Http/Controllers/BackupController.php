<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folderPath = '/AMRMC';
        $files = Storage::disk('backups')->allFiles($folderPath);

        $fileData = collect($files)->map(function ($file) {
            return [
                'name' => $file,
                'url' => Storage::disk('backups')->url($file)
            ];
        });
        return $fileData;
        // dd($fileData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $artisan = Artisan::call('backup:run');
        return response()->json(['message' => 'Backup created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
