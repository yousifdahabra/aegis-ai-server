<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{

    protected $fillable = [
        'test_id',
        'question_types_id',
        'previous_question_id',
        'title',
    ];

    public function question_type(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }

}
