<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    protected $fillable = [
        'user_id',
        'expert_id',
        'test_state_id',
        'title',
    ];

}
