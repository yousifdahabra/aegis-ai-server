<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class);
    }

    public function expert_requests(){
        return $this->hasMany(ExpertRequest::class);
    }

    public function tests(){
        return $this->hasMany(Test::class);
    }

    public function expert_tests(){
        return $this->hasMany(Test::class,'expert_id');
    }

}
