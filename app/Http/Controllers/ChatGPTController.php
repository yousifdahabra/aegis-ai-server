<?php

namespace App\Http\Controllers;

use App\Services\ChatGPTService;

class ChatGPTController extends Controller{

    protected $chatgpt_service;

    public function __construct(ChatGPTService $chatgpt_service){
        $this->chatgpt_service = $chatgpt_service;
    }

    public function test_chatgpt(): string
    {
        $message = "Explain cybersecurity in simple terms.";
        $response = $this->chatgpt_service->ask_chatgpt($message);

        return response()->json(['message' => $response]);
    }
}
