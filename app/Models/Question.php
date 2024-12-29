<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model{

    protected $fillable = [
        'test_id',
        'question_type_id',
        'previous_question_id',
        'title',
    ];

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function question_type(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

    public function tests(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function user_answer(): HasOne
    {
        return $this->hasOne(UserAnswer::class);
    }


}
