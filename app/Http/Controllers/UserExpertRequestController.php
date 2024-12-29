<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddUserExpertRequestsRequest;
use App\Http\Requests\Test\UpdateUserExpertRequestsRRequest;
use App\Http\Resources\UserExpertRequestResource;
use App\Services\UserExpertRequestService;

class UserExpertRequestController extends Controller{
    protected $user_expert_request;

    function __construct(UserExpertRequestService $user_expert_request){
        $this->user_expert_request = $user_expert_request;
    }

    public function show($id = 0){
        $user_expert_request = $this->user_expert_request->get_user_expert_requests($id);

        if(!$user_expert_request){
            return response()->json([
                'status' => false,
                'message' => 'Expert User Expert Request',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get User Expert Request successfully',
            'data' => $id == 0 ? UserExpertRequestResource::collection($user_expert_request):new UserExpertRequestResource($user_expert_request),
        ], 200);
    }

    function store(AddUserExpertRequestsRequest $request){
        $data =  $request->validated();
        $user_expert_request = $this->user_expert_request->store($data);
        return response()->json([
            'status' => true,
            "data" => new UserExpertRequestResource($user_expert_request),
            "message" => 'User Expert Request created successfully',
        ], 201);
    }

    function update(UpdateUserExpertRequestsRRequest $request,$id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'User Expert Request Error',
            ], 422);
        }

        $data =  $request->validated();
        $user_expert_request = $this->user_expert_request->update($data,$id);

        if(!$user_expert_request){
            return response()->json([
                'status' => false,
                'message' => 'User Expert Request not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            "data" => new UserExpertRequestResource($user_expert_request),
            "message" => 'User Expert Request update successfully',
        ], 201);
    }

}
