<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class UserAnswerController extends Controller{

    protected $user_service;

    function __construct(UserService $user_service){
        $this->user_service = $user_service;
    }
}
