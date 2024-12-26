<?php
namespace App\Services;

use App\Models\Test;

class TestService{

    public function store(array $data): Test
    {
        $test = new Test;
        $test->title = $data['title'];
        $test->user_id = $data['user_id'];
        $test->expert_id = $data['expert_id'];
        $test->test_state_id = $data['test_state_id'];
        $test->save();
        return $test;
    }

    public function update(array $data,$id): Test
    {
        $test = Test::findOrFail($id);
        if(!$test){
            return false;
        }
        $test->title = $data['title'];
        $test->save();
        return $test;
    }

    public function delete($id){
        $test = Test::findOrFail($id);
        if(!$test){
            return false;
        }
        $test->delete();
        return true;
    }

}
