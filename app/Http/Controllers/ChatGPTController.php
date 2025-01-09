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

        $user = auth()->user();
        $user_data = "{$user->name}, age " . (date('Y') - $user->birth_year) . ", role: " . ($user->is_admin() ? 'Admin' : ($user->is_expert() ? 'Expert' : 'User'));

        $previous_questions = $request->input('previous_questions', []);

        $response = $this->chatgpt_service->generate_question($user_data, $previous_questions);

        if (!$response['status']) {
            return response()->json([
                'status' => false,
                'message' => 'Question Error',
            ], 422);
        }

        $question_data = $response['data'];
        $question_data['test_id'] = $request->input('test_id');
        $question_data['previous_question_id'] = $previous_questions ? end($previous_questions)['id'] : null;

        $this->questions_service->store_question($question_data);

        return response()->json([
            'status' => true,
            'data' => $response['data'],
            'message' => 'Question generated successfully.',
        ], 201);
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
