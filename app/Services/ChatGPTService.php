<?php

namespace App\Services;

use OpenAI;

class ChatGPTService{

    protected $client;

    public function __construct(){
        $this->client = OpenAI::client(config('services.openai.key'));
    }

    public function ask_chatgpt(string $message, array $context = []): string
    {
        return "";
    }
}
