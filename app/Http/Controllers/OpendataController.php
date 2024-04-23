<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class OpendataController extends Controller
{
    public function export(Request $request, $format)
    {
        $model = $request->model;
        $data = $this->getData($model);
        if ($format == 'csv') {
            $filename = $this->exportCsv($data, $model);
        } else {
            $filename = $this->exportJson($data, $model);
        }
        return response()->download($filename);
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

    public function getData($model)
    {
        $model = 'App\Models\\' . $model;
        return $model::all()->toArray();
    }
}
