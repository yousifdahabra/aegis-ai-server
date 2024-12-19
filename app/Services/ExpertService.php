<?php 
namespace App\Services;

use App\Models\ExpertRequestDocument;
use App\Models\ExpertRequest;
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
            $expert_file->file_path = $path;
            $experts[] = $expert_file->save();
    
        }
        
        return $experts;
    }

}
