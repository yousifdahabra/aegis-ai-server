<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model{
    protected $fillable = [
        'question_id',
        'title',
    ];
}
