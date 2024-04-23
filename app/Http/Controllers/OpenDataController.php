<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpenDataRequest;
use App\Http\Requests\UpdateOpenDataRequest;
use App\Models\OpenData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestAccepted;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Termwind\Components\Dd;

class OpenDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = OpenData::with('user')->get();
        return response()->json($requests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOpenDataRequest $request)
    {
        $role = "analyst";
        $request->merge(['role' => $role]);
        $password = Str::random(8);
        $request->merge(['password' => $password]);
        $user = User::create($request->all());;
        $openData = openData::create([
            'tables' => $request->tables,
            'user_id' => $user->id,
        ]);
        return response()->json(['message' => 'Request sent', 'data' => $openData]);
    }

    public function accept(OpenData $openData)
    {
        $openData->update([
            'accepted_at' => now(),
        ]);
        $links = [];
        $data = [];
        $tables = $openData->tables;
        foreach ($tables as $table) {
            $data[] = [
                'model' => $table,
                'links' => [
                    'csv' => route('openData.export', ['model' => $table, 'format' => 'csv']),
                    'json' => route('openData.export', ['model' => $table, 'format' => 'json'])
                ]
            ];
        }
        // dd($data);
        $email = $openData->user->email;

        Mail::to($email)->send(new RequestAccepted($openData->user, $data));
        return response()->json(['message' => 'Accepted', 'links' => $links]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpenData $openData)
    {
        $openData->delete();
        return response()->json(['message' => 'Request deleted']);
    }

    public function getData($model)
    {
        if (!class_exists('App\Models\\' . $model)) {
            die('Model not found');
        }
        $model = 'App\Models\\' . $model;
        return $model::all()->toArray();
    }
    public function export(Request $request, $model, $format)
    {
        $data = $this->getData($model);
        if ($format == 'csv') {
            $filename = $this->exportCsv($data, $model);
        } else {
            $filename = $this->exportJson($data, $model);
        }
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    public function exportCsv($data = [], $model)
    {

        $filename = $model . '.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array_keys($data[0]));
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
        return $filename;
    }

    public function exportJson($data = [], $model)
    {
        $filename = $model . '.json';
        $handle = fopen($filename, 'w+');
        fwrite($handle, json_encode($data));
        fclose($handle);
        return $filename;
    }
}
