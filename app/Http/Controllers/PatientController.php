<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Association;
use App\Models\AssociationAgent;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        DB::enableQueryLog();
        $patients = Patient::join('users', 'users.id', '=', 'patients.id')
            ->leftjoin('associations', 'associations.id', '=', 'patients.association_id')
            ->leftjoin('diseases', 'diseases.id', '=', 'patients.disease_id')
            ->select('patients.*', 'users.*', 'users.name as user_name', 'associations.name as association_name', 'diseases.name as disease_name', 'diseases.id as disease')
            ->get();
        // dd(DB::getQueryLog());
        return $patients;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {

        $association = $this->getAssociation();
        $request->merge(['association_id' => $association->id]);
        $request->merge(['role' => 'patient']);
        $request->merge(['password' => 'password']);
        $user = User::create($request->all());
        $request->merge(['id' => $user->id]);
        $patient = Patient::create($request->all());
        return response()->json(['message' => 'Patient created successfully', 'patient' => $patient], 201);
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
        return response()->json(['message' => 'Patient updated successfully', 'patient' => $patient], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }


    public function getPatientByAssociation()
    {
        $user = auth()->user()->id;
        $associationId = AssociationAgent::where('id', $user)->first()->association_id;
        $patients = Patient::join('users', 'users.id', '=', 'patients.id')
            ->leftjoin('diseases', 'diseases.id', '=', 'patients.association_id')
            ->select('patients.*', 'users.*', 'users.name as user_name', 'diseases.name as disease_name')
            ->where('patients.association_id', $associationId)
            ->where('users.deleted_at', null)->paginate(5);
        return $patients;
    }

    public function getAssociation()
    {
        $user = auth()->user();
        $user = AssociationAgent::where('id', $user->id)->first();
        $association = Association::find($user->association_id);
        return $association;
    }
}
