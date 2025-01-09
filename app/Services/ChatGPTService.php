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

    protected function get_system_message(): array{
        return [
            'role' => 'system',
            'content' => 'You are a cybersecurity expert and test engineer. Your role is to create adaptive questions and provide feedback for cybersecurity assessments.

            - Respond exclusively in JSON format:
              {
                "type_question": <question_type_id>,
                "id": <question_id>,
                "question": "<question_title>",
                "options": [<option_1>, <option_2>, ...] (if applicable),
                "user_answer": [<selected_option_1>, <selected_option_2>, ...] (if applicable)
              }
            - Use question IDs and user answers for context:
              - Example input for previous questions:
                {"id": 101, "user_answer": ["Option 1"]}
              - Generate the next question or feedback based on these references.
            - Question Types:
              - 1: Input (open-ended).
            - Generate meaningful, scenario-based questions tailored to user details (age, role, experience).
            - Highlight common user mistakes and cybersecurity misconceptions.
            - For finished tests, analyze answers, summarize strengths/weaknesses, and provide actionable feedback in JSON:
              {
                "result": {
                  "analysis": "<feedback_summary>",
                  "score": "<user_score>"
                }
              }.
              '
        ];
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
