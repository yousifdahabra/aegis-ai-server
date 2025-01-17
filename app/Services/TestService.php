<?php
namespace App\Services;

use App\Models\Test;
use App\Models\Question;

class TestService{

    public function get_tests($id = 0){
        if($id > 0){
            $test = Test::find($id);
            if(!$test){
                return false;
            }
            return $test;
        }
        return Test::all();
    }

    public function get_tests_list($user){

        if ($user->user_role_id === 3) {
            return Test::with(['user', 'test_state', 'questions'])
                ->where('user_id', $user->id)
                ->orderBy('id', 'desc')
                ->get();
        }

        return Test::with(['user', 'test_state', 'questions'])->orderBy('id', 'desc')->get();
    }

    public function store(array $data): Test
    {
        $test = new Test;
        $test->title = $data['title'];
        $test->user_id = $data['user_id'];
        $test->expert_id = $data['expert_id'] ?? 0;
        $test->test_state_id = $data['test_state_id'];
        $test->save();
        return $test;
    }

    public function update(array $data,$id){
        $test = Test::find($id);
        if(!$test){
            return false;
        }
        $test->title = $data['title'];
        $test->save();
        return $test;
    }

    public function delete($id){
        $test = Test::find($id);
        if(!$test){
            return false;
        }
        $test->delete();
        return true;
    }
    public function update_grade( $grade,$id){
        $test = Test::find($id);
        if(!$test){
            return false;
        }
        $test->security_grade = $grade;
        $test->test_state_id = 3;
        $test->save();
        return $test;
    }
    public function get_user_tests_list($user_id){

        return Test::with(['user', 'test_state', 'questions'])
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get();

    }
    public function get_list_solutions($test_id){

        return Question::with('user_answer')
        ->where('test_id', $test_id)
        ->get();

    }

}
