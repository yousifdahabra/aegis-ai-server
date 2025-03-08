<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler{

    public function register(){
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception){
        return response()->json([
            'error' => $exception->getMessage(),
            'status' => $exception->getCode() ?: 500
        ], 500);
    }
}
