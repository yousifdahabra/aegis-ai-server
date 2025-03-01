<?php

namespace App\Services;

use Exception;
use OpenAI;

class ChatGPTService{

    protected $client;
    protected $model;

    public function __construct(){
        $this->client = OpenAI::client(config('services.openai.key'));
        $this->model = config('services.openai.model', 'gpt-3.5-turbo');
    }

    public function ask_chatgpt(string $message, array $context = [],$question = true)
    {
        $max_retries = 2;
        $attempt = 0;
        while ($attempt < $max_retries) {
            $attempt++;

            try {
                $response = $this->client->chat()->create([
                    'model' => $this->model,
                    'messages' => array_merge(
                        $context,
                        [['role' => 'user', 'content' => $message]]
                    ),
                ]);

                $content = $response['choices'][0]['message']['content'] ?? '';
                $decoded = json_decode($content, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Invalid JSON response.");
                }

                $question ? $this->is_valid_json_structure($decoded) : $this->is_valid_feedback_structure($decoded);

                return [
                    'status' => true,
                    'data' => $decoded
                ];
            } catch (Exception $e) {
                if ($attempt >= $max_retries) {
                    return $this->handle_error($e);
                }
            }
        }

        return $this->handle_error("Failed to get valid response after {$max_retries} attempts.");
    }

    protected function get_system_message(): array{
        return [
            'role' => 'system',
            'content' => '
            You are a cybersecurity expert and educator. Your role is to create simple, adaptive, and interactive questions to assess the user’s habits and behaviors regarding online safety and provide actionable feedback.
            - main thing you must do is you must give a question based on their previous questions
            - voice interaction in this type your question must be interactive because you will get answers based on his voice user using STT
            - Use different types of questions (e.g., input, multiple choice, checkbox) to engage the user and tailor the assessment.
            - Audience: Everyday users with minimal technical knowledge.
            - Goal: Evaluate and improve the user’s understanding of online risks (e.g., phishing, weak passwords, data theft, scams, secure browsing) and help them adopt safer practices.
            - Examples of habits to assess:
                - I was hoping you would not use my examples you create a new one from them
                - Password strength (e.g., "How strong is your password?" or "Do you reuse passwords across accounts?").
                - Email usage (e.g., "Do you remember your recovery email?" or "Have you ever received a suspicious email?").
                - App downloads (e.g., "Do you download apps from outside the official app store?").
                - Secure browsing (e.g., "How often do you check for HTTPS on websites?").
                - and more other you must find more
            - Avoid repeating questions already asked  .
            - How will start:
                - During the test, all types of questions will be used, then after use all of them then the question types will be set base on what you see  without repeating the same type in sequence.
                - for example first question will be 1 input then 2 Multiple-choice then 3 Multiple-choice then 6 voice interaction after that you can set base on your previous questions information

            - Respond exclusively in JSON format:
              {
                "type_question": <question_type_id>,
                "gpt_question_id": <question_id>,
                "question": "<question_title>",
                "options": [<option_1>, <option_2>, ...] (if applicable),
                "user_answer": [<selected_option_1>, <selected_option_2>, ...] (if applicable)
              }
            - Use question IDs and user answers for context:
              - Example input for previous questions:
                {"id": 101, "type_question": 1, "user_answer": ["Option 1"]}
              - Generate the next question or feedback based on these references.
            - Question Types:
                - 1: Input (open-ended).
                - 2: Multiple-choice with single answer.
                - 3: Multiple-choice with multiple answers.
                - 6: voice interaction (open-ended)(without choice).
            - Generate meaningful, scenario-based questions tailored to user details (age, role, experience).
            - Highlight common user mistakes and cybersecurity misconceptions.
            - For finished tests, analyze answers, summarize strengths/weaknesses, and provide actionable feedback in JSON:
              {
                "result": {
                  "analysis": "<feedback_summary>",
                  "score": "<user_score>%"
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
                $context[] = ['role' => 'assistant', 'content' => $entry];
            }
            $prompt = "The test is finished for the user: {$user_data}. Analyze the user's answers and provide feedback in the following JSON format:
                {
                    \"result\": {
                        \"analysis\": \"<feedback_summary>\",
                        \"score\": \"<user_score>\"
                    }
                }";
            return $this->ask_chatgpt($prompt, $context,false);
        } catch (Exception $e) {
            return $this->handle_error($e);
        }
    }

    protected function is_valid_json_structure(array $data): bool
    {
        $required_keys = ['type_question', 'gpt_question_id', 'question'];

        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new Exception("Missing required key: {$key}");
            }
        }

        $requires_options = [2, 3];
        if (in_array($data['type_question'], $requires_options)) {
            if (!isset($data['options']) || !is_array($data['options']) || empty($data['options'])) {
                throw new Exception("Options are required and must be a non-empty array for type_question: {$data['type_question']}");
            }
        }

        if (isset($data['user_answer']) && !is_array($data['user_answer'])) {
            throw new Exception("user_answer must be an array if provided.");
        }

        return true;
    }
    protected function is_valid_feedback_structure(array $data): bool
    {
        $required_keys = ['result'];

        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $data)) {
                throw new Exception("Missing required key: {$key}");
            }
        }

        if (!isset($data['result']['analysis']) || !is_string($data['result']['analysis'])) {
            throw new Exception("Invalid or missing analysis in feedback result.");
        }

        if (!isset($data['result']['score']) || !is_string($data['result']['score'])) {
            throw new Exception("Invalid or missing score in feedback result.");
        }

        return true;
    }

    protected function handle_error($error): array
    {
        $message = 'An unexpected error occurred.';

        if ($error instanceof Exception) {
            $message = $error->getMessage() ?: $message;
        } elseif (is_string($error)) {
            $message = $error;
        }

        return [
            'status' => false,
            'message' => $message,
        ];
    }

}
