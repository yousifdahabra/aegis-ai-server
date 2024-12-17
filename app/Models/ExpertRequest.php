<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpertRequest extends Model
{
    protected $fillable = [
        'user_id',
        'extra_informations',
        'links',
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
