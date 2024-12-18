<?php 
namespace App\Services;

use App\Models\ExpertRequest;
use Illuminate\Support\Facades\Hash;

class ExpertService{
    public function store(array $data): ExpertRequest
    {
        $expert = new ExpertRequest;

        return $expert;
    }
}
