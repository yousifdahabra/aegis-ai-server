<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\UserService;

class UserController extends Controller
{

    protected $userService;

    function __construct(UserService $userService){
        $this->userService = $userService;
    }

    function register(RegisterUserRequest $request){
        $data =  $request->validated();

        $user = $this->userService->register($data);

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

    public function show($id = ''){

    }

    public function update(RegisterUserRequest $request, $id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Customer Error',
            ], 422);
        }
        $data =  $request->validated();
        $user = $this->userService->update($data,$id);
        if($user){
            return response()->json([
                'status' => true,
                'message' => 'Customer updated successfully',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Customer not found',
        ], 200);

    }

}
