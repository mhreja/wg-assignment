<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class ImageController extends Controller
{
    public function index(){
    	return view('aws.index');
    }

    public function store(Request $request){
    	$path = Storage::disk('s3')->put('customer_profiles', $request->file);
    	return $path;
    }
}
