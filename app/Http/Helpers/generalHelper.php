<?php

use App\Models\Page;
use App\Models\Script;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


if (!function_exists('edit_icon')) {
    function edit_icon()
    {
        return '<i class="fas fa-edit" style="color:blue; font-size:20px;"></i>';
    }
}


if (!function_exists('delete_icon')) {
    function delete_icon()
    {
        return '<i class="fas fa-trash" style="color:red; font-size:20px;"></i>';
    }
}
