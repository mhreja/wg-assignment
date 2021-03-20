<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class TestController extends Controller
{
    public function index(){
    	// echo assets_path();
    	if(Storage::disk('public')->put('abcd1.txt', 'Hello world')){
    		echo 1;
    	} else echo 0;
    }
}
