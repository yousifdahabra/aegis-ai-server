<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Option;

class QuestionService{

    protected $options_service;

    public function __construct(OptionsService $options_service){
        $this->options_service = $options_service;
    }


    public function get_questions($id = 0){
        if($id > 0){
            $question = Question::with('options')->find($id);
            if(!$question){
                return false;
            }
            return $question;
        }
        return Question::with('options')->get();
    }

    public function store(array $data): Question
    {
        $question = new Question;
        $question->test_id = $data['test_id'] ?? 0;
        $question->question_type_id = $data['type_question'];
        $question->previous_question_id = $data['previous_question_id'] ?? 0;
        $question->title = $data['question'];
        $question->question_provider_id = $data['question_provider_id'] ?? Question::GPT;
        $question->use_question_id = $data['use_question_id'] ?? 0;
        $question->gpt_question_id = $data['gpt_question_id'] ?? 0;
        $question->save();

        $options = [];
        if (!empty($data['options']) && is_array($data['options'])) {
            foreach ($data['options'] as $option_title) {
                $option = $this->options_service->store([
                    'title' => $option_title,
                    'question_id' => $question->id,
                ]);
                $options[] = $option;
            }
        }

        if (in_array($question->question_type_id, [2, 3])) {
            $question->options = $options;
        }

        return $question;
    }


    public function update(array $data, $id){
        $question = Question::find($id);
        if (!$question) {
            return false;
        }

        $question->test_id = $data['test_id'] ?? $question->test_id;
        $question->question_type_id = $data['question_type_id'] ?? $question->question_type_id;
        $question->previous_question_id = $data['previous_question_id'] ?? $question->previous_question_id;
        $question->title = $data['title'] ?? $question->title;
        $question->save();

        $db_options_id = $question->options->pluck('id')->toArray();
        $data_options_id = array_column($data['options'], 'id');

        $delete_ids = array_diff($db_options_id, $data_options_id);

        foreach ($data['options'] as $option_data) {
            if (isset($option_data['id'])) {
                $option = Option::find($option_data['id']);
                if ($option) {
                    $option->title = $option_data['title'];
                    $option->save();
                }
            } else {
                $option = new Option;
                $option->question_id = $question->id;
                $option->title = $option_data['title'];
                $option->save();
            }
        }

        foreach ($delete_ids as $option_id) {
            $option = Option::find($option_id);
            if ($option) {
                $option->delete();
            }
        }

        return $question;
    }

    public function delete($id){
        $question = Question::find($id);
        if (!$question) {
            return false;
        }

        $question->options()->delete();

        $question->delete();

        return true;
    }

    public function get_previous_questions(int $test_id): array
    {
        $questions = Question::with(['options', 'user_answer'])->where('test_id', $test_id)->get();

        $formatted_questions = [];
        foreach ($questions as $question) {
            $entry = [
                'id' => $question->id,
                'user_answer' => $question->user_answer?->option_answer ?? [],
            ];

            if (in_array($question->question_type_id, [2, 3])) {
                $entry['options'] = $question->options->pluck('title')->toArray();
            }

            $formatted_questions[] = $entry;
        }

        return $formatted_questions;
    }
}
