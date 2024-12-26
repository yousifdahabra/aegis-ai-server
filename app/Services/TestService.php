<?php
namespace App\Services;

use App\Models\Test;

class TestService{

    public function store(array $data): Test
    {
        $test = new Test;
        $test->user_id = $data['user_id'];
        $test->expert_id = $data['expert_id'];
        $test->test_state_id = $data['test_state_id'];
        $test->save();
        return $test;
    }

}
