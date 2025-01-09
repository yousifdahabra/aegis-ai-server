<?php

namespace App\Services;

use OpenAI;

class ChatGPTService{

    protected $client;
    protected $model;

    public function __construct(){
        $this->client = OpenAI::client(config('services.openai.key'));
        $this->model = config('services.openai.model', 'gpt-3.5-turbo');
    }

    public function ask_chatgpt(string $message, array $context = []): array
    {
        try {
            $response = $this->client->chat()->create([
                'model' =>  $this->model,
                'timeout' => 10,
                'messages' => array_merge(
                    $context,
                    [['role' => 'user', 'content' => $message]]
                ),
            ]);

            return [
                'status' => true,
                'data' => $response['choices'][0]['message']['content'] ?? ''
            ];
        } catch (Exception $e) {
            return $this->handle_error($e);
        }
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


    public function generate_question(string $user_data, array $previous_questions = []): array
    {
        try {
            $context = [$this->get_system_message()];

            foreach ($previous_questions as $question) {
                $context[] = ['role' => 'assistant', 'content' => $question];
            }

            return $this->ask_chatgpt("Generate the next question for: {$user_data}", $context);
        } catch (Exception $e) {
            return $this->handle_error($e);
        }
    }

    public function generate_feedback(string $user_data, array $questions_with_answers): array
    {
        try {
            $context = [$this->get_system_message()];

            foreach ($questions_with_answers as $entry) {
                $context[] = ['role' => 'assistant', 'content' => json_encode($entry)];
            }

            return $this->ask_chatgpt("Analyze the test results for: {$user_data}", $context);
        } catch (Exception $e) {
            return $this->handle_error($e);
        }
    }
    protected function handle_error(Exception $e): array
    {
        $message = 'An unexpected error occurred.';

        if ($e->getMessage()) {
            $message = $e->getMessage();
        }

        return [
            'status' => false,
            'message' => $message,
        ];
    }

}
