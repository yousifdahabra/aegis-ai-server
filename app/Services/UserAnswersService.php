<?php
namespace App\Services;

use App\Models\UserAnswer;


class UserAnswersService{

    public function store(array $data): UserAnswer
    {
        $user_answer = new UserAnswer;
        $user_answer->user_id = $data['user_id'];
        $user_answer->question_id = $data['question_id'];
        $user_answer->option_answer = $data['option_answer'];
        $user_answer->save();
        return $user_answer;
    }

    public function update(array $data,$id){
        $user_answer = UserAnswer::find($id);
        if(!$user_answer){
            return false;
        }
        $user_answer->option_answer = $data['option_answer'];
        $user_answer->save();
        return $user_answer;
    }


}
