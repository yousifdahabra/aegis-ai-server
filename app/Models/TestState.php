<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestState extends Model{

    protected $fillable = [
        'title',
    ];

    public function tests(){
        return $this->hasMany(Test::class);
    }

}
