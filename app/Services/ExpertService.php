<?php
namespace App\Services;

use App\Models\ExpertRequestDocument;
use App\Models\ExpertRequest;
use App\Models\User;
use Illuminate\Support\Str;

class ExpertService{
    public function store(array $data): ExpertRequest
    {
        $expert = new ExpertRequest;
        $expert->user_id = $data['user_id'] ?? 1;
        $expert->links = $data['links'];
        $expert->extra_informations = $data['extra_informations'];
        $expert->save();

        return $expert;
    }
    public function store_files(array $data): array
    {
        $documents = $data['documents'];
        $folder_path = 'expert_certificates/' . $data['user_id'];
        $experts = array();
        foreach ($documents as $file) {
            $new_name = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($folder_path, $new_name, 'private');
            $expert_file = new ExpertRequestDocument;
            $expert_file->expert_request_id = $data['expert_request_id'];
            $expert_file->file_path = $path;
            $experts[] = $expert_file->save();

        }

        return $experts;
    }
    public function delete($id): bool
    {
        $expert = ExpertRequest::where('user_id',$id);
        if(!$expert){
            return false;
        }
        $expert->delete();

        return true;
    }

    public function accept_request($id){
        $request = ExpertRequest::find($id);
        if(!$request){
            return false;
        }
        $user = User::find($request->user_id);
        $user->blocked = 0;
        $user->save();

        $request->state = 1;
        $request->save();

        return $request;
    }
}
