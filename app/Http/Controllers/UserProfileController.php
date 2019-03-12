<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\User;
class UserProfileController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function index()
    {
    	$id = Auth::id();
    	$user = Auth::user()->favorite($id)->message()->find($id);
    	return new User($user);
    }

    public function update(Request $request)
    {
    	$request->validate([
    		'name' => 'nullable|min:2|max:30',
    	]);
    	$data = array_filter($request->all(), 'strlen');
    	if(!empty($data))
    	{
    		$user = Auth::user()->update($data);
    	}
    	return response()->json('success', 200);
    }
}
