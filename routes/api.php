<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;



Route::post("/expert_register", [ExpertController::class, "register"]);
Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('/get_users', [UserController::class, 'get_users']);
});
