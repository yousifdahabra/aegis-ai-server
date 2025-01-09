<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatGPTService;

class ChatGPTController extends Controller{

    protected $chatgpt_service;
    protected $questions_service;

    public function __construct(ChatGPTService $chatgpt_service, QuestionsService $questions_service){
        $this->chatgpt_service = $chatgpt_service;
        $this->questions_service = $questions_service;
    }

    public function generate_question(Request $request){

        $user_data = $request->input('user_data', '');
        $previous_questions = $request->input('previous_questions', []);

        $response = $this->chatgpt_service->generate_question($user_data, $previous_questions);

        if (!$response['status']) {
            return response()->json($response, 422);
        }

        return response()->json($response);
    }

    public function generate_feedback(Request $request){

        $user_data = $request->input('user_data', '');
        $questions_with_answers = $request->input('questions_with_answers', []);

        $response = $this->chatgpt_service->generate_feedback($user_data, $questions_with_answers);

        if (!$response['status']) {
            return response()->json($response, 422);
        }

        return response()->json($response);
    }
}
