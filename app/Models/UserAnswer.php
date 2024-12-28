<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserAnswer extends Model{

    protected $fillable = [
        'user_id',
        'question_id',
        'option_answer',
    ];

    public function question(): HasOne
    {
        return $this->hasOne(Question::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(Question::class);
    }

}
