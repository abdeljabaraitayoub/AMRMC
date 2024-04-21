<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;  // Add this line to import the JWTAuth facade
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class RefreshTokenMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->checkForToken($request);

        $token = auth()->refresh();

        // Send the refreshed token back to the client.
        return $this->AuthenticationHeader($next($request), $token);
    }

    /**
     * Set the Authentication Header with the refreshed token.
     *
     * @param  mixed  $response
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */

    protected function AuthenticationHeader($response, $token)
    {
        // Ensure the response is a type of response object
        if ($response instanceof \Illuminate\Http\Response || $response instanceof \Illuminate\Http\JsonResponse) {
            // Set the Authorization header
            $response->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $response;
    }
}
