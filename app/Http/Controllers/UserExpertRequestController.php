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

}
