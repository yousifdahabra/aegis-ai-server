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
         
        return $experts;
    }

}
