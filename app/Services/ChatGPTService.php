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
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',//gpt-4
            'messages' => array_merge(
                $context,
                [['role' => 'user', 'content' => $message]]
            ),
        ]);

        return $response['choices'][0]['message']['content'] ?? '';
    }
}
