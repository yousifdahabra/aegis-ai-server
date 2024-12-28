<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddOptionsRequest;
use App\Http\Requests\Test\UpdateOptionsRequest;
use App\Http\Resources\OptionResource;
use App\Services\OptionsService;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    protected $option_service;

    function __construct(OptionsService $option_service){
        $this->option_service = $option_service;
    }

    function store(AddOptionsRequest $request,$question_id){
        $data =  $request->validated();
        $option = $this->option_service->store($data,$question_id);
        return response()->json([
            'status' => true,
            "data" => new OptionResource($option),
            "message" => 'Option created successfully',
        ], 201);
    }

    function update(UpdateOptionsRequest $request,$question_id,$id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Option Error',
            ], 422);
        }
        $data =  $request->validated();
    }


}
