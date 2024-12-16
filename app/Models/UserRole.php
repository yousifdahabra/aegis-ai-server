<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserRole extends Model
{
    protected $fillable = [
        'title',
    ];
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
