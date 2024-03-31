<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use App\Models\User;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Patient::join('users', 'users.id', '=', 'patients.id')
            ->join('associations', 'associations.id', '=', 'patients.id')
            ->join('diseases', 'diseases.id', '=', 'patients.id')
            ->select('patients.*', 'users.*', 'users.name as user_name', 'associations.name as association_name', 'diseases.name as disease_name')
            ->get();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $user = User::create($request->all());

        $request->merge(['id' => $user->id]);
        $patient = Patient::create($request->all());
        return response()->json($patient, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return Patient::join('users', 'users.id', '=', 'patients.id')
            ->join('associations', 'associations.id', '=', 'patients.id')
            ->join('diseases', 'diseases.id', '=', 'patients.id')
            ->select('patients.*', 'users.*', 'users.name as user_name', 'associations.name as association_name', 'diseases.name as disease_name')
            ->where('patients.id', $patient->id)
            ->first();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);

        if ($patient->id) {
            $user = User::findOrFail($patient->id);
            $user->update($request->only(['name', 'email', 'phone', 'date_of_birth', 'country', 'city', 'address']));
        }
        $patient->update($request->only(['medical_record_number', 'medical_history', 'association_id', 'disease_id']));
        return response()->json($patient, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
