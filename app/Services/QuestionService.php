<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Option;

class QuestionService{

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
        $question->save();

        foreach ($data['options'] as $option_data) {
            $option = new Option;
            $option->question_id = $question->id;
            $option->title = $option_data['title'];
            $option->save();
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

}
