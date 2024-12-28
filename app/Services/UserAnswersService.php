<?php
namespace App\Services;

use App\Models\UserAnswer;


class UserAnswersService{

    public function store(array $data): UserAnswer
    {
        $test = new UserAnswer;
        $test->user_id = $data['user_id'];
        $test->question_id = $data['question_id'];
        $test->option_answer = $data['option_answer'];
        $test->save();
        return $test;
    }

}
