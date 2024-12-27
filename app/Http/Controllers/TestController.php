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
        $data =  $request->validated();
        $test = $this->testService->update($data,$id);

        return response()->json([
            'status' => true,
            "data" => new TestResource($test),
            "message" => 'Test update successfully',
        ], 201);
    }


}
