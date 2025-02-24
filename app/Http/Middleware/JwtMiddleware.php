<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
    } catch (Exception $e) {
        if ($e instanceof TokenInvalidException) {
            return response()->json(['status'=>'invalid token']);
        }
        if ($e instanceof TokenExpiredException) {
            return response()->json(['status'=>'expired token']);
        }

        return response()->json(['status'=>'token not found']);
    }
    return $next($request);
    }
}
