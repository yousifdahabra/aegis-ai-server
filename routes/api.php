<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use Illuminate\Support\Facades\Route;



Route::post("/expert_register", [ExpertController::class, "register"]);
Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);
