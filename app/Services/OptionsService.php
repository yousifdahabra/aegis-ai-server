<?php

use App\Models\Option;

Class OptionsService{

    public function store(array $data): Option
    {
        $option = new Option;
        $option->title = $data['title'];
        $option->save();
        return $option;
    }

}
