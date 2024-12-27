<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Expert\RegisterExpertRequest;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Services\UserService;
use App\Services\ExpertService;

class ExpertController extends Controller
{
    protected $userService;
    protected $expertService;

    function __construct(UserService $userService,ExpertService $expertService){
        $this->userService = $userService;
        $this->expertService = $expertService;
    }

    function register(RegisterExpertRequest $request){
        $data =  $request->validated();

        $user = $this->userService->register($data,2);
        $data['user_id'] = $user->id;
        $expert = $this->expertService->store($data);
        $expert_request_id = $expert->id;
        $data['expert_request_id'] = $expert_request_id;
        $expert_request = $this->expertService->store_files($data);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            "data" => $user,
            "token" => $token,
            "message" => 'insert expert',
        ], 201);
    }
    public function show($id = 0){
        $user = $this->userService->get_users($id,2);

        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Expert error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get Expert successfully',
            'data' => $user
        ], 200);
    }

    public function destroy($id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Expert Error',
            ], 422);
        }
        $user = $this->userService->delete($id);
        $expert = $this->expertService->delete($id);

        if(!$user){
            return response()->json([
                'status' => false,
                'message' => 'Expert not found',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Expert deleted successfully',
            'data' => [$user,$expert]
        ], 200);

    }

}
