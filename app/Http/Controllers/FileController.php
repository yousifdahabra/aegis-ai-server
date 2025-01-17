<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller{

    public function show($userId, $fileName){
        $filePath = "expert_certificates/{$userId}/{$fileName}";

        if (!Storage::disk('private')->exists($filePath)) {
            return response()->json([
                'status' => false,
                'message' => 'File not found',
            ], 404);

        }

        return response()->file(Storage::disk('private')->path($filePath), [
            'Content-Disposition' => 'inline',
        ]);
    }

    public function download($userId, $fileName){
        $filePath = "expert_certificates/{$userId}/{$fileName}";

         return response()->download(Storage::disk('private')->path($filePath));
    }

}
