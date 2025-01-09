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

    public function generate_question(string $user_data, array $previous_questions = []): string
    {
        $context = [
            ['role' => 'system',
            'content' => 'You are an assistant that generates questions for a cybersecurity test. Tailor the questions to the user\'s age and previous answers.'],
        ];

        foreach ($previous_questions as $question) {
            $context[] = ['role' => 'assistant', 'content' => $question];
        }

        $response = $this->ask_chatgpt("Generate the next question for: {$user_data}", $context);

        return $response;
    }
}
