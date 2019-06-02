<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index(){
    	return json_encode(['q' => 'sdasd', 'h' => 'sdfsdfsdf']);
    }
    
    
}
