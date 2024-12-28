<?php

use App\Models\Option;

Class OptionsService{

    public function store(array $data): Option
    {
        $option = new Option;

        return $option;
    }

}
