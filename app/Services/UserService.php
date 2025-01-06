<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserService{
    public function register(array $data,$role = 3): User
    {
        $user = new User;
        $user->user_role_id = $role;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone_number = $data['phone_number'];
        $user->birth_year = date('Y') - $data['birth_year'];;
        $user->password = Hash::make($data['password']);
        $user->save();
        return $user;
    }

    public function update($data,$id){
        $user = User::find($id);
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
        $user = User::find($id);
        if(!$user){
            return false;
        }
        $user->delete();

        return true;
    }

    public function get_users($id = 0,$role = 3){
        if($id > 0){
            return User::find($id);
        }
        return User::all()->where('user_role_id',$role);
    }



}
