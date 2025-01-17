<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller{

    public function show($userId, $fileName){
        $filePath = "expert_certificates/{$userId}/{$fileName}";

    }

}
