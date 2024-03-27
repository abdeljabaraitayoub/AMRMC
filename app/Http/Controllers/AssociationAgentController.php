<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssociationAgentRequest;
use App\Http\Requests\UpdateAssociationAgentRequest;
use App\Models\AssociationAgent;

class AssociationAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agents = AssociationAgent::join('associations', 'associations.id', '=', 'association_agents.association_id')
            ->join('agents', 'agents.id', '=', 'association_agents.agent_id')
            ->select('association_agents.*', 'associations.name as association_name', 'agents.name as agent_name')
            ->get();
        return AssociationAgent::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssociationAgentRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(AssociationAgent $associationAgent)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssociationAgentRequest $request, AssociationAgent $associationAgent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssociationAgent $associationAgent)
    {
        $associationAgent->delete();
        return response()->json(null, 204);
    }
}
