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
        return UserExpertRequest::where('state', 0)->get();
    }

    public function store(array $data): UserExpertRequest
    {
        $user_expert_request = new UserExpertRequest;
        $user_expert_request->user_id = $data['user_id'];
        $user_expert_request->expert_id = 0;
        $user_expert_request->about_user = $data['about_user'];
        $user_expert_request->user_note = $data['user_note'];
        $user_expert_request->links = $data['links'];
        $user_expert_request->save();
        return $user_expert_request;
    }

    public function update(array $data,$id){
        $user_expert_request = UserExpertRequest::find($id);
        if(!$user_expert_request){
            return false;
        }
        $user_expert_request->about_user = $data['about_user'];
        $user_expert_request->user_note = $data['user_note'];
        $user_expert_request->links = $data['links'];
        $user_expert_request->save();
        return $user_expert_request;
    }

    public function delete($id){
        $user_expert_request = UserExpertRequest::find($id);
        if(!$user_expert_request){
            return false;
        }
        $user_expert_request->delete();
        return true;
    }

}
