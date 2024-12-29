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

    function store(AddQuestionRequest $request){
        $data =  $request->validated();
        $user_expert_request = $this->user_expert_request->store($data);
        return response()->json([
            'status' => true,
            "data" => new UserExpertRequestResource($user_expert_request),
            "message" => 'Question created successfully',
        ], 201);
    }


}
