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
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return User::orderBy('id', 'desc')
            ->paginate(5);

        // ->where('role', '=', $request->role) 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'date_of_birth' => 'required|date',
            'city' => 'required',
            'address' => 'required',
            'role' => 'required',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('img');
        $name = $request->name;
        $filename = $file->hashName();
        $path = $name . '/' . 'Avatar' . $filename;
        $image = Image::make($file)->fit(256, 256)->encode('jpg', 40);
        Storage::disk('Users')->put($path, (string) $image);
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
        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
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
        $request->validate([
            'name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'date_of_birth' => 'date',
            'password' => 'string|min:8',
            'city' => '',
            'address' => '',
            'role' => '',
        ]);
        $user->update($request->all());
        activity('update User')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties($request->all())
            ->log('User updated successfully');
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
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

    public function myimage(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $file = $request->file('img');
        $name = $user->name;
        $filename = $file->hashName();
        $path = $name . '/' . 'Avatar' . $filename;
        $image = Image::make($file)->fit(256, 256)->encode('jpg', 40);
        Storage::disk('Users')->put($path, (string) $image);
        $url = Storage::disk('Users')->url($path);
        $request->merge(['image' => $url]);
        $user->update($request->all());
        activity('update image')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties($request->all())
            ->log('User updated successfully');
        return response()->json(['message' => 'image updated succesfully !'], 200);
    }

    public function myupdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'date_of_birth' => 'date',
            'password' => 'string|min:8',
            'city' => '',
            'address' => '',
            'role' => '',
        ]);
        $user = User::find($user->id);
        $user->update($request->all());
        activity('update User')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties($request->all())
            ->log('User updated successfully');
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    public function image(User $user, Request $request)
    {

        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $file = $request->file('img');
        if ($user->image) {
            $image = $user->image;
            $image = explode('/', $image);
            $image = end($image);
            Storage::disk('Users')->delete($user->name . '/' . 'Avatar' . $image);
        }
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $name = $user->name;
            $filename = $file->hashName();
            $path = $name . '/' . 'Avatar' . $filename;
            $image = Image::make($file)->fit(256, 256)->encode('jpg', 40);
            Storage::disk('Users')->put($path, (string) $image);
            $url = Storage::disk('Users')->url($path);
            $request->merge(['image' => $url]);
            $user->update($request->all());
            activity('update image')
                ->performedOn($user)
                ->causedBy(Auth::user())
                ->withProperties($request->all())
                ->log('User updated successfully');
            return response()->json(['message' => 'image updated succesfully !'], 200);
        } else {
            return response()->json(['message' => 'image not uploaded succesfully !'], 400);
        }
    }
}
