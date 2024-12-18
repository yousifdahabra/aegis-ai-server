<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    function register(RegisterUserRequest $request){
        $data =  $request->validated();

        $user = new User;
        $user->user_role_id = 1; 
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->password = Hash::make($data['password']);
        $user->save();
        $token = JWTAuth::fromUser($user);

        return response()->json([
            "data" => $user, 
            "token" => $token, 
            "message" => 'insert user', 
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
                "user" => $user, 
                "token" => $token,
                "message" => 'login succ', 

            ], 201);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

}
