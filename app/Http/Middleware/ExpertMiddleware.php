<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ExpertMiddleware{

    public function handle($request, Closure $next){

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ], 401);
            }
            if ($user['user_role_id'] != 2) {
                return response()->json([
                    'status' => false,
                    'message' => 'You are not authorized',
                ], 401);
            }
        } catch (TokenInvalidException) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid',
            ], 401);
        } catch (TokenExpiredException) {
            return response()->json([
                'status' => false,
                'message' => 'Token has expired',
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization token not found',
            ], 401);
        }

        return $next($request);
    }
}
