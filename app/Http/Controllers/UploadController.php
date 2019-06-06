<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;

class UploadController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function store(Request $request)
    {
    	$save_path = $request->picture->store('pictures');
    	$full_path = asset('storage/'.$save_path);
    	
    	return [
    		'status' => '1',
    	    'fullpath' => $full_path , 
    	    'savepath' => $save_path,
    	];
    	
    }
}
