<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddTestRequest;
use App\Http\Requests\Test\UpdateTestRequest;
use App\Http\Resources\TestListResource;
use App\Http\Resources\TestResource;
use App\Services\ChatGPTService;
use App\Services\QuestionService;
use App\Services\TestService;

class TestController extends Controller{

    protected $test_service;
    protected $chatgpt_service;
    protected $question_service;

    function __construct(TestService $test_service, ChatGPTService $chatgpt_service, QuestionService $question_service){
        $this->test_service = $test_service;
        $this->chatgpt_service = $chatgpt_service;
        $this->question_service = $question_service;
    }

    public function show($id = 0){
        $tests = $this->test_service->get_tests($id);

        if(!$tests){
            return response()->json([
                'status' => false,
                'message' => 'Test error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get Tests successfully',
            'data' => TestResource::collection($tests),
        ], 200);
    }
    public function get_tests_list(){
        $user = auth()->user();

        $tests = $this->test_service->get_tests_list($user);

        if(!$tests){
            return response()->json([
                'status' => false,
                'message' => 'Test error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get Tests successfully',
            'data' => TestListResource::collection($tests),
        ], 200);
    }


    function store(AddTestRequest $request){
        $data =  $request->validated();
        $test = $this->test_service->store($data);

        $user = auth()->user();
        $user_data = "{$user->name}, age " . (date('Y') - $user->birth_year) . ", role: " . ($user->is_admin() ? 'Admin' : ($user->is_expert() ? 'Expert' : 'User'));
        $response = $this->chatgpt_service->generate_question($user_data);

        if (!$response['status']) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to generate the first question',
            ], 422);
        }

        $question_data = $response['data'];
        $question_data['test_id'] = $test->id;
        $question_data['previous_question_id'] = null;

        $question = $this->question_service->store($question_data);

        return response()->json([
            'status' => true,
            'data' => [
                'test' => new TestResource($test),
                'question' => $question,
            ],
            'message' => 'Test created successfully with the first question generated.',
        ], 201);


    }

    function update(UpdateTestRequest $request,$id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Test Error',
            ], 422);
        }

        $data =  $request->validated();
        $test = $this->test_service->update($data,$id);

        if(!$test){
            return response()->json([
                'status' => false,
                'message' => 'Test not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            "data" => new TestResource($test),
            "message" => 'Test update successfully',
        ], 201);
    }

    public function destroy($id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Test Error',
            ], 422);
        }
        $test = $this->test_service->delete($id);

        if(!$test){
            return response()->json([
                'status' => false,
                'message' => 'Test not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Test deleted successfully',
        ], 200);

    }


}
