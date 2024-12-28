<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAnswerResource;
use App\Services\UserAnswersService;
use Illuminate\Http\Request;

class UserAnswerController extends Controller{

    protected $user_answers_service;

    function __construct(UserAnswersService $user_answers_service){
        $this->user_answers_service = $user_answers_service;
    }

    public function show($id = 0){
        $user_answers_service = $this->user_answers_service->get_user_answers($id);

        if(!$user_answers_service){
            return response()->json([
                'status' => false,
                'message' => 'Expert error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get Tests successfully',
            'data' => UserAnswerResource::collection($user_answers_service),
        ], 200);
    }

}
