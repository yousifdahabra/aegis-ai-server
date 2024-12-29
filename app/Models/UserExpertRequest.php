<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExpertRequest extends Model{

    protected $fillable = [
        'user_id',
        'expert_id',
        'about_user',
        'user_note',
        'links',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
