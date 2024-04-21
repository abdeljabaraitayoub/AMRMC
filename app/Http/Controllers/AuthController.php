<?php

namespace App\Http\Controllers;

use App\Models\AssociationAgent;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = new User;
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Credenials are wrong !'], 422);
        }
        activity('login')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->withProperties($request->all())
            ->log('User logged in successfully');
        return $this->respondWithToken($token);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            // 'date_of_birth' => 'required|date',
            'country' => 'required|string',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone =  $request->phone;
        $user->role = $request->role;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->date_of_birth = $request->date_of_birth;
        $user->country = $request->country;
        $user->save();
        activity('register')
            ->performedOn($user)
            ->causedBy($user->id)
            ->withProperties($request->all())
            ->log('User created successfully');
        return response()->json(['message' => 'User created successfully'], 201);

        // dd(Auth::user());

    }


    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = new User;
        activity('logout')
            ->performedOn($user)
            ->causedBy(Auth::user())
            ->log('User logged out successfully');
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {

        if (auth()->user()->role == 'association_agent') {
            $role = AssociationAgent::find(auth()->user()->id)->position;
        } else {
            $role = auth()->user()->role;
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'message' => 'User logged in successfully',
            'user' => auth()->user(),
            'role' => $role,
        ]);
    }
}
