<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DefStudio\Telegraph\Facades\Telegraph;

class BaseController extends Controller
{
    public function info(){
        return dd(1);
    }
}
