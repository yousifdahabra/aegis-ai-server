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

    public function store(array $data): UserExpertRequest
    {
        $user_expert_request = new UserExpertRequest;
        $user_expert_request->user_id = $data['user_id'];
        $user_expert_request->expert_id = $data['expert_id'];
        $user_expert_request->about_user = $data['about_user'];
        $user_expert_request->user_note = $data['user_note'];
        $user_expert_request->save();
        return $user_expert_request;
    }

}
