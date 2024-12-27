<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserRole extends Model{
    protected $fillable = [
        'title',
    ];

    public const ADMIN = 1;
    public const EXPERT = 2;
    public const USER = 3;

    public function users(){
        return $this->hasMany(User::class);
    }

}
