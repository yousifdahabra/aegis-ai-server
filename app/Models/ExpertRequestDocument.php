<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertRequestDocument extends Model
{
    protected $fillable = [
        'expert_request_id',
        'file_path',
    ];

}
