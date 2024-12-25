<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ExpertMiddleware
{
    public function handle($request, Closure $next)
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 401);
            }
            if($user['user_role_id'] == 3){
                return response()->json(['error' => 'You are not Authorization'], 401);
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
