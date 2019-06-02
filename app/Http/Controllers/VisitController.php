<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Auth;
use App\Http\Resources\VisitResource;

class VisitController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function index(Request $request)
    {
    	$user = $request->user();
    	if($request->type == 'viewers')
    	{
    		$datas = $user->viewers()->with('viewed.post')->paginate();
    		return VisitResource::collection($datas);
    	}
    	$datas = $user->viewed()->with('viewers.post')->paginate();
    	return VisitResource::collection($datas);
    }
}
