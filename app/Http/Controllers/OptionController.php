<?php

namespace App\Http\Controllers;

use App\Services\OptionsService;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    protected $option_service;

    function __construct(OptionsService $option_service){
        $this->option_service = $option_service;
    }


}
