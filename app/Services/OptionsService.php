<?php

namespace App\Services;
use App\Models\Option;

Class OptionsService{

    public function store(array $data): Option
    {
        $option = new Option;
        $option->question_id = $data['question_id'];
        $option->title = $data['title'];
        $option->save();
        return $option;
    }

    public function update(array $data, $id){
        $option = Option::find($id);
        if (!$option) {
            return false;
        }
        $option->title = $data['title'];
        $option->save();
        return $option;
    }

    public function delete($id){
        $option = Option::find($id);
        if (!$option) {
            return false;
        }
        $option->delete();

        return true;
    }

}
