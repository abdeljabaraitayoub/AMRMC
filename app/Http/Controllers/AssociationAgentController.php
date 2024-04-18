<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssociationAgentRequest;
use App\Http\Requests\UpdateAssociationAgentRequest;
use App\Models\Association;
use App\Models\AssociationAgent;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use App\Mail\SendPassword;
use Illuminate\Support\Facades\Mail;

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
        $password = str::random(8);
        $association = $this->getAssociation();
        $role = 'association_agent';
        $request->merge(['password' => $password, 'city' => $association->city, 'role' => $role, 'image' => $association->image]);
        $user = User::create($request->all());
        $request->merge(['id' => $user->id, 'association_id' => $association->id,  'country' => $association->country]);
        $associationAgent = AssociationAgent::create($request->all());
        mail::to($request->email)->send(new SendPassword($request->email, $password));

        activity('create Association Agent')
            ->performedOn($associationAgent)
            ->causedBy(auth()->user())
            ->withProperties($request->all())
            ->log('Association Agent created successfully');
        return response()->json(["message" => "agent is created succefully !", 'agent' => $associationAgent], 201);
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
        activity('update Association Agent')
            ->performedOn($associationAgent)
            ->causedBy(auth()->user())
            ->withProperties($request->all())
            ->log('Association Agent updated successfully');
        return response()->json(["message" => "agent is updated succefully !", 'agent' => $associationAgent], 200);
    }

    public function getAgentsByAssociation()
    {
        $user = auth()->user();
        $association = $this->getAssociation();
        $agents = AssociationAgent::join('associations', 'associations.id', '=', 'association_agents.association_id')
            ->join('users', 'users.id', '=', 'association_agents.id')
            ->where('association_agents.association_id', $association->id)
            ->whereNull('associations.deleted_at')
            ->whereNull('users.deleted_at')
            ->where('users.id', '!=', $user->id)
            ->paginate(5);
        return $agents;
    }

    public function getAssociation()
    {
        $user = auth()->user();
        $user = AssociationAgent::where('id', $user->id)->first();
        $association = Association::find($user->association_id);

        return $association;
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
