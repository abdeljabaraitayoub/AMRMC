<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            try {
                // dd(JWTAuth::getToken());
                $refreshed = JWTAuth::refresh(JWTAuth::getToken());
                $user = JWTAuth::setToken($refreshed)->toUser();
                $response = $next($request);
                header('Access-Control-Expose-Headers: token, X-RateLimit-Limit, X-RateLimit-Remaining');
                // header('token:' . "token");

                header('token:' . $refreshed);

                return $next($request);
            } catch (JWTException $e) {
                return response()->json(['error' => 'Token cannot be refreshed: ' . $e->getMessage()], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid: ' . $e->getMessage()], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }

        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        if ($user->role != $role) {
            return response()->json(['message' => "You do not have access to this page"], 403);
        }

        return $next($request);
    }
}
