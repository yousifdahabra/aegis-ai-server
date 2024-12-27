<?php

use App\Models\Question;
use App\Models\Option;

class QuestionService{

    public function store(array $data): Question
    {
        $question = new Question;
        $question->test_id = $data['test_id'];
        $question->question_types_id = $data['question_types_id'];
        $question->previous_question_id = $data['previous_question_id'] ?? 0;
        $question->title = $data['title'];
        $question->save();

        foreach ($data['options'] as $option_data) {
            $option = new Option;
            $option->question_id = $question->id;
            $option->title = $option_data['title'];
            $option->save();
        }

        return $question;
    }

}
