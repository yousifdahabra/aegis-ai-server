<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $fillable = [
        'test_id',
        'question_types_id',
        'previous_question_id',
        'title',
    ];

}
