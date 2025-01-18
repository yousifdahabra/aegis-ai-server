<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\UserService;
use Carbon\Carbon;

class UserController extends Controller{

    protected $user_service;

    function __construct(UserService $user_service){
        $this->user_service = $user_service;
    }

    function register(RegisterUserRequest $request){
        $data =  $request->validated();

        $user = $this->user_service->register($data);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            "user" => $user,
            "token" => $token,
            "message" => 'User created successfully',
        ], 201);
    }
    public function login(LoginRequest $request){
        $credentials = $request->validated();
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    "message" => 'Invalid credentials',
                ], 401);
            }

            $user = auth()->user();

            if($user->blocked){
                if ($user->role == 3)
                    return response()->json([
                        'status' => false,
                        "message" => 'You are not authrize to login',
                    ], 401);
                else if ($user->role == 2) {
                    return response()->json([
                        'status' => false,
                        "message" => 'Wait for application ',
                    ], 401);
                }
            }

            return response()->json([
                'status' => true,
                "user" => $user,
                "token" => $token,
                "message" => 'Login successfully',
            ], 201);
        } catch (JWTException $e) {

            return response()->json([
                'status' => false,
                "message" => 'Could not create token',
            ], 500);
        }
    }

    public function show($id = 0){
        $user = $this->user_service->get_users($id);
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Get User successfully',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'User error',
        ], 422);
    }

    public function update(UpdateUserRequest $request, $id){
        if (empty($id) || !is_numeric($id)) {
            return response()->json([
                'status' => false,
                "message" => 'User Error',
            ], 422);
        }
        $data =  $request->validated();
        $user = $this->user_service->update($data, $id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }
    public function destroy($id){
        if (empty($id) || !is_numeric($id)) {
            return response()->json([
                'status' => false,
                "message" => 'User Error',
            ], 422);
        }
        $user = $this->user_service->delete($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
            'data' => $user
        ], 200);
    }

    public function check_token_expiry(){
        try {
            $token = JWTAuth::getToken();

            if (!$token) {
                return response()->json(['status' => false, 'message' => 'Token not provided'], 400);
            }

            $payload = JWTAuth::getPayload($token);

            $expiry_time = Carbon::createFromTimestamp($payload->get('exp'));

            if ($expiry_time->isPast()) {
                try {
                    $new_token = JWTAuth::refresh($token);

                    return response()->json([
                        'status' => true,
                        'message' => 'Token expired. Token refreshed successfully.',
                        'token' => $new_token,
                    ], 200);
                } catch (JWTException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Unable to refresh token.',
                    ], 401);
                }

             }

            return response()->json([
                'status' => true,
                'message' => 'Token is valid',
                'token' => (string) $token,
            ], 200);

        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token is invalid',
            ], 401);
        }

    }

    public function block($id){
        if (empty($id) || !is_numeric($id)) {
            return response()->json([
                'status' => false,
                "message" => 'User Error',
            ], 422);
        }
        $user = $this->user_service->block_user($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'User blocked successfully',
            'data' => $user
        ], 200);
    }

}
