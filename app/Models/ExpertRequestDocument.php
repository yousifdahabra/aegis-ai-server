<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpertRequestDocument extends Model{
    protected $fillable = [
        'expert_request_id',
        'file_path',
    ];

    public function expert_request(): BelongsTo
    {
        return $this->belongsTo(ExpertRequest::class);
    }

}
