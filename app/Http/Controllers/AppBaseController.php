<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppBaseController extends Controller
{
    protected $response = [
        'status' => 0,
        'msg' => "",
        'error' => "",
        'error_array' => [],
        'data' => [],
    ];
}
