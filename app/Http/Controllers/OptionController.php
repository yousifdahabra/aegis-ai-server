<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\AddOptionsRequest;
use App\Http\Requests\Test\UpdateOptionsRequest;
use App\Http\Resources\OptionResource;
use App\Services\OptionsService;
use Illuminate\Http\Request;

class OptionController extends Controller{

    protected $option_service;

    function __construct(OptionsService $option_service){
        $this->option_service = $option_service;
    }

    public function show($question_id,$id = 0){
        $option = $this->option_service->get_options($id);

        if(!$option){
            return response()->json([
                'status' => false,
                'message' => 'Option error',
            ], 422);
        }

        return response()->json([
            'status' => true,
            'message' => 'Get Options successfully',
            'data' => $id == 0 ? OptionResource::collection($option):new OptionResource($option),
        ], 200);
    }


    function store(AddOptionsRequest $request){
        $data =  $request->validated();
        $option = $this->option_service->store($data);
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
        $option = $this->option_service->update($data,$id);

        if(!$option){
            return response()->json([
                'status' => false,
                'message' => 'Option not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            "data" => new OptionResource($option),
            "message" => 'Option update successfully',
        ], 201);
    }

    public function destroy($question_id,$id){
        if(empty($id) || !is_numeric($id)){
            return response()->json([
                'status' => false,
                "message" => 'Option Error',
            ], 422);
        }
        $option = $this->option_service->delete($id);

        if(!$option){
            return response()->json([
                'status' => false,
                'message' => 'Option not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Option deleted successfully',
        ], 200);

    }

}
