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

        
    
    }

}
