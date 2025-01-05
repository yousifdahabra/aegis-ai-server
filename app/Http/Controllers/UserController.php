<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\UserService;

class UserController extends Controller
{

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
            "data" => $user,
            "token" => $token,
            "message" => 'User created successfully',
        ], 201);

    }
    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $user = auth()->user();

            return response()->json([
                'status' => true,
                "user" => $user,
                "token" => $token,
                "message" => 'login succ',
            ], 201);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    public function show($id = 0){
        $user = $this->user_service->get_users($id);
        if($user){
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
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'User Error',
            ], 422);
        }
        $data =  $request->validated();
        $user = $this->user_service->update($data,$id);

        if(!$user){
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
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'User Error',
            ], 422);
        }
        $user = $this->user_service->delete($id);
        if(!$user){
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
}
