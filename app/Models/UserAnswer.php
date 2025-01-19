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

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(Question::class);
    }

}
