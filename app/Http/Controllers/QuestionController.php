<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddQuestionRequest;
use App\Http\Requests\Test\UpdateQuestionRequest;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;
use App\Services\QuestionService;

class QuestionController extends Controller{

    protected $question_service;

    function __construct(QuestionService $question_service){
        $this->question_service = $question_service;
    }

    public function show($id = 0){
        $question = $this->question_service->get_questions($id);

        if(!$question){
            return response()->json([
                'status' => false,
                'message' => 'Expert error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get Questions successfully',
            'data' => $id == 0 ? QuestionResource::collection($question):new QuestionResource($question),
        ], 200);
    }

    function store(AddQuestionRequest $request){
        $data =  $request->validated();
        $question = $this->question_service->store($data);
        return response()->json([
            'status' => true,
            "data" => new QuestionResource($question),
            "message" => 'Question created successfully',
        ], 201);
    }

    function update(UpdateQuestionRequest $request,$id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Question Error',
            ], 422);
        }

        $data =  $request->validated();
        $question = $this->question_service->update($data,$id);

        if(!$question){
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            "data" => new QuestionResource($question),
            "message" => 'Question update successfully',
        ], 201);
    }
    public function destroy($id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Question Error',
            ], 422);
        }
        $question = $this->question_service->delete($id);

        if(!$question){
            return response()->json([
                'status' => false,
                'message' => 'Question not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully',
        ], 200);

    }

}
