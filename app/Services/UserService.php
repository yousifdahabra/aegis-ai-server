<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService{
    public function register(array $data): User
    {
        $user = new User;
        $user->user_role_id = 3;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    public function update($data,$id): User
    {
        $user = User::findOrFail($id);
        if(!$user){
            return false;
        }
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    public function delete($id){
        $user = User::findOrFail($id);
        if(!$user){
            return false;
        }
        $user->delete();

        return true;
    }

    public function get_users($id = 0,$role = 3){
        if($id > 0){
            return User::findOrFail($id);
        }
        return User::all()->where('user_role_id',$role);
    }



}
