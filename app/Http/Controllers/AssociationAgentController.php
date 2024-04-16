<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssociationAgentRequest;
use App\Http\Requests\UpdateAssociationAgentRequest;
use App\Models\AssociationAgent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AssociationAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = AssociationAgent::join('associations', 'associations.id', '=', 'association_agents.association_id')
            ->join('users', 'users.id', '=', 'association_agents.id')
            ->get();
        return $agents;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssociationAgentRequest $request)
    {
        $user = User::create($request->all());
        $request->merge(['id' => $user->id]);
        $associationAgent = AssociationAgent::create($request->all());
        return response()->json($associationAgent, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($associationAgent)
    {
        $agent = AssociationAgent::join('associations', 'associations.id', '=', 'association_agents.association_id')
            ->join('users', 'users.id', '=', 'association_agents.id')
            ->where('association_agents.id', $associationAgent)
            ->get();
        return $agent;
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssociationAgentRequest $request, $associationAgent)
    {
        $associationAgent = AssociationAgent::findOrFail($associationAgent);

        if ($associationAgent->id) {
            $user = User::findOrFail($associationAgent->id);
            $user->update($request->only(['name', 'email', 'phone', 'date_of_birth', 'country', 'city', 'address']));
        }
        $associationAgent->update($request->only(['association_id', 'position', 'bio']));
        return response()->json($associationAgent, 200);
    }

    public function getAgentsByAssociation()
    {
        $user = auth()->user()->id;
        $associationId = AssociationAgent::where('id', $user)->first()->association_id;
        $agents = AssociationAgent::join('associations', 'associations.id', '=', 'association_agents.association_id')
            ->join('users', 'users.id', '=', 'association_agents.id')
            ->where('association_agents.association_id', $associationId)
            ->where('users.deleted_at', null)
            ->where('users.id', '!=', $user)->paginate(5);
        return $agents;
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($associationAgent)
    // {
    //     $associationAgent = User::findOrFail($associationAgent);
    //     $associationAgent->update(['deleted_at' => now()]);

    //     return response()->json(null, 204);
    // }
}
