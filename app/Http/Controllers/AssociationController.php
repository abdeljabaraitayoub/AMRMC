<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssociationRequest;
use App\Http\Requests\UpdateAssociationRequest;
use App\Models\Association;
use App\Models\AssociationAgent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPassword;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        DB::enableQueryLog();

        $associations = Association::orderBy('id', 'asc')->paginate(5);
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


    public function updateCurrentAssociation(Request $request)
    {
        $association = $this->getCurrentAssociation();
        $association->update($request->all());
        return response()->json($association, 200);
    }


    public function getCurrentAssociation()
    {
        $user = auth()->user();
        $user = AssociationAgent::where('id', $user->id)->first();
        $association = Association::find($user->association_id);
        return $association;
    }

    public function image(Request $request)
    {
        $association = $this->getCurrentAssociation();
        $file = $request->file('image');
        $name = $request->name;
        $filename = $file->hashName();
        $path = $name . '/' . 'Avatar' . $filename;
        $image = Image::make($file)->fit(256, 256)->encode('jpg', 40);
        Storage::disk('Associations')->put($path, (string) $image);
        $url = Storage::disk('Associations')->url($path);
        $association->image = $url;
        $association->save();
        return response()->json($association, 200);
    }

    public function destroyimage()
    {
        Storage::disk('Associations')->delete($this->getCurrentAssociation()->image);
        $association = $this->getCurrentAssociation();
        $association->image = null;
        $association->save();
        return response()->json($association, 200);
    }
}
