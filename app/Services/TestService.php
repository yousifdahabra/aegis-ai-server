<?php
namespace App\Services;

use App\Models\Test;

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

    public function get_tests_list(){
        return Test::with(['user', 'test_state', 'questions'])->get();
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

}
