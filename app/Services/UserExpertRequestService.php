<?php
namespace App\Services;

use App\Models\UserExpertRequest;

class UserExpertRequestService{

    public function get_user_expert_requests($id = 0){
        if($id > 0){
            $user_expert_request = UserExpertRequest::find($id);
            if(!$user_expert_request){
                return false;
            }
            return $user_expert_request;
        }
        return UserExpertRequest::all();
    }

}
