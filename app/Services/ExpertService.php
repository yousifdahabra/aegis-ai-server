<?php 
namespace App\Services;

use App\Models\ExpertRequest;
use Illuminate\Support\Facades\Hash;

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
}
