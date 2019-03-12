<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
    	$path = $request->picture->store('pictures');
    	$full_path = asset('storage/'.$path);
    	return response()->json(['status' => 1, 'path' => $full_path, 'savepath' => $path]);
    }
}
