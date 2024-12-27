<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddTestRequest;
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


    }

}
