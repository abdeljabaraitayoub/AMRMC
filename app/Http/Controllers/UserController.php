<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\SendPassword;
use Illuminate\Support\Facades\Mail;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return User::paginate(5);

        // ->where('role', '=', $request->role) 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('img');
        $name = $request->name;
        $filename = $file->hashName();
        $path = $name . '/' . $filename;
        Storage::disk('Users')->put($path, file_get_contents($file));
        $url = Storage::disk('Users')->url($path);
        $request->merge(['image' => $url]);
        $password = str::random(8);
        $request->merge(['password' => $password]);
        mail::to($request->email)->send(new SendPassword($request->email, $password));
        $user = User::create($request->all());
        activity('create User')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties($request->all())
            ->log('User created successfully');
        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        activity('update User')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties($request->all())
            ->log('User updated successfully');
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        activity('delete User')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('User deleted successfully');
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
