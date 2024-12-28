<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswer extends Model{

    protected $fillable = [
        'user_id',
        'question_id',
        'option_answer',
    ];

}
