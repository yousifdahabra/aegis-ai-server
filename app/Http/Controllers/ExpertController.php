<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expert\RegisterExpertRequest;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\UserService;
use App\Services\ExpertService;

class ExpertController extends Controller{

    protected $user_service;
    protected $expert_service;

    function __construct(UserService $user_service,ExpertService $expert_service){
        $this->user_service = $user_service;
        $this->expert_service = $expert_service;
    }

    function register(RegisterExpertRequest $request){
        $data =  $request->validated();

        $user = $this->user_service->register($data,2);
        $data['user_id'] = $user->id;
        $expert = $this->expert_service->store($data);
        $expert_request_id = $expert->id;
        $data['expert_request_id'] = $expert_request_id;
        $expert_request = $this->expert_service->store_files($data);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            "data" => $user,
            "token" => $token,
            "message" => 'insert expert',
        ], 201);
    }
    public function show($id = 0){
        $user = $this->user_service->get_users($id,2);

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
        $user = $this->user_service->delete($id);
        $expert = $this->expert_service->delete($id);

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
    public function get_expert_request(){
        $user = $this->user_service->get_expert_request();

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
    public function accept_request($id){
        $expert = $this->expert_service->accept_request($id);

        if(!$expert){
            return response()->json([
                'status' => false,
                'message' => 'Expert error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Update Expert successfully',
            'data' => $expert
        ], 200);
    }

    public function reject_request($id){
        $expert = $this->expert_service->reject_request($id);

        if(!$expert){
            return response()->json([
                'status' => false,
                'message' => 'Expert error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Update Expert successfully',
            'data' => $expert
        ], 200);
    }


}
