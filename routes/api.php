<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserAnswerController;
use App\Http\Controllers\UserExpertRequestController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ExpertMiddleware;



Route::post("/expert_register", [ExpertController::class, "register"]);
Route::post("/register", [UserController::class, "register"]);
Route::post("/login", [UserController::class, "login"]);
Route::post("/check-token-expiry", [UserController::class, "check_token_expiry"]);

Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/{id?}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('experts')->group(function () {
        Route::get('/{id?}', [ExpertController::class, 'show']);
        Route::delete('/{id}', [ExpertController::class, 'destroy']);
    });

    Route::prefix('tests')->group(function () {
        Route::get('/get-list', [TestController::class, 'get_tests_list']);
        Route::get('/{id?}', [TestController::class, 'show']);
        Route::post('/', [TestController::class, 'store']);
        Route::put('/{id}', [TestController::class, 'update']);
        Route::delete('/{id}', [TestController::class, 'destroy']);
    });
    Route::prefix('questions')->group(function () {
        Route::get('/{id?}', [QuestionController::class, 'show']);
        Route::post('/', [QuestionController::class, 'store']);
        Route::put('/{id}', [QuestionController::class, 'update']);
        Route::delete('/{id}', [QuestionController::class, 'destroy']);
    });
    Route::prefix('options')->group(function () {
        Route::get('/{questions_id}/{id?}', [OptionController::class, 'show']);
        Route::post('/', [OptionController::class, 'store']);
        Route::put('/{questions_id}/{id}', [OptionController::class, 'update']);
        Route::delete('/{questions_id}/{id}', [OptionController::class, 'destroy']);
    });

    Route::prefix('user_answers')->group(function () {
        Route::get('/{id?}', [UserAnswerController::class, 'show']);
        Route::post('/', [UserAnswerController::class, 'store']);
        Route::put('/{id}', [UserAnswerController::class, 'update']);
        Route::delete('/{id}', [UserAnswerController::class, 'destroy']);
    });

    Route::prefix('user_expert_requests')->group(function () {
        Route::get('/{id?}', [UserExpertRequestController::class, 'show']);
        Route::post('/', [UserExpertRequestController::class, 'store']);
        Route::put('/{id}', [UserExpertRequestController::class, 'update']);
        Route::delete('/{id}', [UserExpertRequestController::class, 'destroy']);
    });
});

Route::middleware([ExpertMiddleware::class])->prefix('expert')->group(function () {
    Route::prefix('tests')->group(function () {
        Route::get('/get-list', [TestController::class, 'get_tests_list']);
        Route::get('/{id?}', [TestController::class, 'show']);
        Route::post('/', [TestController::class, 'store']);
        Route::put('/{id}', [TestController::class, 'update']);
        Route::delete('/{id}', [TestController::class, 'destroy']);
    });
    Route::prefix('questions')->group(function () {
        Route::get('/{id?}', [QuestionController::class, 'show']);
        Route::post('/', [QuestionController::class, 'store']);
        Route::put('/{id}', [QuestionController::class, 'update']);
        Route::delete('/{id}', [QuestionController::class, 'destroy']);
    });
    Route::prefix('options')->group(function () {
        Route::get('/{questions_id}/{id?}', [OptionController::class, 'show']);
        Route::post('/', [OptionController::class, 'store']);
        Route::put('/{questions_id}/{id}', [OptionController::class, 'update']);
        Route::delete('/{questions_id}/{id}', [OptionController::class, 'destroy']);
    });

    Route::prefix('user_answers')->group(function () {
        Route::get('/{id?}', [UserAnswerController::class, 'show']);
        Route::post('/', [UserAnswerController::class, 'store']);
        Route::put('/{id}', [UserAnswerController::class, 'update']);
        Route::delete('/{id}', [UserAnswerController::class, 'destroy']);
    });

    Route::prefix('user_expert_requests')->group(function () {
        Route::get('/{id?}', [UserExpertRequestController::class, 'show']);
        Route::post('/', [UserExpertRequestController::class, 'store']);
        Route::put('/{id}', [UserExpertRequestController::class, 'update']);
        Route::delete('/{id}', [UserExpertRequestController::class, 'destroy']);
    });
});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::prefix('user_expert_requests')->group(function () {
        Route::get('/{id?}', [UserExpertRequestController::class, 'show']);
        Route::post('/', [UserExpertRequestController::class, 'store']);
    });
    Route::prefix('user_answers')->group(function () {
        Route::get('/{id?}', [UserAnswerController::class, 'show']);
        Route::post('/', [UserAnswerController::class, 'store']);
    });
    Route::prefix('options')->group(function () {
        Route::get('/{questions_id}/{id?}', [OptionController::class, 'show']);
        Route::post('/', [OptionController::class, 'store']);
    });
    Route::prefix('questions')->group(function () {
        Route::get('/{id?}', [QuestionController::class, 'show']);
        Route::post('/', [QuestionController::class, 'store']);
    });
    Route::prefix('tests')->group(function () {
        Route::get('/get-list', [TestController::class, 'get_tests_list']);
        Route::get('/{id?}', [TestController::class, 'show']);
        Route::post('/', [TestController::class, 'store']);
    });
    Route::prefix('users')->group(function () {
        Route::get('/{id?}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
    });
});
