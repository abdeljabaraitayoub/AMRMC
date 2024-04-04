<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssociationRequest;
use App\Http\Requests\UpdateAssociationRequest;
use App\Models\Association;
use App\Models\AssociationAgent;
use App\Models\User;
use AWS\CRT\HTTP\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPassword;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $associations = Association::paginate(5);
        return $associations;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssociationRequest $request)
    {
        // Create an association
        $association = Association::create($request->all());
        // Create a user
        $password = Str::random(8);
        $role = 'association_agent';
        $request->merge(['role' => $role]);
        $request->merge(['password' => bcrypt($password)]);
        $user = User::create($request->all());
        // Attach the user to the association
        $association_id = $association->id;
        $user_id = $user->id;
        $request->merge(['association_id' => $association_id, 'id' => $user_id, 'position' => 'president', 'bio' => $association->description]);
        $association_agent = AssociationAgent::create($request->all());
        Mail::to($association->email)->send(new SendPassword($user->email, $password));

        return response()->json(['association' => $association, 'user' => $user, 'password' => $password, 'agent' => $association_agent], 201);
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
