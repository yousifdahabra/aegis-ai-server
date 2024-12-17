<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertRequest extends Model
{
    protected $fillable = [
        'user_id',
        'extra_informations',
        'links',
    ];

}
