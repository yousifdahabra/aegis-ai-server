<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ExpertMiddleware;



Route::post("/expert_register", [ExpertController::class, "register"]);
Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/{user_id?}', [UserController::class, 'show']);
        Route::put('/{user_id}', [UserController::class, 'update']);
        Route::delete('/{user_id}', [UserController::class, 'destroy']);
    });
    Route::prefix('experts')->group(function () {
        Route::get('/{expert_id?}', [ExpertController::class, 'show']);
        Route::delete('/{expert_id}', [ExpertController::class, 'destroy']);
    });
});
