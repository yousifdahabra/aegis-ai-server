<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    protected $question_service;

    function __construct(QuestionService $question_service){
        $this->question_service = $question_service;
    }

}
