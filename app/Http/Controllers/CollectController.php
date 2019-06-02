<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\User;

class CollectController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:api');
    }

    public function index(Request $request)
	{
		$user = Auth::user();
		$type = $request->type?? 'collects';
        //return $user->getCollects($type);
		return User::collection($user->getCollects($type));
    }

    public function store(Request $request)
    {
    	$res = Auth::user()->updateCollection($request->user_id);
    	return response()->json($res, 200);
    }
}
