<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject{

    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role_id',
        'birth_year',
        'active',
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

    //From JWT
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    //From JWT
    public function getJWTCustomClaims(){
        return [];
    }

    public function is_admin(): bool
    {
        return $this->role_id === UserRole::ADMIN;
    }

    public function is_expert(): bool
    {
        return $this->role_id === UserRole::EXPERT;
    }

    public function is_normal_user(): bool
    {
        return $this->role_id === UserRole::USER;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class);
    }

    public function user_answers(){
        return $this->hasMany(UserAnswer::class);
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

    public function user_requests_expert(){
        return $this->hasMany(UserExpertRequest::class);
    }

    public function user_expert_requests(){
        return $this->hasMany(UserExpertRequest::class,'expert_id');
    }

}
