<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }
        } catch (TokenInvalidException) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (TokenExpiredException) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (Exception $e) {
            return response()->json(['error' => 'Authorization token not found'], 401);
        }

        return $next($request);
    }
}
