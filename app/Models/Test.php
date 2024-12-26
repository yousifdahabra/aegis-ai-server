<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Test extends Model
{

    protected $fillable = [
        'user_id',
        'expert_id',
        'test_state_id',
        'title',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
