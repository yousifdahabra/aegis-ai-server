<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\TestController;

use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ExpertMiddleware;



Route::post("/expert_register", [ExpertController::class, "register"]);
Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);

Route::middleware([ExpertMiddleware::class])->group(function () {
    Route::middleware([ExpertMiddleware::class])->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/{id?}', [UserController::class, 'show']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });

        Route::prefix('experts')->group(function () {
            Route::get('/{id?}', [ExpertController::class, 'show']);
            Route::delete('/{id}', [ExpertController::class, 'destroy']);
        });
    });
    Route::prefix('tests')->group(function () {
        Route::post('/', [TestController::class, 'store']);
    });

});
