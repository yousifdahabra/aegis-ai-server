<?php 
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService{
    public function register(array $data): User
    {
        $user = new User;
        $user->user_role_id = 1; 
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }
}
