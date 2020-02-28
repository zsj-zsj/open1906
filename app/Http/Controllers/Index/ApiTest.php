<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ApiTest extends Controller
{
    public function test(){
        echo "你好";
    }
}
