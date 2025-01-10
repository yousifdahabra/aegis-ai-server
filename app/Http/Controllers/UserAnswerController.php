<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddUserAnswersRequest;
use App\Http\Requests\Test\UpdateUserAnswersRequest;
use App\Http\Resources\UserAnswerResource;
use App\Services\ChatGPTService;
use App\Services\UserAnswersService;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class UserAnswerController extends Controller{

    protected $user_answers_service;
    protected $questions_service;
    protected $chatgpt_service;

    function __construct(UserAnswersService $user_answers_service, QuestionService $questions_service, ChatGPTService $chatgpt_service){
        $this->user_answers_service = $user_answers_service;
        $this->questions_service = $questions_service;
        $this->chatgpt_service = $chatgpt_service;
    }

    public function show($id = 0){
        $user_answers_service = $this->user_answers_service->get_user_answers($id);

        if(!$user_answers_service){
            return response()->json([
                'status' => false,
                'message' => 'User Answer error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get User Answer successfully',
            'data' => $id == 0 ? UserAnswerResource::collection($user_answers_service):new UserAnswerResource($user_answers_service),
        ], 200);
    }

    function store(AddUserAnswersRequest $request){
        $data =  $request->validated();
        $user_answers_service = $this->user_answers_service->store($data);
        return response()->json([
            'status' => true,
            "data" => new UserAnswerResource($user_answers_service),
            "message" => 'User Answer created successfully',
        ], 201);
    }

    function update(UpdateUserAnswersRequest $request,$id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'User Answer Error',
            ], 422);
        }

        $data =  $request->validated();
        $user_answers_service = $this->user_answers_service->update($data,$id);

        if(!$user_answers_service){
            return response()->json([
                'status' => false,
                'message' => 'User Answer not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            "data" => new UserAnswerResource($user_answers_service),
            "message" => 'User Answer update successfully',
        ], 201);
    }

    public function destroy($id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'User Answer Error',
            ], 422);
        }
        $user_answers_service = $this->user_answers_service->delete($id);

        if(!$user_answers_service){
            return response()->json([
                'status' => false,
                'message' => 'User Answer not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Answer deleted successfully',
        ], 200);
    }
    public function store_with_gpt(AddUserAnswersRequest $request){
        $data = $request->validated();
        $user = auth()->user();
        $question_id = $data['question_id'];
        $question_info = $this->questions_service->get_questions($question_id);
        $test_id = $question_info['test_id'];//get_questions


         $user_answer = $this->user_answers_service->store($data);

         if (!$user_answer) {
            return response()->json([
                 'status' => false,
                 'message' => 'User Answer creation failed',
             ], 422);
         }

        $previous_questions = $this->questions_service->get_previous_questions($test_id, $user->id);
        $previous_questions_with_answers = array_map(function ($item) {
            return json_encode($item);
        }, $previous_questions);

        $user_data = "{$user->name}, age " . (date('Y') - $user->birth_year)  ;
        $previous_questions_with_answers;
        if (count($previous_questions_with_answers) >= 3) {

            return $feedback_response = $this->chatgpt_service->generate_feedback($user_data, $previous_questions_with_answers);

            if (!$feedback_response['status']) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to generate feedback',
                ], 422);
            }

            return response()->json([
                'status' => true,
                'finish' => true,
                'message' => 'Test is complete',
                'data' => $feedback_response['data'],
            ], 200);
        }

        $response = $this->chatgpt_service->generate_question($user_data, $previous_questions_with_answers);

        if (!$response['status']) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to generate the next question',
            ], 422);
        }

        $question_data = $response['data'];
        $question_data['test_id'] = $test_id;
        $question_data['previous_question_id'] = $data['question_id'];
        $this->questions_service->store($question_data);

        return response()->json([
            'status' => true,
            'finish' => false,
            'message' => 'User Answer saved and next question generated',
            'data' => $response['data'],
        ], 201);
    }

}


