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


    }

}
