<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddQuestionRequest;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Request;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    protected $question_service;

    function __construct(QuestionService $question_service){
        $this->question_service = $question_service;
    }

    function store(AddQuestionRequest $request){
        $data =  $request->validated();
        $test = $this->question_service->store($data);
        return response()->json([
            'status' => true,
            "data" => new QuestionResource($test),
            "message" => 'Question created successfully',
        ], 201);
    }

}
