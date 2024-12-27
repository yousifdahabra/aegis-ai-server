<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddTestRequest;
use App\Http\Requests\Test\UpdateTestRequest;
use App\Http\Resources\TestResource;
use App\Services\TestService;

class TestController extends Controller
{
    protected $testService;

    function __construct(TestService $testService){
        $this->testService = $testService;
    }

    public function show($id = 0){
        $tests = $this->testService->get_tests($id);

        if(!$tests){
            return response()->json([
                'status' => false,
                'message' => 'Expert error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get Tests successfully',
            'data' => TestResource::collection($tests),
        ], 200);
    }


    function store(AddTestRequest $request){
        $data =  $request->validated();
        $test = $this->testService->store($data);
        return response()->json([
            'status' => true,
            "data" => new TestResource($test),
            "message" => 'Test created successfully',
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
        $test = $this->testService->update($data,$id);

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
                "message" => 'Expert Error',
            ], 422);
        }
        $test = $this->testService->delete($id);

        if(!$test){
            return response()->json([
                'status' => false,
                'message' => 'Expert not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Test deleted successfully',
        ], 200);

    }


}
